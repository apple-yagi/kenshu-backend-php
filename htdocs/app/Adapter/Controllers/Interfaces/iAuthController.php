<?php

namespace App\Adapter\Controllers\Interfaces;

use App\Entity\Auth;

interface iAuthController
{
  public function login(object $obj): Auth;
  public function register(object $obj);
}
