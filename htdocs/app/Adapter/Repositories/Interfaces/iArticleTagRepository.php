<?php

namespace App\Adapter\Repositories\Interfaces;

interface iArticleTagRepository extends iBaseRepository
{
  public function insert(int $article_id, int $tag_id): ?int;
  public function insertValues(int $article_id, array $tagIdList): ?int;
}
