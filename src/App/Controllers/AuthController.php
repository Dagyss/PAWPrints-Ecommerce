<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\App\Models\Users;

class AuthController extends AbstractController {

    public function register(){

        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $confirmPassword = $_POST['confirm_password'] ?? null;
        $full_name = $_POST['full_name'] ?? null;
        $role = $_POST['role'] ?? 'cliente';

        $userModel = $this->getModel(Users::class);

        $errors = [];

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El correo electrónico no es válido.";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Las contraseñas no coinciden.";
        }

        if (empty($full_name)) {
            $errors[] = "El Nombre completo es obligatorio.";
        }

        
        $users = $userModel->select(['username' => $email]);
        if (
            is_array($users) &&
            count($users) > 0
        ) { 
            $errors[] = "El email ingresado ya se encuentra en uso.";
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
            header('Location: /create-account');
            exit;
        }
        
        $userModel->setUsername($email);
        $userModel->setPassword($password);
        $userModel->setRole($role);
        $createdUser = $userModel->insert();
        if(!$createdUser){
            $errors[] = "Hubo un error al intentar crear el usuario ". $email;
            $_SESSION['errors'] = $errors;
            header('Location: /create-account');
            exit;
            
        }
        $_SESSION['success'] = "Se creo correctamente el usuario " . $email;
        header('Location: /create-account');
        exit;
    }


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
