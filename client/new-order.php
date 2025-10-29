<?php
include __DIR__ . '/../public/_header.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../auth/guard.php';

if (session_status() === PHP_SESSION_NONE) { session_start(); }

$user = $_SESSION['user'];
$userId = $user['id'];

$err = null;
$ok = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $service = trim($_POST['service_type'] ?? '');
  $title = trim($_POST['title'] ?? '');
  $budget = $_POST['budget'] ?: null;
  $deadline = $_POST['deadline'] ?: null;
  $details = trim($_POST['details'] ?? '');

  if (!$email || !$service || !$title) {
    $err = 'Пожалуйста, заполните обязательные поля: Email, тип услуги и название.';
  } else {
    try {
      $stmt = $pdo->prepare("INSERT INTO orders (user_id, email, service_type, title, budget, deadline, details)
                             VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->execute([$userId, $email, $service, $title, $budget, $deadline, $details]);
      $ok = 'Заявка успешно создана!';
    } catch (Throwable $e) {
      $err = 'Ошибка при создании заявки: ' . $e->getMessage();
    }
  }
}
?>

<!doctype html>
<html lang="ru" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Новая заявка</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container py-5">
  <div class="card shadow mx-auto" style="max-width: 700px;">
    <div class="card-body">
      <h1 class="h4 mb-4">Создание новой заявки</h1>

      <?php if ($err): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($err); ?></div>
      <?php elseif ($ok): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($ok); ?></div>
      <?php endif; ?>

      <form method="post" class="vstack gap-3">
        <div>
          <label class="form-label">Email *</label>
          <input type="email" name="email" class="form-control" required placeholder="example@mail.ru">
        </div>
        <div>
          <label class="form-label">Тип услуги *</label>
          <input type="text" name="service_type" class="form-control" required placeholder="Например: разработка сайта">
        </div>
        <div>
          <label class="form-label">Название *</label>
          <input type="text" name="title" class="form-control" required placeholder="Краткое название проекта">
        </div>
        <div>
          <label class="form-label">Бюджет (₽)</label>
          <input type="number" name="budget" step="0.01" class="form-control" placeholder="Например: 10000">
        </div>
        <div>
          <label class="form-label">Срок выполнения</label>
          <input type="date" name="deadline" class="form-control">
        </div>
        <div>
          <label class="form-label">Описание</label>
          <textarea name="details" class="form-control" rows="3" placeholder="Опишите детали заказа"></textarea>
        </div>
        <button class="btn btn-primary w-100">Создать заявку</button>
      </form>

      <hr>

      </div>
    </div>
  </div>
</div>
</body>
</html>
