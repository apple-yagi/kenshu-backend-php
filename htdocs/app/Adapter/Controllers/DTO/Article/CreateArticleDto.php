<?php

namespace App\Adapter\Controllers\DTO\Article;

class CreateArticleDto
{
  public int $user_id;
  public string $title;
  public string $body;
  public array $photos = [];
  public array $tags = [];

  public function __construct(int $user_id, object $obj, array $photos)
  {
    $this->user_id = (int) $user_id;
    $this->title = $obj->title;
    $this->body = $obj->body;
    $this->photos = $photos;
    if (!empty($obj->tags)) $this->tags = $obj->tags;
  }

  public function validation()
  {
    $valError = array();

    if (empty($this->user_id)) {
      $valError["user_id"] = "必須パラメータです";
    } elseif (!is_int($this->user_id)) {
      $valError["user_id"] = "型が違います";
    }

    if (empty($this->title)) {
      $valError["title"] = "入力必須です";
    } elseif (mb_strlen($this->title, "UTF-8") > 30) {
      $valError["title"] = "30文字以内にしてください";
    }

    if (empty($this->body)) {
      $valError["body"] = "入力必須です";
    } elseif (mb_strlen($this->body, "UTF-8") > 200) {
      $valError["body"] = "200文字以内にしてください";
    }

    if (!is_array($this->photos)) {
      $valError["photos"] = "転送されたデータの形式に誤りがあります";
    }

    if (!is_array($this->tags)) {
      $valError["tags"] = "転送されたデータの形式に誤りがあります";
    }

    return $valError;
  }
}
