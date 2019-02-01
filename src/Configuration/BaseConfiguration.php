<?php declare(strict_types=1);

namespace SOAPSimpleProject\Configuration;

use SOAPSimpleProject\Exception\ConfigurationException;

class BaseConfiguration implements ConfigurationInterface
{
    private const DEFAULT_CONFIG_PATH = __DIR__ . '/../../config/configuration.ini';

    protected $config = [];

    /**
     * @throws ConfigurationException
     */
    public function __construct(string $configPath = '')
    {
        $configPath = '' === $configPath ? self::DEFAULT_CONFIG_PATH : $configPath;
        $config = parse_ini_file($configPath, true);

        if (false !== $config) {
            $this->config = $config;
        } else {
            throw new ConfigurationException('Unable to load configuration from  ' . $configPath);
        }
    }
}