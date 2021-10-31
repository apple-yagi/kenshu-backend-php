<?php

namespace App\Adapter\Repositories\DAO\Article;

use App\Entity\Article;

class UpdateArticleDao
{
  public int $id;
  public string $title;
  public string $body;

  public function __construct(Article $article)
  {
    $this->id = $article->id;
    $this->title = $article->title;
    $this->body = $article->body;
  }
}
