<?php declare(strict_types=1);

namespace SOAPSimpleProject\SoapServer;

use SOAPSimpleProject\Configuration\SOAPServerConfiguration;

class Server
{
    /** @var \SoapServer */
    public $server;

    public function __construct(SOAPServerConfiguration $configuration, object $handler)
    {
        $this->server = new \SoapServer($configuration->getWsdl(), $configuration->getOptions());
        $this->server->setObject($handler);
        $this->server->handle();
    }
}