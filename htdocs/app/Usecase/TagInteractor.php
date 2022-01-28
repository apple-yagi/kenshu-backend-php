<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Tag\CreateTagDto;
use App\Adapter\Controllers\DTO\Tag\UpdateTagDto;
use App\Adapter\Repositories\Interfaces\iTagRepository;
use App\Entity\Article;
use App\Entity\Tag;
use Exception;

class TagInteractor
{
  protected iTagRepository $tagRepository;

  function __construct(iTagRepository $tr)
  {
    $this->tagRepository = $tr;
  }

  public function findAll(): array
  {
    return $this->tagRepository->findAll();
  }

  public function findById(int $id): ?Tag
  {
    $array = $this->tagRepository->findById($id);

    if (!$array) {
      return null;
    }

    $tag = new Tag((object) $array[0]);
    $articles = array();

    foreach ($array as $record) {
      if (is_null($record["article_id"])) {
        continue;
      }
      $record["id"] = $record["article_id"];
      $article = new Article((object) $record);
      array_push($articles, $article);
    }

    $tag->setArticles($articles);

    return $tag;
  }

  public function save(CreateTagDto $createTagDto): int
  {
    $findTag = $this->tagRepository->findByName($createTagDto->name);
    if ($findTag) {
      throw new Exception("既に登録されているタグ名です");
    }

    $createTag = new Tag($createTagDto);

    $result = $this->tagRepository->save($createTag);
    if (!$result) {
      throw new Exception("データの登録に失敗しました");
    }
    return $result;
  }

  public function update(UpdateTagDto $updateTagDto): bool
  {
    $updateTag = new Tag($updateTagDto);
    return $this->tagRepository->update($updateTag);
  }
}
