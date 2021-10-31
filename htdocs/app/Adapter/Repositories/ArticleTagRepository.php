<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iArticleTagRepository;
use PDO;

class ArticleTagRepository extends BaseRepository implements iArticleTagRepository
{
  function __construct(PDO $pdo)
  {
    parent::__construct($pdo);
  }

  public function insert(int $article_id, int $tag_id): ?int
  {
    $stmt = $this->connection->prepare("INSERT INTO articles_tags SET article_id = :article_id, tag_id = :tag_id");
    $stmt->bindParam(":article_id", $article_id, PDO::PARAM_INT);
    $stmt->bindParam(":tag_id", $tag_id, PDO::PARAM_INT);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return (int) $this->connection->lastInsertId();
  }

  public function insertValues(int $article_id, array $tagIdList): ?int
  {
    $sql = "INSERT INTO articles_tags (article_id, tag_id) VALUES";
    $insertQuery = [];
    $insertValues = [];

    foreach ($tagIdList as $tagId) {
      array_push($insertQuery, "(?, ?)");
      array_push($insertValues, $article_id);
      array_push($insertValues, $tagId);
    }

    $sql .= implode(', ', $insertQuery);
    $stmt = $this->connection->prepare($sql);
    $result = $stmt->execute($insertValues);
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return (int) $this->connection->lastInsertId() - count($tagIdList) + 1;
  }
}
