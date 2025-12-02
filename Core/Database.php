<?php

namespace Core;

use PDO;

class Database
{
  public function __construct($config, $username = 'root', $password = '')
  {
    $dsn = 'mysql:' . http_build_query($config, '', ';');
    $this->conn = new PDO($dsn, $username, $password, [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }

  public function query(string $query, array $params = []): Database
  {
    $this->stmt = $this->conn->prepare($query);
    $this->stmt->execute($params);
    return $this;
  }

  public function fetch(): array|bool
  {
    return $this->stmt->fetch();
  }

  public function fetchOrAbort(): array|bool
  {
    $record = $this->stmt->fetch();
    if (!$record) {
      abort();
    }
    return $record;
  }

  public function fetchAll(): array
  {
    return $this->stmt->fetchAll();
  }

  private $conn;
  private $stmt;
}
