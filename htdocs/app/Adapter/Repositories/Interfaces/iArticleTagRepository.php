<?php

namespace App\Adapter\Repositories\Interfaces;

interface iArticleTagRepository extends iBaseRepository
{
  public function save(int $article_id, int $tag_id): ?int;
  public function saveValues(int $article_id, array $tagIdList): ?int;
}
