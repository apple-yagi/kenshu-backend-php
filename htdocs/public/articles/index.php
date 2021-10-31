<?php
session_start();
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Repositories\ArticleRepository;
use App\Usecase\ArticleInteractor;

use function App\External\Database\Connection;

$pdo = connection();
$articleRepository = new ArticleRepository($pdo);
$articleInteractor = new ArticleInteractor($articleRepository);
$articleController = new ArticleController($articleInteractor);
$articles = $articleController->index();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>記事 | 一覧</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1 class="title">記事 | 一覧</h1>
    <ul class="article-list d-flex justify-content-around flex-wrap">
      <?php foreach ($articles as $article) : ?>
        <li class="article-list__item card">
          <a href="/articles/<?= $article["id"] ?>">
            <div class="card-header text-center">
              <?php if (isset($article["thumbnail_url"])) : ?>
                <img src="<?= $article["thumbnail_url"] ?>" alt="<?= $article["title"] ?>" height="100px" />
              <?php else : ?>
                <img src="/assets/img/thumbnail_default.png" alt="<?= $article["title"] ?>" height="100px" />
              <?php endif; ?>
            </div>
          </a>
          <div class="card-body">
            <h3><a href="/articles/<?= $article["id"] ?>"><?php echo $article["title"] ?></a></h3>
          </div>
          <div class="card-footer">
            <p>投稿者：<a href="/users/<?= $article["user_id"] ?>"><?php echo $article["username"] ?></a></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </main>
</body>

</html>