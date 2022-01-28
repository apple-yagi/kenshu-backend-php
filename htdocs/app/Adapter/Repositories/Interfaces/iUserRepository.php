<?php

namespace App\Adapter\Repositories\Interfaces;

interface iUserRepository extends iBaseRepository
{
  public function findAll(): array;
  public function findById(int $id): ?array;
}
