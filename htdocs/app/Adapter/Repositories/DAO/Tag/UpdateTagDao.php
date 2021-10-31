<?php

namespace App\Adapter\Repositories\DAO\Tag;

use App\Entity\Tag;

class UpdateTagDao
{
  public int $id;
  public string $name;

  function __construct(Tag $tag)
  {
    $this->id = $tag->id;
    $this->name = $tag->name;
  }
}
