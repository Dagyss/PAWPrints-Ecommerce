<?php

namespace Paw\App\Models;

use Paw\Core\AbstractModel;

class Users extends AbstractModel {
    public $table = "Users";

    public $fields = [
        "id"       => null,
        "username" => null,
        "password" => null,
        "role"     => null,
        "avatar"     => null,
    ];

    public function set(array $values): void {
        foreach (array_keys($this->fields) as $field) {
            if (!array_key_exists($field, $values)) {
                continue;
            }
            $method = 'set' . str_replace('_', '', ucwords($field, '_'));
            if (method_exists($this, $method)) {
                $this->{$method}($values[$field]);
            } else {
                $this->fields[$field] = $values[$field];
            }
        }
    }

    public function getId(): ?int {
        return $this->fields['id'];
    }

    public function getUsername(): ?string {
        return $this->fields['username'];
    }

    public function getPassword(): ?string {
        return $this->fields['password'];
    }

    public function getRole(): ?string {
        return $this->fields['role'];
    }

    public function setId($id): void {
        $this->fields['id'] = (int) $id;
    }

    public function setUsername(string $username): void {
        $this->fields['username'] = trim($username);
    }

    public function setPassword(string $password): void {
        if (!password_get_info($password)['algo']) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
        $this->fields['password'] = $password;
    }

    public function setRole(string $role): void {
        $this->fields['role'] = strtolower(trim($role));
    }

    public function getAvatar(): ?string{
        return $this->fields['avatar'];
    }

    public function setAvatar(?string $avatar): void{
        $this->fields['avatar'] = $avatar;
    }
    public function verifyPassword(string $password): bool {
        if (empty($this->fields['password']) || !is_string($this->fields['password'])) {
            return false;
        }

        return password_verify($password, $this->fields['password']);
    }

    public function login(): void {
        $_SESSION['user'] = [
            'username' => $this->getUsername(),
            'avatar' => $this->getAvatar(),
            'role' => $this->getRole(),
            'id' => $this->getId(),
        ];
    }

    public static function logout(): void {
        session_unset();
        session_destroy();
    }

    public static function isLoggedIn(): bool {
        return isset($_SESSION['user']);
    }

    public static function currentRole(): ?string {
        return $_SESSION['user']['role'] ?? null;
    }

    public static function currentUserId(): ?int {
        return $_SESSION['user']['id'] ?? null;
    }

    public function select(array $params): array {
        $qb = $this->getQueryBuilder();
        $results = $qb->select($this->table, $params);

        $objects = [];
        foreach ($results as $row) {
            $user = new self();
            $user->set($row);
            $objects[] = $user;
        }

        return $objects;
    }
}
