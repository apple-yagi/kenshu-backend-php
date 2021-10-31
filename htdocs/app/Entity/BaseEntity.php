<?php

namespace App\Entity;

use RuntimeException;

class BaseEntity
{
  protected function illegalAssignment(string $class, string $propety, $value)
  {
    throw new RuntimeException("Illegal assignment for $class.$propety: $value");
  }
}
