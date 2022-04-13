<?php
declare(strict_types=1);

namespace Course\Api\Utils;


use Nette\StaticClass;

final class Crypto
{

    private const PASSWORD = "kT4s>nE[V<x2cvT!";

    use StaticClass;

    /**
     * @param string $plainText
     * @return string
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public static function encrypt(string $plainText):string{
        return \Defuse\Crypto\Crypto::encryptWithPassword($plainText, self::PASSWORD, true);
    }

    /**
     * @param string $cipher
     * @return string
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     * @throws \Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException
     */
    public static function decrypt(string $cipher):string{
        return \Defuse\Crypto\Crypto::decryptWithPassword($cipher, self::PASSWORD, true);
    }
}