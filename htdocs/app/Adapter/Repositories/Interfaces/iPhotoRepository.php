<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\Photo;

interface iPhotoRepository extends iBaseRepository
{
  public function findAll(): ?array;
  public function findById(int $id): ?object;
  public function save(Photo $photo): ?int;
  public function saveValues(int $article_id, array $photoUrlList): ?int;
}
