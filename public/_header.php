<?php
require_once __DIR__ . '/../config.php';
$user = $_SESSION['user'] ?? null;
?>
<!doctype html>
<html lang="ru" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ProjectOrg — Проектная организация</title>
  <link rel="icon" type="image/svg+xml" href="/projectorg/public/assets/logo.svg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="/projectorg/public/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg bg-body-terмиary border-bottom sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/projectorg/public/index.php">
      <img src="/projectorg/public/assets/logo.svg" alt="" width="22" height="22">
      <strong>ProjectOrg</strong>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav"
      aria-controls="publicNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="publicNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="/projectorg/public/index.php">Главная</a></li>
        <li class="nav-item"><a class="nav-link" href="/projectorg/public/about.php">О компании</a></li>
        <li class="nav-item"><a class="nav-link" href="/projectorg/public/services.php">Услуги</a></li>
        <li class="nav-item"><a class="nav-link" href="/projectorg/public/projects.php">Проекты</a></li>
        <li class="nav-item"><a class="nav-link" href="/projectorg/public/contact.php">Контакты</a></li>
      </ul>

      <div class="d-flex gap-2">
        <?php if (!$user): ?>
          <a class="btn btn-outline-light"
             href="/projectorg/auth/login.php?next=<?php echo urlencode($_SERVER['REQUEST_URI'] ?? '/projectorg/public/index.php'); ?>">
            Войти
          </a>
          <a class="btn btn-outline-secondary" href="/projectorg/auth/register.php">Регистрация</a>
          <a class="btn btn-primary" href="/projectorg/auth/login.php?next=/projectorg/client/new-order.php">
            Оформить заказ
          </a>
        <?php else: ?>
          <?php if (($user['role'] ?? 'client') === 'admin'): ?>
            <a class="btn btn-outline-light" href="/projectorg/index.php">Админка</a>
          <?php else: ?>
            <a class="btn btn-outline-light" href="/projectorg/client/orders.php">Мои заявки</a>
            <a class="btn btn-primary" href="/projectorg/client/new-order.php">Новый заказ</a>
          <?php endif; ?>
          <a class="btn btn-secondary" href="/projectorg/auth/logout.php">Выйти</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<main class="flex-grow-1">
