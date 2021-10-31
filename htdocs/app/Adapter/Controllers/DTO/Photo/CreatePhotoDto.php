<?php

namespace App\Adapter\Controllers\DTO\Photo;

class CreatePhotoDto
{
  public string $url;
  public int $article_id;

  function __construct(int $article_id, object $obj)
  {
    $this->article_id = (int) $article_id;
    $this->url = $obj->url;
  }

  public function validation()
  {
    $valError = array();

    if (empty($this->url)) {
      $valError["url"] = "URLが空になっています";
    }

    if (empty($this->article_id)) {
      $valError["article_id"] = "必須パラメータです";
    } elseif (!is_int($this->article_id)) {
      $valError["article_id"] = "型が違います";
    }

    return $valError;
  }
}
