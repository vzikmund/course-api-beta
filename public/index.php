<?php
require_once  dirname(__DIR__) . "/vendor/autoload.php";

$container = \Course\Api\Bootstrap::boot();

$api = $container->getByType(\Course\Api\Api::class);

Flight::route('POST /order', [$api, "createOrder"]);
Flight::route('GET /serial-number/@idRetailer:[0-9]+/@serialNumber:[0-9]+', [$api, "getOrderBySerialNumber"]);
Flight::route('GET /order-id/@idRetailer:[0-9]+/@idRetailerOrder', [$api, "getOrderByRetailerOrderId"]);

Flight::map('notFound', [$api, "notFound"]);

Flight::start();