<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Photo\CreatePhotoDto;
use App\Adapter\Repositories\Interfaces\iPhotoRepository;
use App\Entity\Photo;
use App\Usecase\Interfaces\iPhotoInteractor;
use Exception;

class PhotoInteractor implements iPhotoInteractor
{
  protected iPhotoRepository $photoRepository;

  function __construct(iPhotoRepository $pr)
  {
    $this->photoRepository = $pr;
  }

  public function findAll(): array
  {
    return $this->photoRepository->selectAll();
  }

  public function findById(int $id): ?Photo
  {
    $obj = $this->photoRepository->selectById($id);

    if (!$obj) {
      return null;
    }

    return new Photo($obj);
  }

  public function save(CreatePhotoDto $cad): int
  {
    $createPhoto = new Photo($cad);

    $result = $this->photoRepository->insert($createPhoto);
    if (!$result) {
      throw new Exception("データの登録に失敗しました");
    }
    return $result;
  }
}
