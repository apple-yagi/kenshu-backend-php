<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\Auth;

interface iAuthRepository extends iBaseRepository
{
  public function findByName(string $name): ?object;
  public function save(Auth $auth): ?int;
}
