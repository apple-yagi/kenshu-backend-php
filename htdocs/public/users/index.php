<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\UserController;
use App\Adapter\Repositories\UserRepository;
use App\Usecase\UserInteractor;

use function App\External\Database\Connection;

session_start();

$pdo = connection();
$userRepository = new UserRepository($pdo);
$userInteractor = new UserInteractor($userRepository);
$userController = new UserController($userInteractor);
$userList = $userController->index();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>ユーザー | 一覧</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1 class="title">ユーザー | 一覧</h1>
    <ul class="list-group list-group-flush">
      <?php foreach ($userList as $user) : ?>
        <li class="list-group-item"><a href="/users/<?= $user["id"] ?>"><?= $user["name"] ?></a></li>
      <?php endforeach ?>
    </ul>
  </main>
</body>

</html>