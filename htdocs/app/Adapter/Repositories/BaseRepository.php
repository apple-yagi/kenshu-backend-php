<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iBaseRepository;
use PDO;

class BaseRepository implements iBaseRepository
{
  protected PDO $connection;

  function __construct(PDO $pdo)
  {
    $this->connection = $pdo;
  }

  public function beginTransaction()
  {
    $this->connection->beginTransaction();
  }

  public function commit()
  {
    $this->connection->commit();
  }

  public function rollBack()
  {
    $this->connection->rollBack();
  }

  public function closeConnect()
  {
    $this->connection = null;
  }
}
