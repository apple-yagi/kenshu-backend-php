<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\Tag;

interface iTagRepository extends iBaseRepository
{
  public function findAll(): ?array;
  public function findById(int $id): ?array;
  public function findByName(string $name): ?object;
  public function save(Tag $tag): ?int;
  public function update(Tag $tag): bool;
}
