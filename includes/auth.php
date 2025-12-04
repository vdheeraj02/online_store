<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool {
    return !empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: login.php?error=login_required');
        exit;
    }
}

function requireAdmin(): void {
    requireLogin(); // 

    if (!isAdmin()) {
        header('Location: index.php');
        exit;
    }
}
