<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\External\Session\LoginSessionManager;

LoginSessionManager::requireLoginedSession();

LoginSessionManager::unsetLoginSession();
header("Location: /");
