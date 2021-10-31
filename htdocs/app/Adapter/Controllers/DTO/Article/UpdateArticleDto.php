<?php

namespace App\Adapter\Controllers\DTO\Article;

class UpdateArticleDto
{
  public int $id;
  public int $user_id;
  public string $title;
  public string $body;

  public function __construct(object $obj)
  {
    $this->id = (int) $obj->id;
    $this->user_id = (int) $obj->user_id;
    $this->title = $obj->title;
    $this->body = $obj->body;
  }

  public function validation()
  {
    $valError = array();

    if (empty($this->id)) {
      $valError["id"] = "必須パラメータです";
    } elseif (!is_int($this->id)) {
      $valError["id"] = "型が違います";
    }

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

    return $valError;
  }
}
