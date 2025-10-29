<?php
include __DIR__ . '/../public/_header.php';
require_once __DIR__ . '/../db.php';

$ok = null;
$err = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $message = trim($_POST['message'] ?? '');

  if (!$name || !$email || !$message) {
    $err = 'Пожалуйста, заполните все поля.';
  } else {
    try {
      $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
      $stmt->execute([$name, $email, $message]);
      $ok = 'Ваше сообщение успешно отправлено!';
    } catch (Throwable $e) {
      $err = 'Ошибка при отправке: ' . $e->getMessage();
    }
  }
}
?>
<!doctype html>
<html lang="ru" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Контакты</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <div class="card shadow mx-auto" style="max-width:700px;">
    <div class="card-body">
      <h1 class="h4 mb-4">Свяжитесь с нами</h1>

      <?php if ($ok): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($ok); ?></div>
      <?php elseif ($err): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($err); ?></div>
      <?php endif; ?>

      <form method="post" class="vstack gap-3">
        <div>
          <label class="form-label">Имя *</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div>
          <label class="form-label">Email *</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div>
          <label class="form-label">Сообщение *</label>
          <textarea name="message" class="form-control" rows="4" required></textarea>
        </div>
        <button class="btn btn-primary w-100">Отправить сообщение</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
