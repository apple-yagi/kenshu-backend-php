<?php

namespace App\External\File;

use RuntimeException;

class ImageManager
{
  public static function validation(array $files)
  {
    if (!isset($files['error']) || !is_array($files['error'])) {
      throw new RuntimeException("パラメータが不正です");
    }

    foreach ($files['error'] as $k => $error) {
      if (!is_int($error)) {
        throw new RuntimeException("[{$k}] パラメータが不正です");
      }

      switch ($error) {
        case UPLOAD_ERR_OK:        // OK
          break;
        case UPLOAD_ERR_NO_FILE:   // ファイル未選択のため、バリデーションをスキップ
          continue 2;
        case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
        case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過
          throw new RuntimeException("[{$k}] ファイルサイズが大きすぎます");
        default:
          throw new RuntimeException("[{$k}] その他のエラーが発生しました");
      }

      if (!$info = @getimagesize($files['tmp_name'][$k])) {
        throw new RuntimeException("[{$k}] 有効な画像ファイルを指定してください");
      }
      if (!in_array($info[2], [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
        throw new RuntimeException("[{$k}] 未対応の画像形式です");
      }
    }
  }
}
