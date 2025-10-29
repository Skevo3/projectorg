<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
if (!isset($_SESSION['user'])) { header('Location: /projectorg/auth/login.php'); exit; }
include __DIR__ . '/templates/header.php';
?>
<div class="container">
  <div class="p-4 mb-4 bg-light rounded-3">
    <h1 class="display-6">Информационная система проектной организации</h1>
    <p class="lead">Учёт клиентов, проектов и задач. Быстрые CRUD-операции и отчёты по статусам.</p>
  </div>
  <div class="row g-3">
    <div class="col-md-3">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Клиенты</h5>
          <p class="card-text">Справочник заказчиков: создание, редактирование, удаление.</p>
          <a class="btn btn-primary" href="/projectorg/clients/list.php">Открыть</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Проекты</h5>
          <p class="card-text">Учёт проектов, бюджеты, менеджеры, статусы и сроки.</p>
          <a class="btn btn-primary" href="/projectorg/projects/list.php">Открыть</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Задачи</h5>
          <p class="card-text">Постановка задач по проектам, исполнители, дедлайны.</p>
          <a class="btn btn-primary" href="/projectorg/tasks/list.php">Открыть</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Обращения</h5>
          <p class="card-text">Заявки с формы контактов сайта.</p>
          <a class="btn btn-primary" href="/projectorg/contacts/list.php">Открыть</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/templates/footer.php'; ?>
