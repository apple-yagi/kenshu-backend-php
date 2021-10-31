<?php

namespace App\Adapter\Controllers\Interfaces;

use App\Entity\Tag;

interface iTagController
{
  public function index(): array;
  public function show(string $id): Tag;
  public function post(object $obj);
  public function update(object $obj);
}
