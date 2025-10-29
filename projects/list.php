<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../db.php';
$stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
$rows = $stmt->fetchAll();
include __DIR__ . '/../templates/header.php';
?>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Проекты</h2>
    <a class="btn btn-success" href="create.php">Добавить</a>
  </div>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead><tr><th>ID</th><th>Название</th><th>ID клиента</th><th>Менеджер</th><th>Бюджет</th><th>Статус</th><th>Дедлайн</th><th></th></tr></thead>
      <tbody>
      <?php foreach($rows as $row): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['title']); ?></td><td><?php echo htmlspecialchars($row['client_id']); ?></td><td><?php echo htmlspecialchars($row['manager']); ?></td><td><?php echo htmlspecialchars($row['budget']); ?></td><td><?php echo htmlspecialchars($row['status']); ?></td><td><?php echo htmlspecialchars($row['deadline']); ?></td>
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