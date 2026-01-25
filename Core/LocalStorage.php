<?php declare(strict_types=1);

namespace Core;

class LocalStorage implements FileStorage
{
  public function __construct()
  {
    $this->basePath = __DIR__ . "/../{$_ENV['FILE_STORAGE_LOCAL_PATH']}";
  }

  public function put(string $path, string $content): bool
  {
    $savePath = "{$this->basePath}/{$path}";

    if (!is_dir(dirname($savePath))) {
      mkdir(dirname($savePath), 0777, true);
    }

    file_put_contents($savePath, $content);
    return true;
  }

  public function get(string $path): ?string
  {
    $fullPath = "{$this->basePath}$path";

    if (!file_exists($fullPath)) {
      throw new \Exception("File not found: {$path}");
    }

    if (!is_readable($fullPath)) {
      throw new \Exception("File not readable: {$path}");
    }

    return file_get_contents($fullPath);
  }

  protected string $basePath;
}
