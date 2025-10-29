<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../db.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM clients WHERE id=?");
$stmt->execute([$id]);
$item = $stmt->fetch();
if(!$item) { die('Запись не найдена'); }
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $stmt = $pdo->prepare("UPDATE clients SET name=?, contact=?, email=? WHERE id=?");
  $stmt->bindValue(1, trim($_POST['name'] ?? ''));
    $stmt->bindValue(2, trim($_POST['contact'] ?? ''));
    $stmt->bindValue(3, trim($_POST['email'] ?? ''));
    $stmt->bindValue(4, (int)$_GET['id']);
  $stmt->execute();
  header('Location: /projectorg/clients/list.php');
  exit;
}
include __DIR__ . '/../templates/header.php';
?>
<div class="container">
  <h2>Редактировать: Клиент #<?php echo $item['id']; ?></h2>
  <form method="post">
    
    <div class="mb-3">
      <label class="form-label">Название</label>
      <input class="form-control" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Контактное лицо</label>
      <input class="form-control" name="contact" value="<?php echo htmlspecialchars($item['contact']); ?>" type="text" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input class="form-control" name="email" value="<?php echo htmlspecialchars($item['email']); ?>" type="email" required>
    </div>
    <button class="btn btn-primary">Обновить</button>
    <a class="btn btn-secondary" href="list.php">Отмена</a>
  </form>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>