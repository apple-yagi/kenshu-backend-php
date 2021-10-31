<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Repositories\ArticleRepository;
use App\External\Session\LoginSessionManager;
use App\Usecase\ArticleInteractor;

use function App\External\Database\Connection;

LoginSessionManager::requireLoginedSession();

$pdo = connection();
$articleRepository = new ArticleRepository($pdo);
$articleInteractor = new ArticleInteractor($articleRepository);
$articleController = new ArticleController($articleInteractor);

try {
  $id = explode('/', $_SERVER['REQUEST_URI'])[2];
  $article = $articleController->show($id);
  if ($_SESSION["user_id"] !== $article->user_id) {
    return http_response_code(403);
  }
  $articleController->delete($id);
} catch (NotFoundException $e) {
  $notFoundException = $e;
} catch (Exception $e) {
  $exception = $e;
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>記事 | 削除</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1 class="title">記事 | 削除</h1>
    <?php if (isset($notFoundException)) : ?>
      <?php include("../../view/errors/NotFound.php") ?>
    <?php elseif (isset($exception)) : ?>
      <p class="text-danger">?= $exception->getMessage() ?></p>
    <?php endif; ?>
  </main>
</body>

</html>