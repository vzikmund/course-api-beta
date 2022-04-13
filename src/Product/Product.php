<?php
declare(strict_types=1);

namespace Course\Api\Product;


class Product
{

    public function __construct(protected array $row){}

    public function getId():int{
        return $this->row["id"];
    }

    public function getName():string{
        return $this->row["name"];
    }

    public function getRecommendedPrice():string{
        return $this->row["recommended_price"];
    }

    public function getRecommendedPriceCurrencyCode():int{
        return $this->row["recommended_price_currency_code"];
    }

    public function getRedeemInformation():string{
        return $this->row["redeem_information"];
    }


}