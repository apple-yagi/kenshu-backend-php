<?php

namespace App\Adapter\Repositories;

use App\Adapter\Repositories\Interfaces\iTagRepository;
use App\Entity\Tag;
use PDO;

class TagRepository extends BaseRepository implements iTagRepository
{
  function __construct(PDO $pdo)
  {
    parent::__construct($pdo);
  }

  public function findAll(): ?array
  {
    $stmt = $this->connection->prepare("SELECT id, name FROM tags");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findById(int $id): ?array
  {
    $stmt = $this->connection->prepare(
      "SELECT tags.id as id, tags.name as name, articles.id as article_id, articles.title as title, photos.url as thumbnail_url, users.id as user_id, users.name as username
      FROM tags
      LEFT JOIN articles_tags ON articles_tags.tag_id = tags.id
      LEFT JOIN articles ON articles.id = articles_tags.article_id
      LEFT JOIN users ON users.id = articles.user_id
      LEFT JOIN photos ON photos.id = articles.thumbnail_id
      WHERE tags.id = ?"
    );
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findByName(string $name): ?object
  {
    $stmt = $this->connection->prepare(
      "SELECT id, name FROM tags WHERE name = ?"
    );
    $stmt->bindValue(1, $name, PDO::PARAM_STR);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return (object) $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function save(Tag $tag): ?int
  {
    $stmt = $this->connection->prepare("INSERT INTO tags SET name = :name");
    $stmt->bindParam(":name", $tag->name, PDO::PARAM_STR);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    if (!$result || !$count) {
      return null;
    }

    return (int) $this->connection->lastInsertId();
  }

  public function update(Tag $tag): bool
  {
    $stmt = $this->connection->prepare("UPDATE tags SET name = :name WHERE id = :id");
    $stmt->bindParam(":name", $tag->name, PDO::PARAM_STR);
    $stmt->bindParam(":id", $tag->id, PDO::PARAM_INT);
    $result = $stmt->execute();
    $count = $stmt->rowCount();

    return $result && !!$count;
  }
}
