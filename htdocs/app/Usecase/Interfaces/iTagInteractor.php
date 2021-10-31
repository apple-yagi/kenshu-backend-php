<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Tag\CreateTagDto;
use App\Adapter\Controllers\DTO\Tag\UpdateTagDto;
use App\Entity\Tag;

interface iTagInteractor
{
  public function findAll(): array;
  public function findById(int $id): ?Tag;
  public function save(CreateTagDto $createTagDto): ?int;
  public function update(UpdateTagDto $updateTagDto): bool;
}
