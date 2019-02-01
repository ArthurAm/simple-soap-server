<?php declare(strict_types=1);

namespace SOAPSimpleProject\Database;

use SOAPSimpleProject\Configuration\DatabaseConfiguration;

class DB
{
    /** @var \PDO  */
    private $pdo;

    /** @var string  */
    private $shardingTable;

    /** @var string  */
    private $shardsCount;

    public function __construct(DatabaseConfiguration $databaseConfiguration) {
        try {
            $this->pdo = new \PDO(
                $databaseConfiguration->getDsn(),
                $databaseConfiguration->getUserName(),
                $databaseConfiguration->getPassword(),
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {}

        $this->shardingTable = $databaseConfiguration->getShardingTable();
        $this->shardsCount = $databaseConfiguration->getShardsCount();
    }

    public function createPartitionTable(int $shardsCount): void
    {
        $table = $this->shardingTable;

        $sql = "DROP TABLE IF EXISTS {$table};";
        $sql .= "CREATE TABLE IF NOT EXISTS {$table} (ID INT( 11 ) ,
            soap_text VARCHAR( 255 ) NOT NULL) 
            PARTITION BY HASH(ID) PARTITIONS {$shardsCount};";

        $this->pdo->exec($sql);
    }

    public function insertToShard(int $id, string $soapText): string
    {
        $table = $this->shardingTable;
        $soapText = $this->pdo->quote($soapText);

        $sql = "INSERT INTO {$table} (id, soap_text) VALUES ({$id},{$soapText});";

        $this->pdo->exec($sql);

        return 'Succesfully inserted id ' . $id . ' to ' . $this->findShardNumber($id) . ' shard number';
    }

    public function getById(int $id): string
    {
        $table = $this->shardingTable;
        $shard = $this->findShardNumber($id);

        $sql = "SELECT soap_text FROM {$table} PARTITION (p{$shard}) WHERE ID = {$id}";
        $result = $this->pdo->query($sql)->fetch();

        if (isset($result['soap_text'])) {
            return 'You get id ' . $id . ' with text ' . $result['soap_text'] . ' from shard number ' . $shard;
        }

        return 'Cannot find data with id ' . $id;
    }

    public function findShardNumber(int $id): int
    {
        return $id % $this->shardsCount;
    }
}