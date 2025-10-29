<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
  $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
  $stmt->execute([$id]);
}

header('Location: /projectorg/contacts/list.php');
exit;
