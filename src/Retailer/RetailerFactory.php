<?php
declare(strict_types=1);

namespace Course\Api\Retailer;


use Course\Api\Exception\BadRequestException;
use Course\Api\Exception\NotFoundException;
use Course\Api\Exception\UnauthorizedException;
use Course\Api\Model\RetailerModel;
use Nette\Http\Request;


final class RetailerFactory
{

    public function __construct(
        private RetailerModel $retailerModel,
        private Request $httpRequest
    ){}


    public function createById(int $idRetailer):Retailer{
        $row = $this->retailerModel->getById($idRetailer)->fetch();

        if(!$row){
            throw new NotFoundException("Retailer ID '$idRetailer' not found");
        }
        $retailer = new Retailer($row->toArray());
        $headerKey = $this->httpRequest->getHeader("api-key");

        if(!$retailer->isActive()){
            throw new BadRequestException("Retailer is not active");
        }


        if(!$retailer->isValid($headerKey)){
            throw new UnauthorizedException("Header key Api-Key is invalid");
        }

        return $retailer;
    }
}