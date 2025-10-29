<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../db.php';
require_login(); $user = current_user();

try {
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :uid ORDER BY id DESC");
  $stmt->execute([':uid'=>$user['id']]);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) { $rows = []; $err = $e->getMessage(); }
?>
<?php require __DIR__ . '/../public/_header.php'; ?>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Мои заявки</h2>
    <div class="d-flex gap-2">
      <a class="btn btn-sm btn-primary" href="/projectorg/client/new-order.php">Новая заявка</a>
      <a class="btn btn-sm btn-outline-secondary" href="/projectorg/auth/logout.php">Выйти</a>
    </div>
  </div>
  <?php if (!empty($err)): ?><div class="alert alert-warning"><?php echo htmlspecialchars($err); ?></div><?php endif; ?>
  <?php if (!$rows): ?>
    <div class="text-secondary">Пока нет заявок. <a href="/projectorg/client/new-order.php">Создать первую</a>.</div>
  <?php else: ?>
    <div class="table-responsive card-soft p-2 rounded">
      <table class="table align-middle mb-0">
        <thead class="table-dark"><tr><th>ID</th><th>Услуга</th><th>Заголовок</th><th>Бюджет</th><th>Дедлайн</th><th>Статус</th><th>Создано</th></tr></thead>
        <tbody>
          <?php foreach($rows as $r): ?>
          <tr>
            <td><?php echo (int)$r['id']; ?></td>
            <td><?php echo htmlspecialchars($r['service_type']); ?></td>
            <td><?php echo htmlspecialchars($r['title']); ?></td>
            <td><?php echo $r['budget'] !== null ? number_format((float)$r['budget'], 2, ',', ' ') : '—'; ?></td>
            <td><?php echo htmlspecialchars($r['deadline'] ?? '—'); ?></td>
            <td><span class="badge-po warn"><?php echo htmlspecialchars($r['status']); ?></span></td>
            <td><?php echo htmlspecialchars($r['created_at']); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
<?php require __DIR__ . '/../public/_footer.php'; ?>
