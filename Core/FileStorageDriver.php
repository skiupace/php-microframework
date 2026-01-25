<?php declare(strict_types=1);

namespace Core;

enum FileStorageDriver: string
{
  case LOCAL = 'local';
  case S3 = 's3';
}
