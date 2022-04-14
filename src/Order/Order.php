<?php
declare(strict_types=1);

namespace Course\Api\Order;


use Course\Api\Utils\Crypto;
use Nette\Utils\DateTime;

final class Order
{

    /**
     * @param array $row
     */
    public function __construct(private array $row)
    {
    }


    /**
     * Get pin code in plain text
     * @return string
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     * @throws \Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException
     */
    public function getPin(): string
    {
        return Crypto::decrypt($this->row["pin"]);
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->row["created_at"];
    }

    /**
     * Create receipt to response payload
     * @return array
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     * @throws \Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException
     */
    public function toArray(): array
    {

        return [
            "retailer_id" => $this->row["retailer_id"],
            "product_id" => $this->row["product_id"],
            "order_id" => $this->row["retailer_order_id"],
            "product_name" => $this->row["product_name"],
            "pin" => $this->getPin(),
            "serial_number" => $this->row["serial_number"],
            "cost" => $this->toHundredths($this->row["cost"]),
            "currency_code" => $this->row["currency_code"],
            "recommended_price" => [
                [
                    "end_price" => $this->toHundredths($this->row["recommended_price"]),
                    "currency_code" => $this->row["recommended_price_currency_code"]
                ]
            ],
            "redeem_information" => $this->row["redeem_information"],
            "created_at" => $this->getCreatedAt()->format("Y-m-d\TH:i:sP")
        ];

    }

    /**
     * @param int|float|string $number
     * @return int
     */
    private function toHundredths(int|float|string $number):int{
        return (int)round($number*100);
    }


}