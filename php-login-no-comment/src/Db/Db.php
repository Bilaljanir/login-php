<?php

namespace PhpLogin\Db;

use PDO;
use PDOException;
use PDOStatement;

class Db
{
    private PDO $pdo;

    private array $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];

    public function __construct()
    {
        $dsn = "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}";

        try {
            $this->pdo = new PDO(
                $dsn,
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD'],
                $this->options
            );
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function run(string $queryString, array $params = null): false|PDOStatement
    {
        if (!$params) {
            return $this->query($queryString);
        }
        return $this->prepare($queryString, $params);
    }

    public function query(string $queryString): false|PDOStatement
    {
        return $this->pdo->query($queryString);
    }

    public function prepare(string $queryString, array $params): false|PDOStatement
    {
        $stmt = $this->pdo->prepare($queryString);
        $stmt->execute($params);
        return $stmt;
    }
}
