<?php
include __DIR__ . '/../public/_header.php';

require_once __DIR__ . '/../db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$ADMIN_ENTRY = '/projectorg/index.php/';

$err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login = trim($_POST['login'] ?? '');
  $pass  = trim($_POST['password'] ?? '');
  $next  = trim($_POST['next'] ?? '');

  try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user = null;
    foreach (['login','username','name'] as $col) {
      try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE {$col} = :v LIMIT 1");
        $stmt->execute([':v' => $login]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) { $user = $row; break; }
      } catch (Throwable $e) {
      }
    }

    if ($user) {
      $ok = false;
      if (!empty($user['password_hash'])) {
        $ok = password_verify($pass, $user['password_hash']);
      } elseif (!empty($user['password'])) {
        $ok = hash_equals((string)$user['password'], (string)$pass);
      } else {
        foreach (['pass','pwd','user_password'] as $pcol) {
          if (array_key_exists($pcol, $user)) {
            $ok = hash_equals((string)$user[$pcol], (string)$pass);
            break;
          }
        }
      }

      if ($ok) {
        $role = $user['role'] ?? 'client';
        if (!in_array($role, ['admin','client'], true)) { $role = 'client'; }

        $_SESSION['user'] = [
          'id'    => $user['id'] ?? null,
          'name'  => $user['name'] ?? ($user['username'] ?? ($user['login'] ?? 'Пользователь')),
          'email' => $user['email'] ?? '',
          'role'  => $role,
        ];

        if ($role === 'admin') {
          header("Location: {$ADMIN_ENTRY}");
          exit;
        } else {
          $dest = $next ?: ($_GET['next'] ?? '/projectorg/client/new-order.php');
          header("Location: {$dest}");
          exit;
        }
      } else {
        $err = "Неверный логин или пароль";
      }
    } else {
      $err = "Пользователь не найден";
    }

  } catch (Throwable $e) {
    $err = "Ошибка входа: " . $e->getMessage();
  }
}

$next = htmlspecialchars($_GET['next'] ?? '', ENT_QUOTES);
?>
<!doctype html>
<html lang="ru" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Вход</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
<style>
.auth-center {
  min-height: calc(100vh - 80px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding-top: 60px;
}
</style>
<main class="auth-center">
  <div class="card shadow" style="min-width:360px;max-width:420px;">
    <div class="card-body">
      <h1 class="h4 mb-3">Вход по логину</h1>
      <?php if ($err): ?><div class="alert alert-danger py-2"><?php echo htmlspecialchars($err); ?></div><?php endif; ?>
      <form method="post" class="vstack gap-3">
        <input type="hidden" name="next" value="<?php echo $next; ?>">
        <div>
          <label class="form-label">Логин</label>
          <input class="form-control" type="text" name="login" placeholder="например: admin" autofocus required>
        </div>
        <div>
          <label class="form-label">Пароль</label>
          <input class="form-control" type="password" name="password" placeholder="например: 12345" required>
        </div>
        <button class="btn btn-primary w-100" type="submit">Войти</button>
      </form>
      <hr>
      <p class="text-secondary small mb-0">Админ → CRUD. Клиент → «Новый заказ» (или ?next=).</p>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</main>
</body>
</html>
