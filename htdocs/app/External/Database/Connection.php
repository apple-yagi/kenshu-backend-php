<?php

namespace App\External\Database;

use PDO;
use PDOException;
use Exception;

function connection(): PDO
{
  $dbname = getenv('MYSQL_DATABASE', false);
  $dbhost = getenv('MYSQL_HOST', false) ?: "localhost";
  $dbuser = getenv('MYSQL_USER', false) ?: "root";
  $dbpassword = getenv('MYSQL_PASSWORD', false) ?: "root";
  $dsn = "mysql:dbname=${dbname};host=${dbhost};charset=utf8";

  try {
    $db = new PDO($dsn, $dbuser, $dbpassword);
  } catch (PDOException $e) {
    throw new Exception($e->getMessage());
  }

  return $db;
};
