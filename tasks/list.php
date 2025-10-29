<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../db.php';
$stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC");
$rows = $stmt->fetchAll();
include __DIR__ . '/../templates/header.php';
?>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Задачи</h2>
    <a class="btn btn-success" href="create.php">Добавить</a>
  </div>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead><tr><th>ID</th><th>Название</th><th>ID проекта</th><th>Исполнитель</th><th>Срок</th><th>Состояние</th><th></th></tr></thead>
      <tbody>
      <?php foreach($rows as $row): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['title']); ?></td><td><?php echo htmlspecialchars($row['project_id']); ?></td><td><?php echo htmlspecialchars($row['assignee']); ?></td><td><?php echo htmlspecialchars($row['due_date']); ?></td><td><?php echo htmlspecialchars($row['state']); ?></td>
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