<?php

namespace App\Adapter\Repositories\DAO\Article;

use App\Entity\Article;

class CreateArticleDao
{
  public int $user_id;
  public string $title;
  public string $body;

  public function __construct(Article $article)
  {
    $this->user_id = $article->user_id;
    $this->title = $article->title;
    $this->body = $article->body;
  }
}
