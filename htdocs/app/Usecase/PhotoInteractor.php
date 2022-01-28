<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Photo\CreatePhotoDto;
use App\Adapter\Repositories\Interfaces\iPhotoRepository;
use App\Entity\Photo;
use Exception;

class PhotoInteractor
{
  protected iPhotoRepository $photoRepository;

  function __construct(iPhotoRepository $pr)
  {
    $this->photoRepository = $pr;
  }

  public function findAll(): array
  {
    return $this->photoRepository->findAll();
  }

  public function findById(int $id): ?Photo
  {
    $obj = $this->photoRepository->findById($id);

    if (!$obj) {
      return null;
    }

    return new Photo($obj);
  }

  public function save(CreatePhotoDto $cad): int
  {
    $createPhoto = new Photo($cad);

    $result = $this->photoRepository->save($createPhoto);
    if (!$result) {
      throw new Exception("データの登録に失敗しました");
    }
    return $result;
  }
}
