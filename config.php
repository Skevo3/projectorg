<?php

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'projectorg');
define('DB_USER', 'root');
define('DB_PASS', '');

define('ADMIN_ENTRY', '/projectorg/index.php');

session_name('PROJECTORGSESSID');

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$cookieParams = [
    'lifetime' => 0,
    'path'     => '/projectorg',
    'domain'   => '',
    'secure'   => $secure,
    'httponly' => true,
    'samesite' => 'Lax',
];

if (PHP_VERSION_ID >= 70300) {
    session_set_cookie_params($cookieParams);
} else {
    session_set_cookie_params(
        $cookieParams['lifetime'],
        $cookieParams['path'] . '; samesite=' . $cookieParams['samesite'],
        $cookieParams['domain'],
        $cookieParams['secure'],
        $cookieParams['httponly']
    );
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Throwable $e) {
    if (defined('APP_DEBUG') && APP_DEBUG) {
        die('DB error: ' . $e->getMessage());
    }
    http_response_code(500);
    exit;
}
