<?php

namespace App\External\Session;

class LoginSessionManager
{
  public static function requireUnloginedSession()
  {
    @session_start();
    if (isset($_SESSION['username'], $_SESSION['user_id'])) {
      header('Location: /mypage');
      exit;
    }
  }

  public static function requireLoginedSession()
  {
    @session_start();
    if (!isset($_SESSION['username'], $_SESSION['user_id'])) {
      header('Location: /auth/login.php');
      exit;
    }
  }

  public static function setLoginSession(object $user)
  {
    if (!$user) {
      echo "ログインセッションの設定に失敗しました";
      return;
    }
    $_SESSION['user_id'] = $user->id;
    $_SESSION['username'] = $user->name;
  }

  public static function unsetLoginSession()
  {
    setcookie(session_name(), '', 1);
    session_destroy();
  }

  public static function h($str)
  {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }
}
