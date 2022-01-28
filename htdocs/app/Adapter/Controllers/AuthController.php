<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\DTO\Auth\LoginUserDto;
use App\Adapter\Controllers\DTO\Auth\SignUpDto;
use App\Adapter\Controllers\Interfaces\iAuthController;
use App\Entity\Auth;
use App\Adapter\Controllers\Errors\ValidationException;
use App\Usecase\AuthInteractor;
use Exception;

class AuthController implements iAuthController
{
  protected AuthInteractor $authInteractor;

  function __construct(AuthInteractor $ai)
  {
    $this->authInteractor = $ai;
  }

  public function login(object $obj): Auth
  {
    $loginUserDto = new LoginUserDto($obj);

    $result = $this->authInteractor->validate($loginUserDto);
    if (!$result) {
      throw new Exception("ログインに失敗しました");
    }
    return $result;
  }

  public function register(object $obj)
  {
    $signUpDto = new SignUpDto($obj);

    $valError = $signUpDto->validation();
    if (count($valError)) {
      throw new ValidationException($valError);
    }

    $result = $this->authInteractor->register($signUpDto);
    if (!$result) {
      throw new Exception("登録に失敗しました");
    }
    header("Location: /auth/login");
  }
}
