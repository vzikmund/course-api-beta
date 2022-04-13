<?php
declare(strict_types=1);

namespace Course\Api\Product;


final class RetailerProduct extends Product
{


    public function getCost():float{
        return $this->row["cost"];
    }

    public function getCostCurrencyCode():int{
        return $this->row["cost_currency_code"];
    }

    public function isActive():bool{
        return $this->row["is_active"] === 1;
    }



}