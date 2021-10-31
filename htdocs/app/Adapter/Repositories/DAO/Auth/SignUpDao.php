<?php

namespace App\Adapter\Repositories\DAO\Auth;

use App\Entity\Auth;

class SignUpDao
{
  public string $name;
  public string $password_hash;

  function __construct(Auth $auth)
  {
    $this->name = $auth->name;
    $this->password_hash = $auth->password_hash;
  }
}
