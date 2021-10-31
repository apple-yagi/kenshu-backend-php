<?php

namespace App\Adapter\Controllers\DTO\Tag;

class CreateTagDto
{
  public string $name;

  function __construct(object $obj)
  {
    $this->name = $obj->name;
  }

  public function validation()
  {
    $valError = array();

    if (empty($this->name)) {
      $valError["name"] = "入力必須項目です";
    } elseif (mb_strlen($this->name, "UTF-8") > 15) {
      $valError["name"] = "15文字以内にしてください";
    }

    return $valError;
  }
}
