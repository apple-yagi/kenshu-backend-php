<?php

namespace App\External\Csrf;

class TokenManager
{
  public static function generateToken()
  {
    return hash('sha256', session_id());
  }

  public static function validateToken($token)
  {
    return $token === self::generateToken();
  }

  public static function h($str)
  {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }
}
