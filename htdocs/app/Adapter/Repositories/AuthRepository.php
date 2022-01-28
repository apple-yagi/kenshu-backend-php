<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iAuthRepository;
use App\Entity\Auth;
use PDO;

class AuthRepository extends BaseRepository implements iAuthRepository
{
  function __construct(PDO $pdo)
  {
    parent::__construct($pdo);
  }

  public function selectUserByName(string $name): ?object
  {
    $stmt = $this->connection->prepare("select id, name, password_hash from users where name = ?");
    $stmt->bindValue(1, $name);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return (object) $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function insert(Auth $auth): ?int
  {
    $stmt = $this->connection->prepare("INSERT INTO users SET name = :name, password_hash = :password_hash");
    $stmt->bindParam(":name", $auth->name, PDO::PARAM_STR);
    $stmt->bindParam(":password_hash", $auth->password_hash, PDO::PARAM_STR);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return (int) $this->connection->lastInsertId();
  }
}
