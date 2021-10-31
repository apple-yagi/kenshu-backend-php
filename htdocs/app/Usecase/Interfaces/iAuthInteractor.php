<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Auth\LoginUserDto;
use App\Adapter\Controllers\DTO\Auth\SignUpDto;
use App\Entity\Auth;

interface iAuthInteractor
{
  public function validate(LoginUserDto $validateUser): ?Auth;
  public function register(SignUpDto $signUpDto): ?int;
}
