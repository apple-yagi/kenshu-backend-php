<?php

namespace App\Adapter\Repositories\DAO\Photo;

use App\Entity\Photo;

class CreatePhotoDao
{
  public string $url;
  public int $article_id;

  function __construct(Photo $photo)
  {
    $this->article_id = $photo->article_id;
    $this->url = $photo->url;
  }
}
