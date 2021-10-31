<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\AuthController;
use App\Adapter\Repositories\AuthRepository;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\Adapter\Controllers\Errors\ValidationException;
use App\External\Session\LoginSessionManager;
use App\Usecase\AuthInteractor;

use function App\External\Database\Connection;

LoginSessionManager::requireUnloginedSession();

$csrftoken = CsrfTokenManager::h(CsrfTokenManager::generateToken());

if (isset($_POST['register'])) {
  if (!CsrfTokenManager::validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }

  $pdo = connection();
  $authRepository = new AuthRepository($pdo);
  $authInteractor = new AuthInteractor($authRepository);
  $authController = new AuthController($authInteractor);

  try {
    $authController->register((object) $_POST);
  } catch (ValidationException $e) {
    $validationError = $e->getArrayMessage();
  } catch (Exception $e) {
    $exception = $e;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>ユーザー | 新規</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1 class="title">ユーザー | 新規</h1>
    <?php if (isset($exception)) : ?>
      <p class="text-danger"><?= $exception->getMessage() ?></p>
    <?php endif; ?>
    <form action="register" method="POST">
      <div class="mb-5">
        <label for="name" class="form-label">名前</label>
        <input type="text" name="name" class="form-control" id="name" value="<?= isset($_POST["name"]) ? $_POST["name"] : "" ?>" aria-describedby="nameHelp">
        <?php if (isset($validationError["name"])) : ?>
          <p id="nameHelp" class="form-text text-danger"><?= $validationError["name"] ?></p>
        <?php else : ?>
          <p id="nameHelp" class="form-text">2~15文字の間で入力してください（必須項目）</p>
        <?php endif; ?>
      </div>
      <div class="mb-5">
        <label for="password" class="form-label">パスワード</label>
        <input type="password" name="password" class="form-control" id="password" value="<?= isset($_POST["password"]) ? $_POST["password"] : "" ?>" aria-describedby="passwordHelp">
        <?php if (isset($validationError["password"])) : ?>
          <p id="passwordHelp" class="form-text text-danger"><?= $validationError["password"] ?></p>
        <?php else : ?>
          <p id="passwordHelp" class="form-text">6文字以上入力してください（必須項目）</p>
        <?php endif; ?>
      </div>
      <input type="hidden" name="token" value="<?= $csrftoken ?>">
      <input type="submit" name="register" class="submit" value="登録">
    </form>
  </main>
</body>

</html>