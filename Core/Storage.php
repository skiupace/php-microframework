<?php declare(strict_types=1);

namespace Core;

use Aws\S3\S3Client;
use Exception;

class Storage
{
  /**
   * @throws Exception
   */
  public static function resolve(): FileStorage
  {
    $driver = FileStorageDriver::from($_ENV['FILE_STORAGE_DRIVER']);

    if ($driver === FileStorageDriver::LOCAL) {
      return new LocalStorage();
    } else if ($driver === FileStorageDriver::S3) {
      $client = new S3Client([
        'version' => 'latest',
        'region' => $_ENV['AWS_DEFAULT_REGION'],
        'endpoint' => $_ENV['AWS_DEFAULT_ENDPOINT'],
        'credentials' => [
          'key' => $_ENV['AWS_ACCESS_KEY_ID'],
          'secret' => $_ENV['AWS_SECRET_ACCESS_KEY']
        ]
      ]);

      return new S3Storage($client, $_ENV['AWS_BUCKET']);
    }

    throw new Exception('Invalid storage method.');
  }
}
