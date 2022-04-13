<?php
declare(strict_types=1);

namespace Course\Api;



use Nette\Bootstrap\Configurator;
use Nette\DI\Container;
use Nette\Neon\Neon;
use Nette\StaticClass;
use Nette\Neon\Exception;

final class Bootstrap
{

    /**
     * Allowed environment values inside of /env.neon
     * @var string[]
     */
    private const ALLOWED_ENVS = ["local", "prod"];

    use StaticClass;

    /**
     * @return Container
     * @throws Exception
     * @throws \Exception
     */
    public static function boot(): Container
    {

        $appDir = dirname(__DIR__);

        $envFile = $appDir . "/env.neon";
        if(!file_exists($envFile)){
            throw new \Exception("Env.neon file not found at path '/env.neon'");
        }

        $env = Neon::decodeFile($appDir . "/env.neon");
        if(!in_array($env, self::ALLOWED_ENVS)){
            throw new \Exception("Unknown exception. Use " . join(" OR ", self::ALLOWED_ENVS));
        }

        $configurator = new Configurator();
        $configurator->setTempDirectory($appDir . "/temp");
        $configurator
            ->addConfig($appDir . "/config/common.neon")
            ->addConfig($appDir . "/config/{$env}.neon")
            ->addParameters(["absPath" => $appDir, "logDir" => $appDir . "/log"]);

        return $configurator->createContainer();

    }


}