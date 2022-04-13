<?php
declare(strict_types=1);

namespace Course\Api\Exception;


use Throwable;

final class ForbiddenException extends ApiException
{

    public function __construct(string $message, int $code = 4, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getHttpCode(): int
    {
        return 403;
    }

}