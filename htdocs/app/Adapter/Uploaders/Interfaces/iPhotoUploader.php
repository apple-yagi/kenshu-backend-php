<?php

namespace App\Adapter\Uploaders\Interfaces;

interface iPhotoUploader
{
  public function setPhotoInfo(int $article_id, $tmp_name, $file_name);
  public function upload(): ?string;
  public function rollBack();
}
