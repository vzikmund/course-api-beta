<?php
declare(strict_types=1);

namespace Course\Api\Exception;


use Throwable;

final class BadRequestException extends ApiException
{

    public function __construct(string $message, int $code = 2, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getHttpCode(): int
    {
        return 400;
    }

}