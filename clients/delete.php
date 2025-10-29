<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../db.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("DELETE FROM clients WHERE id=?");
$stmt->execute([$id]);
header('Location: /projectorg/clients/list.php');
exit;
?>