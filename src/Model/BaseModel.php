<?php
declare(strict_types=1);

namespace Course\Api\Model;


use Nette\Database\Explorer;

abstract class BaseModel
{


    public function __construct(protected Explorer $explorer)
    {
    }

}