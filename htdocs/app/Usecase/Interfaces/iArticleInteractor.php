<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Adapter\Controllers\DTO\Article\UpdateArticleDto;
use App\Entity\Article;

interface iArticleInteractor
{
  public function findAll(): array;
  public function findById(int $id): ?Article;
  public function save(CreateArticleDto $createArticleDto): ?int;
  public function update(UpdateArticleDto $updateArticleDto): bool;
  public function delete(int $id): bool;
}
