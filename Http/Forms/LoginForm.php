<?php

declare(strict_types=1);

namespace Http\Forms;

use Core\Validator;
use Core\ValidationException;

class LoginForm
{
  // *as of php 8.x this is an inline declaration*
  public function __construct(public array $attributes = [])
  {
    if (!Validator::email($attributes['email'])) {
      $this->errors['email'] = 'Please provide a valid email address.';
    }

    if (!Validator::string($attributes['password'])) {
      $this->errors['password'] = 'Please provide a valid password.';
    }
  }

  public static function validate(array $attributes = []): null|static
  {
    $instance = new static($attributes);
    return $instance->failed() ? $instance->throw() : $instance;
  }

  public function throw(): void
  {
    ValidationException::throw($this->errors(), $this->attributes);
  }

  public function failed(): bool
  {
    return (bool)count($this->errors);
  }

  public function errors(): array
  {
    return $this->errors;
  }

  public function error(string $field, string $message): LoginForm
  {
    $this->errors[$field] = $message;
    return $this;
  }

  private array $errors = [];
}
