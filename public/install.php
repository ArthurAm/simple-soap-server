<?php declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';

$shardsCount = readline('How many shards we will create: ');

use SOAPSimpleProject\Configuration\DatabaseConfiguration;
use SOAPSimpleProject\Database\DB;

$configuration = new DatabaseConfiguration();
$connection = new DB($configuration);

$connection->createPartitionTable((int) $shardsCount);

echo 'Success!';
