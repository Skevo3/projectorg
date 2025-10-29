<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../db.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $stmt = $pdo->prepare("INSERT INTO tasks (title, project_id, assignee, due_date, state) VALUES (?, ?, ?, ?, ?)");
  $stmt->bindValue(1, trim($_POST['title'] ?? ''));
    $stmt->bindValue(2, trim($_POST['project_id'] ?? ''));
    $stmt->bindValue(3, trim($_POST['assignee'] ?? ''));
    $stmt->bindValue(4, trim($_POST['due_date'] ?? ''));
    $stmt->bindValue(5, trim($_POST['state'] ?? ''));
  $stmt->execute();
  header('Location: /projectorg/tasks/list.php');
  exit;
}
include __DIR__ . '/../templates/header.php';
?>
<div class="container">
  <h2>Добавить: Задача</h2>
  <form method="post">
    
    <div class="mb-3">
      <label class="form-label">Название</label>
      <input class="form-control" name="title" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">ID проекта</label>
      <input class="form-control" name="project_id" type="number" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Исполнитель</label>
      <input class="form-control" name="assignee" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Срок (YYYY-MM-DD)</label>
      <input class="form-control" name="due_date" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Состояние</label>
      <input class="form-control" name="state" type="text" required>
    </div>
    <button class="btn btn-success">Сохранить</button>
    <a class="btn btn-secondary" href="list.php">Отмена</a>
  </form>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>