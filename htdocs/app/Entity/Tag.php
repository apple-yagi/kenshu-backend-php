<?php

namespace App\Entity;

class Tag extends BaseEntity
{
  private int $id;
  private string $name;
  private array $articles = [];

  function __construct(object $obj)
  {
    foreach ($obj as $key => $value) {
      if (!property_exists($this, $key) || is_null($value)) {
        continue;
      }
      switch ($key) {
        case "id":
          $this->setId($value);
          break;
        case "name":
          $this->setName($value);
          break;
        case "articles":
          $this->setArticles($value);
          break;
      }
    }
  }

  public function __get($name)
  {
    return isset($this->$name) ? $this->$name : null;
  }

  public function __toString()
  {
    return $this->name;
  }

  public function setId($id)
  {
    if (!is_numeric($id)) {
      $this->illegalAssignment("Tag", "id", $id);
    }

    if (!is_int($id)) {
      $id = (int) $id;
    }
    $this->id = $id;
  }

  public function setName(string $name)
  {
    if (empty($name) || 15 < mb_strlen($name, "UTF-8")) {
      $this->illegalAssignment("Tag", "name", $name);
    }
    $this->name = $name;
  }

  public function setArticles(array $articles)
  {
    if (!is_array($articles)) {
      $this->illegalAssignment("Tag", "articles", $articles);
    }
    $this->articles = $articles;
  }
}
