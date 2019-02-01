<?php declare(strict_types=1);

namespace SOAPSimpleProject\Configuration;

use SOAPSimpleProject\Exception\ConfigurationException;

class SOAPServerConfiguration extends BaseConfiguration
{
    /** @var string */
    private $wsdl;

    /** @var array */
    private $options;

    public function __construct()
    {
        parent::__construct();

        $this->validateConfig($this->config);
        $SOAPConfig = $this->config['SOAP'];

        if (isset($SOAPConfig['wsdl'])) {
            $this->wsdl = $SOAPConfig['wsdl'];
            unset($SOAPConfig['wsdl']);
        }

        $this->options = $SOAPConfig;
    }

    public function getWsdl(): ?string
    {
        return $this->wsdl;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @throws ConfigurationException
     */
    private function validateConfig(array $config): void
    {
        if (!isset($config['SOAP'], $config['SOAP']['location'], $config['SOAP']['uri']))
        {
            throw new ConfigurationException('SOAP Configuration is broken');
        }
    }
}