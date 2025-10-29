<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../db.php';
$stmt = $pdo->query("SELECT * FROM clients ORDER BY id DESC");
$rows = $stmt->fetchAll();
include __DIR__ . '/../templates/header.php';
?>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Клиенты</h2>
    <a class="btn btn-success" href="create.php">Добавить</a>
  </div>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead><tr><th>ID</th><th>Название</th><th>Контакт</th><th>Email</th><th></th></tr></thead>
      <tbody>
      <?php foreach($rows as $row): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td><td><?php echo htmlspecialchars($row['contact']); ?></td><td><?php echo htmlspecialchars($row['email']); ?></td>
          <td class="table-actions">
            <a class="btn btn-sm btn-primary" href="edit.php?id=<?php echo $row['id']; ?>">Изменить</a>
            <a class="btn btn-sm btn-danger" href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Удалить запись?');">Удалить</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>