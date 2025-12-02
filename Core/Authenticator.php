<?php declare(strict_types=1);

namespace Core;

class Authenticator
{
  public function attempt(string $email, string $password): bool
  {
    $user = App::resolve(Database::class)->query('SELECT * FROM users WHERE email = :email', [
      'email'     => $email,
    ])->fetch();

    if ($user) {
      if (password_verify($password, $user['password'])) {
        $this->login($user);
        return true;
      }
    }
    return false;
  }

  public function login(array $user = []): void
  {
    $_SESSION['user'] = [
      'email' => $user['email']
    ];

    session_regenerate_id(true);
  }

  public function logout(): void
  {
    Session::destroy();
  }
}
