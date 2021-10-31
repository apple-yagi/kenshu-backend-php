<?php

namespace App\Adapter\Repositories\Interfaces;

interface iUserRepository extends iBaseRepository
{
  public function selectAll(): array;
  public function selectById(int $id): ?array;
}
