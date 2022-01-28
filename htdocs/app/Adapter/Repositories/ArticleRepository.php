<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iArticleRepository;
use App\Entity\Article;
use PDO;

class ArticleRepository extends BaseRepository implements iArticleRepository
{
  function __construct(PDO $pdo)
  {
    parent::__construct($pdo);
  }

  public function selectAll(): array
  {
    $stmt = $this->connection->prepare(
      "SELECT articles.id as id, title, users.id as user_id, users.name as username, photos.url as thumbnail_url
      FROM articles 
      INNER JOIN users 
      LEFT JOIN photos ON articles.thumbnail_id = photos.id
      WHERE articles.user_id = users.id
      ORDER BY articles.updated_at DESC"
    );
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectById(int $id): ?array
  {
    $stmt = $this->connection->prepare(
      "SELECT articles.id as id, title, body, thumbnail_id, users.id as user_id, users.name as username, photos.id as photo_id, photos.url as photo_url, tags.id as tag_id, tags.name as tag_name
      FROM articles 
      LEFT JOIN users ON articles.user_id = users.id
      LEFT JOIN photos ON articles.id = photos.article_id
      LEFT JOIN articles_tags ON articles.id = articles_tags.article_id
      LEFT JOIN tags ON tags.id = articles_tags.tag_id
      WHERE articles.id = ?"
    );
    $stmt->bindValue(1, $id);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function insert(Article $article): ?int
  {
    $stmt = $this->connection->prepare("INSERT INTO articles SET title = :title, body = :body, user_id = :user_id");
    $stmt->bindParam(":title", $article->title, PDO::PARAM_STR);
    $stmt->bindParam(":body", $article->body, PDO::PARAM_STR);
    $stmt->bindParam(":user_id", $article->user_id, PDO::PARAM_INT);
    $result = $stmt->execute();
    $count = $stmt->rowCount();
    if (!$result || !$count) {
      return null;
    }

    return (int) $this->connection->lastInsertId();
  }

  public function update(Article $article): bool
  {
    $stmt = $this->connection->prepare("UPDATE articles SET title = :title, body = :body WHERE id = :id");
    $stmt->bindParam(":title", $article->title, PDO::PARAM_STR);
    $stmt->bindParam(":body", $article->body, PDO::PARAM_STR);
    $stmt->bindParam(":id", $article->id, PDO::PARAM_INT);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    return $result && !!$count;
  }

  public function updateThumbnailId(int $id, int $thumbnail_id): bool
  {
    $stmt = $this->connection->prepare("UPDATE articles SET thumbnail_id = :thumbnail_id WHERE id = :id");
    $stmt->bindParam(":thumbnail_id", $thumbnail_id, PDO::PARAM_INT);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    return $result && !!$count;
  }

  public function delete(int $id): bool
  {
    $stmt = $this->connection->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bindValue(1, $id);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    return $result && !!$count;
  }
}
