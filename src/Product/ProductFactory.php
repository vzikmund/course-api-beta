<?php
declare(strict_types=1);

namespace Course\Api\Product;


use Course\Api\Exception\BadRequestException;
use Course\Api\Exception\ForbiddenException;
use Course\Api\Exception\NotFoundException;
use Course\Api\Model\ProductModel;

final class ProductFactory
{

    public function __construct(private ProductModel $productModel){}


    /**
     * @param int $idRetailer
     * @param int $idProduct
     * @return RetailerProduct
     * @throws NotFoundException
     * @throws ForbiddenException
     */
    public function getRetailerProduct(int $idRetailer, int $idProduct):RetailerProduct{

        $row = $this->productModel->getRetailerProduct($idRetailer, $idProduct)->fetch();
        if(!$row){
            throw new NotFoundException("Association between retailer and product not found");
        }

        $retailerProduct = new RetailerProduct((array)$row);

        if(!$retailerProduct->isActive()){
            throw new ForbiddenException("Retailer is no longer available to order this product");
        }

        return $retailerProduct;

    }

}