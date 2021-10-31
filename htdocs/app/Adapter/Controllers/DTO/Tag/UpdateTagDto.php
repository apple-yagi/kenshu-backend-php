<?php

namespace App\Adapter\Controllers\DTO\Tag;

class UpdateTagDto
{
  public int $id;
  public string $name;

  function __construct(object $obj)
  {
    $this->id = (int) $obj->id;
    $this->name = $obj->name;
  }

  public function validation()
  {
    $valError = array();

    if (empty($this->id)) {
      $valError["id"] = "必須パラメータです";
    } elseif (!is_int($this->id)) {
      $valError["id"] = "型が違います";
    }

    if (empty($this->name)) {
      $valError["name"] = "入力必須項目です";
    } elseif (mb_strlen($this->name, "UTF-8") > 15) {
      $valError["name"] = "15文字以内にしてください";
    }

    return $valError;
  }
}
