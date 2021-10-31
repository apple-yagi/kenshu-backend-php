<?php

namespace App\Usecase;

use App\Adapter\Repositories\Interfaces\iUserRepository;
use App\Entity\Article;
use App\Entity\User;
use App\Usecase\Interfaces\iUserInteractor;

class UserInteractor implements iUserInteractor
{
  protected iUserRepository $userRepository;

  function __construct(iUserRepository $ur)
  {
    $this->userRepository = $ur;
  }

  public function findAll(): array
  {
    return $this->userRepository->selectAll();
  }

  public function findById(int $id): ?User
  {
    $array = $this->userRepository->selectById($id);

    if (!$array) {
      return null;
    }

    $user = new User((object) $array[0]);
    $articles = array();

    foreach ($array as $record) {
      if (is_null($record["article_id"])) {
        continue;
      }
      $record["id"] = $record["article_id"];
      $article = new Article((object) $record);
      array_push($articles, $article);
    }

    $user->setArticles($articles);
    return $user;
  }
}
