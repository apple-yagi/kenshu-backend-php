<?php

namespace App\Usecase\Interfaces;

use App\Entity\User;

interface iUserInteractor
{
  public function findAll(): array;
  public function findById(int $id): ?User;
}
