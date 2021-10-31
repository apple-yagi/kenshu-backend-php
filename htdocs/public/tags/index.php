<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\TagController;
use App\Adapter\Repositories\TagRepository;
use App\Usecase\TagInteractor;

use function App\External\Database\Connection;

session_start();

$pdo = connection();
$tagRepository = new TagRepository($pdo);
$tagInteractor = new TagInteractor($tagRepository);
$tagController = new TagController($tagInteractor);
$tagList = $tagController->index();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>タグ | 一覧</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include("../../view/components/Header.php") ?>
  <main class="container">
    <h1 class="title">タグ | 一覧</h1>
    <ul class="list-group list-group-flush">
      <?php foreach ($tagList as $tag) : ?>
        <li class="list-group-item"><a href="/tags/<?= $tag["id"] ?>"><?= $tag["name"] ?></a></li>
      <?php endforeach; ?>
    </ul>
  </main>
</body>

</html>