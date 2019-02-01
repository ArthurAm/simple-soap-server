<?php declare(strict_types=1);
header('Content-Type: text/xml');
ini_set('soap.wsdl_cache_enabled', '0');

$client = new SoapClient(null, [
    'trace' => 1,
    'connection_timeout' => 5000,
    'cache_wsdl' => WSDL_CACHE_NONE,
    'keep_alive' => false,
    'uri' => '/',
    'location' => '/server.php'
]);

$client->insertToShard(42, 'lorem ipsum dolor sit amet');
$client->getById(42);
echo $client->__getLastResponse();
