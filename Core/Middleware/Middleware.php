<?php declare(strict_types=1);

namespace Core\Middleware;

class Middleware
{
  public function handle(): void {}
  public static function resolve(?string $key): void
  {
    if (!$key) {
      return;
    }

    $middleware = static::MAP[$key] ?? false;
    if (!$middleware) {
      throw new \Exception("No matching middleware found for key '$key'.");
    }

    (new $middleware)->handle();
  }

  private const array MAP = [
    'guest'   => Guest::class,
    'auth'    => Auth::class
  ];
}
