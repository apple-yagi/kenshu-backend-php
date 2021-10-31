<?php

namespace App\Adapter\Controllers\Interfaces;

use App\Entity\Article;

interface iArticleController
{
  public function index(): array;
  public function show(string $id): Article;
  public function post(string $user_id, object $obj, array $photos);
  public function update(object $obj);
  public function delete(string $id);
}
