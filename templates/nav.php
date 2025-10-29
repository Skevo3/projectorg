<?php
// templates/nav.php
$logged = isset($_SESSION['user']);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/projectorg/index.php">ProjectOrg</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExample">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if($logged): ?>
        <li class="nav-item"><a class="nav-link" href="/projectorg/clients/list.php">Клиенты</a></li>
        <li class="nav-item"><a class="nav-link" href="/projectorg/projects/list.php">Проекты</a></li>
        <li class="nav-item"><a class="nav-link" href="/projectorg/tasks/list.php">Задачи</a></li>
        <li class="nav-item"><a class="nav-link" href="/projectorg/contacts/list.php">Обращения</a></li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav">
        <?php if($logged): ?>
        <li class="nav-item"><span class="navbar-text me-3">Роль: <?php echo htmlspecialchars($_SESSION['user']['role']); ?></span></li>
        <li class="nav-item"><a class="btn btn-outline-light" href="/projectorg/auth/logout.php">Выйти</a></li>
        <?php else: ?>
        <li class="nav-item"><a class="btn btn-outline-light" href="/projectorg/auth/login.php">Войти</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
