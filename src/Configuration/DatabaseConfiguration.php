<?php declare(strict_types=1);

namespace SOAPSimpleProject\Configuration;

use SOAPSimpleProject\Exception\ConfigurationException;

class DatabaseConfiguration extends BaseConfiguration
{
    private $dsn = '';
    private $userName = '';
    private $password = '';
    private $shardingTable = '';
    private $shardsCount = '';

    public function __construct()
    {
        parent::__construct();

        $this->validateConfig($this->config);
        $databaseConfig = $this->config['database'];

        $this->setDsn('mysql:host=' . $databaseConfig['host'] .';dbname='  . $databaseConfig['database_name']);
        $this->setUserName($databaseConfig['username']);
        $this->setPassword($databaseConfig['password']);
        $this->setShardingTable($databaseConfig['sharding_table']);
        $this->setShardsCount($databaseConfig['shards_count']);
    }

    public function getDsn(): string
    {
        return $this->dsn;
    }

    public function setDsn(string $dsn): void
    {
        $this->dsn = $dsn;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getShardingTable(): string
    {
        return $this->shardingTable;
    }

    public function setShardingTable(string $shardingTable): void
    {
        $this->shardingTable = $shardingTable;
    }

    public function getShardsCount(): string
    {
        return $this->shardsCount;
    }

    public function setShardsCount(string $shardsCount): void
    {
        $this->shardsCount = $shardsCount;
    }

    /**
     * @throws ConfigurationException
     */
    private function validateConfig(array $config): void
    {
        if (!isset($config['database'],
            $config['database']['host'],
            $config['database']['sharding_table'],
            $config['database']['shards_count'],
            $config['database']['database_name'],
            $config['database']['username'],
            $config['database']['password'])) {
            throw new ConfigurationException('DB Configuration is broken');
        }
    }
}