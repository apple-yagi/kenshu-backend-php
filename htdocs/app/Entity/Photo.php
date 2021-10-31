<?php

namespace App\Entity;

class Photo extends BaseEntity
{
  private int $id;
  private string $url;
  private int $article_id;

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
        case "url":
          $this->setUrl($value);
          break;
        case "article_id":
          $this->setArticleId($value);
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
    return $this->url;
  }

  public function setId($id)
  {
    if (!is_numeric($id)) {
      $this->illegalAssignment("Photo", "id", $id);
    }

    if (!is_int($id)) {
      $id = (int) $id;
    }
    $this->id = $id;
  }

  public function setUrl(string $url)
  {
    if (empty($url)) {
      $this->illegalAssignment("Photo", "url", $url);
    }
    $this->url = $url;
  }

  public function setArticleId(int $article_id)
  {
    if (!is_int($article_id)) {
      $this->illegalAssignment("Photo", "article_id", $article_id);
    }
    $this->article_id = $article_id;
  }
}
