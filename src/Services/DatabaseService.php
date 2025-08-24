<?php

namespace Services;

use PDO;

readonly class DatabaseService
{
    private PDO $pdo;
    public function __construct(
        private array $databaseConfig,

    ) {
        $host = $this->databaseConfig["host"];
        $port = $this->databaseConfig["port"];
        $database = $this->databaseConfig["database"];
        $user = $this->databaseConfig["user"];
        $password = $this->databaseConfig["password"];

        $this->pdo = new PDO(
            dsn: "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
            username: $user,
            password: $password,
        );
    }


    public function get(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $index => $param) {
            $paramType = is_int($param) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue(++$index, $param, $paramType);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $sql, array $params = []): int | null
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $this->pdo->lastInsertId();
    }

    public function update(string $sql, array $params = []): int
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function delete(string $sql, array $params = []): bool
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $deletedRows = $stmt->rowCount();
        return $deletedRows > 0;
    }

    public function startTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commit()
    {
        $this->pdo->commit();
    }

    public function rollback()
    {
        $this->pdo->rollBack();
    }
}
