<?php
declare(strict_types=1);

namespace Course\Api;


use Course\Api\Model\OrderModel;
use Course\Api\Product\RetailerProduct;
use Course\Api\Retailer\Retailer;
use Nette\Utils\Random;

final class Repository
{

    public function __construct(private OrderModel $orderModel)
    {
    }


    /**
     * Creates order and return id of new order
     * @param Retailer $retailer
     * @param RetailerProduct $retailerProduct
     * @param string $retailerOrderId
     * @return int
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public function createOrder(Retailer $retailer, RetailerProduct $retailerProduct, string $retailerOrderId)
    {


        $pin = [];
        for ($x = 1; $x <= 3; $x++) {
            # generate random chunks
            $pin[] = Random::generate(4, "0-9A-Z");
        }
        # join chunks by hyphen
        $pin = join("-", $pin);

        return $this->orderModel->createOrder(
            $retailer->getId(),
            $retailerProduct->getId(),
            $retailerProduct->getCost(),
            $retailerProduct->getCostCurrencyCode(),
            $pin,
            $retailerOrderId
        );

    }

}