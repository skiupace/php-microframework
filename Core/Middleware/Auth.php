<?php

namespace Core\Middleware;

final class Auth extends Middleware
{
  #[\Override]
  public function handle(): void
  {
    if (!$_SESSION['user'] ?? false) {
      header('location: /');
      exit();
    }
  }
}
