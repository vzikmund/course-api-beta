<?php
declare(strict_types=1);

namespace Course\Api\Logger;


use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Nette\Utils\Strings;

final class LoggerFactory
{

    public function __construct(private string $logDir)
    {
    }


    public function create(string $fileName, string $name = "api"):Logger
    {
        $dateFormat = "Y-m-d H:i:s";
        $output = "[%datetime%] %level_name%: %message% %context% \n";

        # if string doesnt have file type, add one
        if (!Strings::endsWith($fileName, ".log")) {
            $fileName .= ".log";
        }

        $formatter = new LineFormatter($output, $dateFormat);
        $stream = new StreamHandler($this->logDir . "/{$fileName}");
        $stream->setFormatter($formatter);

        $logger = new Logger($name);
        return $logger->pushHandler($stream);

    }

}