<?php

namespace App\Adapter\Repositories\Interfaces;

interface iBaseRepository
{
  public function beginTransaction();
  public function commit();
  public function rollBack();
  public function closeConnect();
}
