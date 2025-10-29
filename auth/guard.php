<?php
require_once __DIR__ . '/../config.php';

function is_logged_in() {
    return !empty($_SESSION['user']) && !empty($_SESSION['user']['id']);
}
function current_user() {
    return $_SESSION['user'] ?? null;
}
function require_login() {
    if (!is_logged_in()) {
        $next = urlencode($_SERVER['REQUEST_URI'] ?? '/');
        header("Location: /projectorg/auth/login.php?next={$next}");
        exit;
    }
}
