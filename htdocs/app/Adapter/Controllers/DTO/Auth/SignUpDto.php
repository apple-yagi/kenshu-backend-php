<?php

namespace App\Adapter\Controllers\DTO\Auth;

class SignUpDto
{
  public string $name;
  public string $password;

  function __construct(object $obj)
  {
    $this->name = $obj->name;
    $this->password = $obj->password;
  }

  public function validation(): array
  {
    $valError = array();

    if (mb_strlen($this->name, "UTF-8") < 2) {
      $valError["name"] = "名前は2文字以上15文字以内にしてください";
    } elseif (strlen($this->name) > 15) {
      $valError["name"] = "名前は2文字以上15文字以内にしてください";
    }

    if (mb_strlen($this->password, "UTF-8") < 6) {
      $valError["password"] = "パスワードは6文字以上必要です";
    }

    return $valError;
  }
}
