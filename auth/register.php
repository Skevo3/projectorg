<?php
include __DIR__ . '/../public/_header.php';

require_once __DIR__ . '/../db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$err = null;
$ok = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login = trim($_POST['login'] ?? '');
  $pass1 = trim($_POST['password'] ?? '');
  $pass2 = trim($_POST['password2'] ?? '');

  if (!$login || !$pass1 || !$pass2) {
    $err = 'Заполните логин и пароль.';
  } elseif ($pass1 !== $pass2) {
    $err = 'Пароли не совпадают.';
  } else {
    try {
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $pdo->prepare("SELECT id FROM users WHERE login = :login LIMIT 1");
      $stmt->execute([':login' => $login]);
      if ($stmt->fetch()) {
        $err = 'Такой логин уже существует.';
      } else {
        $hash = password_hash($pass1, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (login, password_hash, role) VALUES (:login, :hash, 'client')");
        $stmt->execute([':login' => $login, ':hash' => $hash]);

        $_SESSION['user'] = [
          'id' => $pdo->lastInsertId(),
          'name' => $login,
          'role' => 'client',
        ];
        header("Location: /projectorg/profile.php");
        exit;
      }
    } catch (Throwable $e) {
      $err = 'Ошибка регистрации: ' . $e->getMessage();
    }
  }
}
?>
<!doctype html>
<html lang="ru" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Регистрация</title>
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
  <div class="card shadow" style="min-width:360px;max-width:400px;">
    <div class="card-body">
      <h1 class="h4 mb-3">Регистрация</h1>
      <?php if ($err): ?><div class="alert alert-danger py-2"><?php echo htmlspecialchars($err); ?></div><?php endif; ?>
      <form method="post" class="vstack gap-3">
        <div>
          <label class="form-label">Логин *</label>
          <input class="form-control" name="login" required>
        </div>
        <div>
          <label class="form-label">Пароль *</label>
          <input class="form-control" type="password" name="password" required>
        </div>
        <div>
          <label class="form-label">Повторите пароль *</label>
          <input class="form-control" type="password" name="password2" required>
        </div>
        <button class="btn btn-primary w-100" type="submit">Зарегистрироваться</button>
      </form>
      <hr>
      <div class="text-center small text-secondary">
        Уже есть аккаунт? <a href="/projectorg/auth/login.php">Войти</a>
      </div>
    </div>
  </div>
</main>
</body>
</html>
