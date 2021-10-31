<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\Auth;

interface iAuthRepository extends iBaseRepository
{
  public function selectUserByName(string $name): ?object;
  public function insert(Auth $auth): ?int;
}
