<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\Article;

interface iArticleRepository extends iBaseRepository
{
  public function findAll(): array;
  public function findById(int $id): ?array;
  public function save(Article $article): ?int;
  public function update(Article $article): bool;
  public function updateThumbnailId(int $id, int $thumbnail_id): bool;
  public function delete(int $id): bool;
}
