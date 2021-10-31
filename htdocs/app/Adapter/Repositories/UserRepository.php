<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iUserRepository;
use PDO;

class UserRepository extends BaseRepository implements iUserRepository
{
  function __construct(PDO $pdo)
  {
    parent::__construct($pdo);
  }

  public function selectAll(): array
  {
    $stmt = $this->connection->prepare("SELECT id, name FROM users");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectById(int $id): ?array
  {
    $stmt = $this->connection->prepare(
      "SELECT users.id as id, name, articles.id as article_id, title, url as thumbnail_url
      FROM users 
      LEFT JOIN articles ON users.id = articles.user_id
      LEFT JOIN photos ON articles.thumbnail_id = photos.id
      WHERE users.id = ?"
    );
    $stmt->bindValue(1, $id);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
