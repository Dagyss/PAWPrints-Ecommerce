<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\App\Models\Users;

class AuthController extends AbstractController {
    public function login(){

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $_SESSION['errors'] = ['Credenciales inválidas'];
            return;
        }

        $userModel = $this->getModel(Users::class);

        $users = $userModel->select(['username' => $email]);
        if (
            is_array($users) &&
            count($users) > 0 &&
            $users[0]->verifyPassword($password)
        ) {
            $user = $users[0];
            $user->login();
            header('Location: /');
            exit;
        }else{
            $_SESSION['errors'] = ['Credenciales inválidas'];
            header('Location: /login');
            exit;
        }
    }

    public function logout(){
        Users::logout();
        header('Location: /login');
        exit;
    }
}
