<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../db.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=?");
$stmt->execute([$id]);
$item = $stmt->fetch();
if(!$item) { die('Запись не найдена'); }
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $stmt = $pdo->prepare("UPDATE projects SET title=?, client_id=?, manager=?, budget=?, status=?, deadline=? WHERE id=?");
  $stmt->bindValue(1, trim($_POST['title'] ?? ''));
    $stmt->bindValue(2, trim($_POST['client_id'] ?? ''));
    $stmt->bindValue(3, trim($_POST['manager'] ?? ''));
    $stmt->bindValue(4, trim($_POST['budget'] ?? ''));
    $stmt->bindValue(5, trim($_POST['status'] ?? ''));
    $stmt->bindValue(6, trim($_POST['deadline'] ?? ''));
    $stmt->bindValue(7, (int)$_GET['id']);
  $stmt->execute();
  header('Location: /projectorg/projects/list.php');
  exit;
}
include __DIR__ . '/../templates/header.php';
?>
<div class="container">
  <h2>Редактировать: Проект #<?php echo $item['id']; ?></h2>
  <form method="post">
    
    <div class="mb-3">
      <label class="form-label">Название</label>
      <input class="form-control" name="title" value="<?php echo htmlspecialchars($item['title']); ?>" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">ID клиента</label>
      <input class="form-control" name="client_id" value="<?php echo htmlspecialchars($item['client_id']); ?>" type="number" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Менеджер</label>
      <input class="form-control" name="manager" value="<?php echo htmlspecialchars($item['manager']); ?>" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Бюджет</label>
      <input class="form-control" name="budget" value="<?php echo htmlspecialchars($item['budget']); ?>" type="number" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Статус</label>
      <input class="form-control" name="status" value="<?php echo htmlspecialchars($item['status']); ?>" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Дедлайн (YYYY-MM-DD)</label>
      <input class="form-control" name="deadline" value="<?php echo htmlspecialchars($item['deadline']); ?>" type="text" required>
    </div>
    <button class="btn btn-primary">Обновить</button>
    <a class="btn btn-secondary" href="list.php">Отмена</a>
  </form>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>