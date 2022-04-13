<?php
declare(strict_types=1);

namespace Course\Api\Model;


use Nette\Database\ResultSet;

final class ProductModel extends BaseModel
{


    /**
     * Getting associated retailer product
     *
     * @param int $idRetailer
     * @param int $idProduct
     * @return ResultSet
     */
    public function getRetailerProduct(int $idRetailer, int $idProduct): ResultSet
    {

        $sql = "SELECT
                       rp.cost,
                       rp.is_active,
                       rp.currency_code AS cost_currency_code,
                       p.id,
                       p.name,
                       p.recommended_price,
                       p.currency_code AS recommanded_price_currency_code,
                       v.redeem_information
                FROM retailer_product rp
                INNER JOIN product p ON p.id = rp.product_id
                INNER JOIN vendor v ON v.id = p.vendor_id
                WHERE rp.product_id = ? AND rp.retailer_id = ?";

        return $this->explorer->query($sql, $idProduct, $idRetailer);

    }

}