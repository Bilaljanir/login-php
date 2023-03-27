<?php

namespace PhpLogin\Auth;

use PhpLogin\Db\Db;

class Auth
{
    private Db $db;

    private bool|array $user;

    public function __construct(Db $db)
    {
        $this->db = $db;
        isset($_SESSION['user_id']) ? $this->loadUser($_SESSION['user_id']) : $this->user = false;
    }

    public function loadUser(int $id): void
    {
        $this->user = $this->db->run(
            'SELECT id, email, password FROM "user" WHERE id = ?',
            [$id]
        )->fetch();
    }

    public function register(string $username, string $password): void
    {
        $this->db->run(
            'INSERT INTO "user" (email, password) VALUES (?, ?);',
            [
                $username,
                password_hash($password, PASSWORD_DEFAULT)
            ]
        );
    }

    public function login(string $email, string $password): bool|array
    {
        if ($this->check()) {
            return $this->user;
        }

        $user = $this->userExists($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $this->user = $user;
            return $this->user;
        }

        return false;
    }

    public function check(): bool|array
    {
        return $this->user;
    }

    public function userExists(string $email): array
    {
        return $this->db->run(
            'SELECT id, email, password FROM "user" WHERE email = ?',
            [$email]
        )->fetch();
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        $this->user = false;
    }
}
