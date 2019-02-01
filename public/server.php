<?php declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';

ini_set('soap.wsdl_cache_enabled', '0');

use SOAPSimpleProject\Configuration\DatabaseConfiguration;
use SOAPSimpleProject\Configuration\SOAPServerConfiguration;
use SOAPSimpleProject\SoapServer\Server;
use SOAPSimpleProject\Database\DB;

$DBconfiguration = new DatabaseConfiguration();
$db = new DB($DBconfiguration);

$SOAPConfiguration = new SOAPServerConfiguration();
$server = new Server($SOAPConfiguration, $db);