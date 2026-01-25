<?php declare(strict_types=1);

namespace Core;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class S3Storage implements FileStorage
{
  public function __construct(protected S3Client $client, protected string $bucket)
  {
  }

  public function put(string $path, string $content): bool
  {
    try {
      $this->client->putObject([
        'Bucket' => $this->bucket,
        'Key' => $path,
        'Body' => $content,
      ]);
      return true;
    } catch (S3Exception $e) {
      echo "Failed to upload file to S3: {$e->getMessage()}\n";
      return false;
    }
  }

  public function get(string $path): ?string
  {
    try {
      $result = $this->client->getObject([
        'Bucket' => $this->bucket,
        'Key' => $path,
      ]);
      return $result->get('Body')->getContents();
    } catch (S3Exception $e) {
      throw new \Exception("Failed to get file from S3: {$e->getMessage()}");
    }
  }
}
