<?php
declare(strict_types=1);

namespace Course\Api\Order;


use Course\Api\Exception\NotFoundException;
use Course\Api\Model\OrderModel;
use Nette\Database\Table\Selection;

final class OrderFactory
{

    public function __construct(private OrderModel $orderModel){}

    public function getById(int $idOrder):Order{
        return $this->create($this->orderModel->getById($idOrder));
    }

    public function getBySerialNumber(int $idRetailer, int $serialNumber):Order{
        return $this->create($this->orderModel->getBySerialNumber($idRetailer, $serialNumber));
    }

    public function getByRetailerOrderId(int $idRetailer, string $retailerOrderId):Order{
        return $this->create($this->orderModel->getByRetailerOrderId($idRetailer, $retailerOrderId));
    }


    private function create(Selection $selection):Order{
        $row = $selection->fetch();
        if(!$row){
            throw new NotFoundException("Order was not found");
        }
        return new Order($row->toArray());
    }

}