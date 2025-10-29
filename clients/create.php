<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../db.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $stmt = $pdo->prepare("INSERT INTO clients (name, contact, email) VALUES (?, ?, ?)");
  $stmt->bindValue(1, trim($_POST['name'] ?? ''));
    $stmt->bindValue(2, trim($_POST['contact'] ?? ''));
    $stmt->bindValue(3, trim($_POST['email'] ?? ''));
  $stmt->execute();
  header('Location: /projectorg/clients/list.php');
  exit;
}
include __DIR__ . '/../templates/header.php';
?>
<div class="container">
  <h2>Добавить: Клиент</h2>
  <form method="post">
    
    <div class="mb-3">
      <label class="form-label">Название</label>
      <input class="form-control" name="name" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Контактное лицо</label>
      <input class="form-control" name="contact" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input class="form-control" name="email" type="email" required>
    </div>
    <button class="btn btn-success">Сохранить</button>
    <a class="btn btn-secondary" href="list.php">Отмена</a>
  </form>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>