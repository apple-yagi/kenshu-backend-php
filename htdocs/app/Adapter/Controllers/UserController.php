<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Controllers\Interfaces\iUserController;
use App\Entity\User;
use App\Usecase\UserInteractor;
use Exception;

class UserController implements iUserController
{
  protected UserInteractor $userInteractor;

  function __construct(UserInteractor $ui)
  {
    $this->userInteractor = $ui;
  }

  public function index(): array
  {
    $userList = $this->userInteractor->findAll();
    return $userList;
  }

  public function show(string $id): User
  {
    $id_int = intval($id);
    if ($id_int == 0) {
      throw new Exception("指定したIDは無効です");
    }
    $user = $this->userInteractor->findById($id);

    if (!$user) {
      throw new NotFoundException();
    }
    return $user;
  }
}
