<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    function getLoggedUser(): ?array {
        if (!isset($_SESSION['user']) || empty($_SESSION['user']['username'])) {
            return null;
        }
        return $_SESSION['user'];
    }

    function getLoggedUsername(): string {
        return $_SESSION['user']['username'] ?? 'Mi cuenta';
    }

?>