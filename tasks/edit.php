<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../db.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id=?");
$stmt->execute([$id]);
$item = $stmt->fetch();
if(!$item) { die('Запись не найдена'); }
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $stmt = $pdo->prepare("UPDATE tasks SET title=?, project_id=?, assignee=?, due_date=?, state=? WHERE id=?");
  $stmt->bindValue(1, trim($_POST['title'] ?? ''));
    $stmt->bindValue(2, trim($_POST['project_id'] ?? ''));
    $stmt->bindValue(3, trim($_POST['assignee'] ?? ''));
    $stmt->bindValue(4, trim($_POST['due_date'] ?? ''));
    $stmt->bindValue(5, trim($_POST['state'] ?? ''));
    $stmt->bindValue(6, (int)$_GET['id']);
  $stmt->execute();
  header('Location: /projectorg/tasks/list.php');
  exit;
}
include __DIR__ . '/../templates/header.php';
?>
<div class="container">
  <h2>Редактировать: Задача #<?php echo $item['id']; ?></h2>
  <form method="post">
    
    <div class="mb-3">
      <label class="form-label">Название</label>
      <input class="form-control" name="title" value="<?php echo htmlspecialchars($item['title']); ?>" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">ID проекта</label>
      <input class="form-control" name="project_id" value="<?php echo htmlspecialchars($item['project_id']); ?>" type="number" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Исполнитель</label>
      <input class="form-control" name="assignee" value="<?php echo htmlspecialchars($item['assignee']); ?>" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Срок (YYYY-MM-DD)</label>
      <input class="form-control" name="due_date" value="<?php echo htmlspecialchars($item['due_date']); ?>" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Состояние</label>
      <input class="form-control" name="state" value="<?php echo htmlspecialchars($item['state']); ?>" type="text" required>
    </div>
    <button class="btn btn-primary">Обновить</button>
    <a class="btn btn-secondary" href="list.php">Отмена</a>
  </form>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>