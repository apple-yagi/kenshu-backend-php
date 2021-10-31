<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Photo\CreatePhotoDto;
use App\Entity\Photo;

interface iPhotoInteractor
{
  public function findAll(): array;
  public function findById(int $id): ?Photo;
  public function save(CreatePhotoDto $createPhotoDto): ?int;
}
