<?php declare(strict_types=1);

namespace Core;

interface FileStorage
{
  public function put(string $path, string $content): bool;
  public function get(string $path): ?string;
}
