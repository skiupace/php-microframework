<?php

declare(strict_types=1);

namespace Core;

class ValidationException extends \Exception
{
  public static function throw(array $errors = [], array $old = [])
  {
    $instance = new static;

    $instance->errors = $errors;
    $instance->old = $old;

    throw $instance;
  }

  public readonly array $errors;
  public readonly array $old;
}
