<?php

namespace App\Adapter\Uploaders;

use App\Adapter\Uploaders\Interfaces\iPhotoUploader;
use Exception;

class PhotoUploader implements iPhotoUploader
{
  protected int $article_id;
  protected string $tmp_name;
  protected string $file_name_sha1;
  protected string $dir_path;

  public function setPhotoInfo(int $article_id, $tmp_name, $file_name)
  {
    $this->article_id = $article_id;
    $this->tmp_name = $tmp_name;
    $image_type = exif_imagetype($tmp_name);
    $this->file_name_sha1 = sha1_file($tmp_name) . image_type_to_extension($image_type);
    $this->dir_path = dirname(__DIR__, 3) . "/public/uploads/$this->article_id";
  }

  public function upload(): ?string
  {
    if (!file_exists($this->dir_path)) {
      if (mkdir($this->dir_path, 0777)) {
        chmod($this->dir_path, 0777);
      } else {
        throw new Exception("画像を保存するためのディレクトリの作成に失敗しました");
      }
    }

    $result = move_uploaded_file($this->tmp_name, $this->dir_path . "/" . $this->file_name_sha1);
    if (!$result) {
      return null;
    }

    return "/uploads/$this->article_id/" . $this->file_name_sha1;
  }

  public function rollBack()
  {
    $files = array_diff(scandir($this->dir_path), array('.', '..'));
    foreach ($files as $file) {
      unlink("{$this->dir_path}/$file");
    }
    return rmdir($this->dir_path);
  }
}
