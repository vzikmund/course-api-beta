<?php
declare(strict_types=1);

namespace Course\Api\Wrapper;


use Course\Api\Logger\LoggerFactory;

final class WrapperFactory
{

    public function __construct(private LoggerFactory $loggerFactory){}

    public function wrap(\Closure $body):void{
        (new Wrapper($this->loggerFactory->create("api")))->wrap($body);
    }

}