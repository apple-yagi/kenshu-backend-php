<?php

namespace App\Adapter\Controllers;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Adapter\Controllers\DTO\Article\UpdateArticleDto;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Controllers\Interfaces\iArticleController;
use App\Entity\Article;
use App\Adapter\Controllers\Errors\ValidationException;
use App\Usecase\Interfaces\iArticleInteractor;
use Exception;

class ArticleController implements iArticleController
{
  protected iArticleInteractor $articleInteractor;

  function __construct(iArticleInteractor $ai)
  {
    $this->articleInteractor = $ai;
  }

  public function index(): array
  {
    return $this->articleInteractor->findAll();
  }

  public function show(string $id): Article
  {
    $id_int = intval($id);
    if ($id_int == 0) {
      throw new Exception("指定したIDは無効です");
    }
    $article = $this->articleInteractor->findById($id_int);

    if (!$article) {
      throw new NotFoundException();
    }
    return $article;
  }

  public function post(string $user_id, $obj, array $photos)
  {
    $user_id = intval($user_id);
    if ($user_id == 0) {
      return http_response_code(400);
    }

    $createArticleDto = new CreateArticleDto($user_id, $obj, $photos);
    $valError = $createArticleDto->validation();
    if (count($valError)) {
      throw new ValidationException($valError);
    }

    $createArticleId = $this->articleInteractor->save($createArticleDto);
    if (!$createArticleId) {
      throw new Exception("登録に失敗しました");
    }
    header("Location: /articles/$createArticleId");
  }

  public function update(object $obj)
  {
    $updateArticleDto = new UpdateArticleDto($obj);

    $valError = $updateArticleDto->validation();
    if (count($valError)) {
      throw new ValidationException($valError);
    }

    $result = $this->articleInteractor->update($updateArticleDto);
    if (!$result) {
      throw new Exception("更新に失敗しました");
    }
    header("Location: /articles/{$updateArticleDto->id}");
  }

  public function delete(string $id)
  {
    $id_int = intval($id);
    if ($id_int == 0) {
      throw new Exception("指定されたIDは無効です");
    }

    $article = $this->articleInteractor->findById($id_int);
    if (!$article) {
      throw new NotFoundException();
    }

    $result = $this->articleInteractor->delete($id_int);
    if (!$result) {
      throw new Exception("削除に失敗しました");
    }
    header("Location: /mypage");
  }
}
