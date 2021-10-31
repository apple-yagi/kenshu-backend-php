<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\AuthController;
use App\Adapter\Repositories\AuthRepository;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\External\Session\LoginSessionManager;
use App\Usecase\AuthInteractor;

use function App\External\Database\Connection;

LoginSessionManager::requireUnloginedSession();

$csrftoken = CsrfTokenManager::h(CsrfTokenManager::generateToken());

if (isset($_POST['login'])) {
  if (!CsrfTokenManager::validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }

  $pdo = connection();
  $authRepository = new AuthRepository($pdo);
  $authInteractor = new AuthInteractor($authRepository);
  $authController = new AuthController($authInteractor);

  try {
    $result = $authController->login((object) $_POST);

    session_regenerate_id(true);
    LoginSessionManager::setLoginSession($result);
    header('Location: /mypage');
    exit;
  } catch (Exception $e) {
    $exception = $e;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1 class="title">Login Form</h1>
    <?php if (isset($exception)) : ?>
      <p class="text-danger"><?= $exception->getMessage() ?></p>
    <?php endif; ?>
    <form action="login" method="POST">
      <div class="mb-5">
        <label for="name" class="form-label">名前</label>
        <input type="text" name="name" class="form-control" id="name">
      </div>
      <div class="mb-5">
        <label for="password" class="form-label">パスワード</label>
        <input type="password" name="password" class="form-control" id="password">
      </div>
      <input type="hidden" name="token" value="<?= $csrftoken ?>">
      <input type="submit" name="login" class="submit" value="ログイン">
    </form>
  </main>
</body>

</html>