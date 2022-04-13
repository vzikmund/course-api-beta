<?php
declare(strict_types=1);

namespace Course\Api\Exception;


use Throwable;

final class NotFoundException extends ApiException
{

    public function __construct(string $message, int $code = 1, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     * @return int
     */
    public function getHttpCode(): int
    {
        return 404;
    }

}