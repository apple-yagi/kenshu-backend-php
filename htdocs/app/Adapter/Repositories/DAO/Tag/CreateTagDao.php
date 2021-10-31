<?php

namespace App\Adapter\Repositories\DAO\Tag;

use App\Entity\Tag;

class CreateTagDao
{
  public string $name;

  function __construct(Tag $tag)
  {
    $this->name = $tag->name;
  }
}
