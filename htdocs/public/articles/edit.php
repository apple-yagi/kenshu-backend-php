<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Repositories\ArticleRepository;
use App\Adapter\Controllers\Errors\ValidationException;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\External\Session\LoginSessionManager;
use App\Usecase\ArticleInteractor;

use function App\External\Database\Connection;

LoginSessionManager::requireLoginedSession();

$csrftoken = CsrfTokenManager::h(CsrfTokenManager::generateToken());

$pdo = connection();
$articleRepository = new ArticleRepository($pdo);
$articleInteractor = new ArticleInteractor($articleRepository);
$articleController = new ArticleController($articleInteractor);

if (!empty($_POST['update'])) {
  if (intval($_SESSION["user_id"]) !== intval($_POST["user_id"])) {
    return http_response_code(403);
  }

  if (!CsrfTokenManager::validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }

  try {
    $articleController->update((object) $_POST);
  } catch (ValidationException $e) {
    $validationError = $e->getArrayMessage();
    var_dump($validationError);
  } catch (Exception $e) {
    $exception = $e;
  }
}

try {
  $article = $articleController->show(explode('/', $_SERVER['REQUEST_URI'])[2]);
  if ($_SESSION["user_id"] !== $article->user_id) {
    return http_response_code(403);
  }
} catch (NotFoundException $e) {
  $notFoundException = $e;
} catch (Exception $e) {
  $exception = $e;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>記事 | 編集</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1 class="title">記事 | 編集</h1>
    <?php if (isset($notFoundException)) : ?>
      <?php include("../../view/errors/NotFound.php") ?>
    <?php elseif (isset($exception)) : ?>
      <p class="text-danger"><?= $exception->getMessage() ?></p>
    <?php endif; ?>
    <form action="edit" method="POST" enctype="multipart/form-data">
      <div class="mb-5">
        <label for="title" class="form-label">タイトル</label>
        <input type="text" class="form-control" name="title" id="title" value="<?= isset($_POST["title"]) ? $_POST["title"] : $article->title ?>" aria-describedby="titleHelp">
        <?php if (isset($validationError["title"])) : ?>
          <p id="titleHelp" class="form-text text-danger"> <?= $validationError["title"] ?></p>
        <?php else : ?>
          <div id="titleHelp" class="form-text">1~30文字の間で入力してください（必須項目）</div>
        <?php endif; ?>
      </div>
      <div class="mb-5">
        <label for="photos" class="form-label">画像</label>
        <br />
        <?php foreach ($article->photos as $photo) : ?>
          <img src="<?= $photo ?>" alt="photo" height="100px" />
        <?php endforeach ?>
      </div>
      <div class="mb-5">
        <label for="body" class="form-label">本文</label>
        <textarea name="body" class="form-control" id="body" rows="7" cols="33"><?= isset($_POST["body"]) ? $_POST["body"] : $article->body ?></textarea>
        <?php if (isset($validationError["body"])) : ?>
          <p id="bodyHelp" class="form_text text-danger"><?= $validationError["body"] ?></p>
        <?php else : ?>
          <p id="bodyHelp" class="form-text">1~200文字の間で入力してください（必須項目）</p>
        <?php endif; ?>
      </div>
      <div class="mb-5">
        <ul class="d-flex flex-wrap">
          <?php foreach ($article->tags as $tag) : ?>
            <li class="mx-2">#<?= $tag ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <input type="hidden" name="id" value="<?= $article->id ?>">
      <input type="hidden" name="user_id" value="<?= $article->user_id ?>">
      <input type="hidden" name="token" value="<?= $csrftoken ?>">
      <input type="submit" name="update" class="submit" value="更新">
    </form>
  </main>
</body>

</html>