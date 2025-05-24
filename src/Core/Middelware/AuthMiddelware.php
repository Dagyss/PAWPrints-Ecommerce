<?php
namespace Paw\Core\Middelware;
use Paw\App\Models\Users;


class AuthMiddelware{
    // Verifica que el token sea válido y no haya expirado
    public static function checkSessionTimeout(): void {
        $timeout = 3600;

        if (isset($_SESSION['user']['login_time']) && time() - $_SESSION['user']['login_time'] > $timeout) {
            Users::logout();
            header('Location: /login?expired=1');
            exit;
        }

        $_SESSION['user']['login_time'] = time();
    }
}