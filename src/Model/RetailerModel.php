<?php
declare(strict_types=1);

namespace Course\Api\Model;


use Nette\Database\Table\Selection;

final class RetailerModel extends BaseModel
{

    public function getById(int $idRetailer): Selection
    {
        /*
         * SAME AS
         * SELECT * FROM retailer WHERE id = $id
         *
         * # using parametrized SQL query with Explorer
         * $this->explorer->query("SELECT * FROM retailer WHERE id = ?", $idRetailer);
         */
        return $this->explorer->table("retailer")->where("id", $idRetailer);
    }

}