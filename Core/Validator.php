<?php declare(strict_types= 1);

namespace Core;

use function strlen;

class Validator
{
  public static function string(string $value, float $min = 1, float $max = INF): bool
  {
    $value = trim($value);
    return strlen($value) >= round($min) && strlen($value) <= round($max);
  }

  public static function isUrl(string $value): bool
  {
    return $_SERVER['REQUEST_URI'] === $value;
  }

  public static function email(string $value): bool
  {
    return (bool)filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  public static function greaterThan(int $value, int $greaterThan): bool
  {
    return $value > $greaterThan;
  }
}
