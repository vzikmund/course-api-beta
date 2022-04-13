<?php
declare(strict_types=1);

namespace Course\Api\Retailer;


use Course\Api\Exception\BadRequestException;
use Course\Api\Utils\Crypto;

final class Retailer
{

    public function __construct(private array $row)
    {
    }

    public function getId(): int
    {
        return $this->row["id"];
    }

    public function isActive(): bool
    {
        return $this->row["is_active"] === 1;
    }

    /**
     * Compare Api_key column with header parameter
     * @param string|null $headerKey
     * @return bool
     * @throws BadRequestException
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     * @throws \Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException
     */
    public function isValid(?string $headerKey): bool
    {

        if (is_null($headerKey)) {
            throw new BadRequestException("Header key Api-Key is not set");
        }

        return $this->getApiKey() === $headerKey;

    }

    /**
     * Decrypted Api-key
     * @return string
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     * @throws \Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException
     */
    public function getApiKey(): string
    {
        return Crypto::decrypt($this->row["api_key"]);
    }


}