<?php

namespace App\Adapter\Controllers\Errors;

use Exception;

class ValidationException extends Exception
{
  public function __construct($message = null, $code = 0, Exception $previous = null)
  {
    parent::__construct(json_encode($message), $code, $previous);
  }

  public function getArrayMessage($assoc = false)
  {
    return (array) json_decode($this->getMessage(), $assoc);
  }
}
