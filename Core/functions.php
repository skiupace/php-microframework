<?php

use Core\Response;

function dd($value): void
{
  echo "<pre>";
  echo "<strong>";
  var_dump($value);
  echo "</strong>";
  echo "</pre>";
  die();
}

function abort($code = 404)
{
  http_response_code($code);
  $codePage = "views/{$code}.php";
  if (file_exists(base_path($codePage))) {
    require base_path($codePage);
  } else {
    echo "The requested code page doesn't exist!";
  }
  die();
}

function authorize($condition, $status = Response::FORBIDDEN): void
{
  if (!$condition) {
    abort($status);
  }
}

function base_path($path): string
{
  return BASE_PATH . $path;
}

function view($path, $attributes = []): void
{
  extract($attributes);
  require base_path("views/{$path}");
}

function redirect($path): void
{
  header("location: {$path}");
  exit();
}

function old($key, $default = ''): mixed
{
  return Core\Session::get('old')[$key] ?? $default;
}
