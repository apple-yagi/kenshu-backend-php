<?php
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
session_start();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>Top</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../view/components/Header.php') ?>
  <main class="container">
    <h1 class="title">トップページ</h1>
  </main>
</body>

</html>