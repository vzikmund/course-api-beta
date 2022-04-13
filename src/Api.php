<?php
declare(strict_types=1);

namespace Course\Api;


use Course\Api\Exception\BadRequestException;
use Course\Api\Exception\NotFoundException;
use Course\Api\Order\OrderFactory;
use Course\Api\Product\ProductFactory;
use Course\Api\Retailer\RetailerFactory;
use Course\Api\Wrapper\WrapperFactory;
use Nette\Utils\Arrays;
use Nette\Utils\Strings;
use Nette\Utils\Validators;

class Api
{


    public function __construct(
        private WrapperFactory  $wrapper,
        private RetailerFactory $retailerFactory,
        private ProductFactory  $productFactory,
        private Repository      $repository,
        private OrderFactory    $orderFactory
    )
    {
    }

    /**
     * Create new order of PIN code
     * @return void
     */
    public function createOrder(): void
    {

        $body = function (): array {

            $errors = [];

            $dataCollection = \Flight::request()->data->getData();

            $idRetailer = Arrays::get($dataCollection, "retailer_id", null);
            $idProduct = Arrays::get($dataCollection, "product_id", null);
            $idOrder = Arrays::get($dataCollection, "order_id", null);

            # if retailer ID is null or is not integer
            if (!$idRetailer || !Validators::isNumericInt($idRetailer)) {
                $errors[] = "parameter 'retailer_id' must be INT";
            }

            # if product ID is null or is not integer
            if (!$idProduct || !Validators::isNumericInt($idProduct)) {
                $errors[] = "parameter 'product_id' must be INT";
            }

            # order_id not exists
            if (!$idOrder) {
                $errors[] = "parameter 'order_id' is required";
            } else {
                # order_id exists, validating format
                # if string contains character which is not listed, it is not valid
                if (Strings::match($idOrder, "/[^a-zA-Z_0-9]/i")) {
                    $errors[] = "parameter 'order_id' contains forbidden characters";
                }

                # check length of order id
                if (Strings::length($idOrder) > 20) {
                    $errors[] = "max length of parameter 'order_id' is 20 characters";
                }
            }

            if (count($errors) > 0) {
                throw new BadRequestException(join(", ", $errors));
            }

            $retailer = $this->retailerFactory->createById((int)$idRetailer);
            $product = $this->productFactory->getRetailerProduct($retailer->getId(), (int)$idProduct);

            $id = $this->repository->createOrder($retailer, $product, $idOrder);
            return $this->orderFactory->getById($id)->toArray();
        };

        $this->wrapper->wrap($body);

    }

    /**
     * Get order by its serial number
     *
     * @param int|string $idRetailer
     * @param int|string $serialNumber
     * @return void
     */
    public function getOrderBySerialNumber(int|string $idRetailer, int|string $serialNumber): void
    {
        $body = function () use ($idRetailer, $serialNumber): array {
            $retailer = $this->retailerFactory->createById((int)$idRetailer);
            return $this->orderFactory->getBySerialNumber($retailer->getId(), (int)$serialNumber)->toArray();
        };
        $this->wrapper->wrap($body);
    }

    /**
     * Get order by its retailer order id
     * @param int|string $idRetailer
     * @param string $idOrderRetailer
     * @return void
     */
    public function getOrderByRetailerOrderId(int|string $idRetailer, string $idOrderRetailer): void
    {
        $body = function () use ($idRetailer, $idOrderRetailer): array {
            $retailer = $this->retailerFactory->createById((int)$idRetailer);
            return $this->orderFactory->getByRetailerOrderId($retailer->getId(), $idOrderRetailer)->toArray();
        };
        $this->wrapper->wrap($body);
    }

    /**
     * Mapping not found page
     * @return void
     */
    public function notFound(): void
    {
        $this->wrapper->wrap(fn() => throw new NotFoundException("Method or endpoint not found"));
    }

}