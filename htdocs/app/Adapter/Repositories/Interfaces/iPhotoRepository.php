<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\Photo;

interface iPhotoRepository extends iBaseRepository
{
  public function selectAll(): ?array;
  public function selectById(int $id): ?object;
  public function insert(Photo $photo): ?int;
  public function insertValues(int $article_id, array $photoUrlList): ?int;
}
