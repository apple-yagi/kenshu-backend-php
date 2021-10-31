<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Repositories\ArticleRepository;
use App\Usecase\ArticleInteractor;

use function App\External\Database\Connection;

session_start();

$pdo = connection();
$articleRepository = new ArticleRepository($pdo);
$articleInteractor = new ArticleInteractor($articleRepository);
$articleController = new ArticleController($articleInteractor);

try {
  $article = $articleController->show(explode('/', $_SERVER['REQUEST_URI'])[2]);
} catch (NotFoundException $e) {
  $notFoundException = $e;
} catch (Exception $e) {
  $exception = $e;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>記事 | 詳細</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include("../../view/components/Header.php") ?>
  <main class="container">
    <h1 class="title">記事 | 詳細</h1>
    <?php if (isset($article)) : ?>
      <h2 class="mb-3"><?= $article->title ?></h2>
      <?php if (count($article->photos)) : ?>
        <?php foreach ($article->photos as $index => $photo) : ?>
          <img src="<?= $photo ?>" alt="photo<?= $index + 1 ?>" height="200px" />
        <?php endforeach; ?>
      <?php endif; ?>
      <p class="mb-3"><?= $article->body ?></p>
      <p>投稿者：<a href="/users/<?= $article->user_id ?>"><?= $article->username ?></a></p>
      <?php if (count($article->tags)) : ?>
        <ul class="d-flex flex-wrap">
          <?php foreach ($article->tags as $tag) : ?>
            <li class="mx-2"><a href="/tags/<?= $tag->id ?>">#<?= $tag->name ?></a></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    <?php endif; ?>

    <?php if (isset($notFoundException)) : ?>
      <?php include("../../view/errors/NotFound.php") ?>
    <?php elseif (isset($exception)) : ?>
      <p class="text-danger"><?= $exception->getMessage() ?></p>
    <?php endif; ?>
  </main>
</body>

</html>