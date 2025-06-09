<?php
namespace Paw\Core\Middelware;
use Paw\App\Models\Users;


class AuthMiddelware{
    // Verifica que el token sea válido y no haya expirado
    public static function checkSessionTimeout(): void {
        $timeout = 3600;

        if (isset($_SESSION['user']['login_time']) && time() - $_SESSION['user']['login_time'] > $timeout) {
            Users::logout();
            header('Location: /error-403');
            exit;
        }

        $_SESSION['user']['login_time'] = time();
    }

    public static function checkSession(): void {
        if (!isset($_SESSION['user']['username'])) {
            header('Location: /error-403');
            exit;
        }

        $_SESSION['user']['login_time'] = time();
    }
}