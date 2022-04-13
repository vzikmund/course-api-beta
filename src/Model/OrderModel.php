<?php
declare(strict_types=1);

namespace Course\Api\Model;

use Course\Api\Utils\Crypto;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Utils\Random;

final class OrderModel extends BaseModel
{

    /**
     * @param int $idRetailer
     * @param int $idProduct
     * @param float $cost
     * @param int $currencyCode
     * @param string $pin
     * @param string $retailerOrderId
     * @return int
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     * @throws \Exception
     */
    public function createOrder(
        int    $idRetailer,
        int    $idProduct,
        float  $cost,
        int    $currencyCode,
        string $pin,
        string $retailerOrderId): int
    {

        $row = $this->explorer->table("order")->insert(
            [
                "retailer_id" => $idRetailer,
                "product_id" => $idProduct,
                "cost" => $cost,
                "currency_code" => $currencyCode,
                "pin" => Crypto::encrypt($pin),
                "serial_number" => $this->getUniqueSerialNumber(),
                "retailer_order_id" => $retailerOrderId
            ]
        );

        return ($row instanceof ActiveRow) ? $row->getPrimary() : $row;

    }

    /**
     * Generate serial number unique for whole database
     * @return int
     * @throws \Exception
     */
    private function getUniqueSerialNumber(): int
    {

        $x = 0;
        do {
            $firstNumber = rand(0, 9);
            $otherNumbers = Random::generate(8, "0-9");
            $serialNumber = (int)($firstNumber . $otherNumbers);
            $x++;

            # preventing endless loop
            if ($x >= 5) {
                throw new \Exception("Too many ({$x}) serial number loops");
            }

        } while ($this->serialNumberExists($serialNumber));
        return $serialNumber;
    }

    /**
     * Check if serial number exists in database
     * @param int $serialNumber
     * @return bool
     */
    private function serialNumberExists(int $serialNumber): bool
    {
        $count = $this->explorer->table("order")
            ->where("serial_number", $serialNumber)
            ->count("id");

        return $count > 0;
    }

    /**
     * @param int $idOrder
     * @return Selection
     */
    public function getById(int $idOrder):Selection
    {
        # in join we need to specify which id should be used in condition
        # if column is present in more than one table
        return $this->getOrder()->where("order.id", $idOrder);
    }

    /**
     * @param int $idRetailer
     * @param int $serialNumber
     * @return Selection
     */
    public function getBySerialNumber(int $idRetailer, int $serialNumber):Selection{
        # serial number column is present only in one joined table
        # we dont need to specify table name
        return $this->getOrder()
            ->where("retailer_id", $idRetailer)
            ->where("serial_number", $serialNumber);
    }

    /**
     * @param int $idRetailer
     * @param string $retailerOrderId
     * @return Selection
     */
    public function getByRetailerOrderId(int $idRetailer, string $retailerOrderId):Selection{
        # retailer_id = ? AND retailer_order_id = ?
        return $this->getOrder()
            ->where("retailer_id", $idRetailer)
            ->where("retailer_order_id", $retailerOrderId);
    }


    /**
     * Base query for getting information about order
     * @return Selection
     */
    private function getOrder(): Selection
    {
        return $this->explorer->table("order")
            ->select("order.*")
            ->select("product.name AS product_name, product.recommended_price, product.currency_code AS recommended_price_currency_code")
            ->select("product.vendor.redeem_information");
    }


}