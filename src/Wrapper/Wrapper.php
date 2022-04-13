<?php
declare(strict_types=1);

namespace Course\Api\Wrapper;


use Course\Api\Exception\ApiException;
use Monolog\Logger;
use Nette\Database\UniqueConstraintViolationException;

final class Wrapper
{

    /**
     * @var array
     */
    private array $loggedData;

    public function __construct(private Logger $logger){

        $request=  \Flight::request();

        $this->loggedData = [
            "ip" => $request->ip,
            "ip_proxy" => $request->proxy_ip,
            "method" => $request->method,
            "request_url" => $request->url,
            "data" => $request->data->getData()
        ];
    }

    /**
     * Call body and send response
     * @param \Closure $body
     * @return void
     */
    public function wrap(\Closure $body):void{

        $method = "error";
        try{
            $this->logger->info("-->", $this->loggedData);
            $result = $body();
            $httpCode = 200;
            $method = "info";
        } catch (ApiException $e){
            $result = [
                "error" => $e->getMessage(),
                "error_code" => $e->getCode()
            ];
            $httpCode = $e->getHttpCode();
        } catch (UniqueConstraintViolationException $e){
            $result = [
                "error" => "Duplicate data encountered",
                "error_code" => 2
            ];
            $httpCode = 400;
        } catch (\Exception $e){
            $result = [
                "error" => "Internal server Error",
                "error_code" => 0
            ];
            $httpCode = 500;
        }

        $this->logger->$method("<-- $httpCode", $result);

        \Flight::json($result, $httpCode);

    }

}