<?php declare(strict_types=1);

namespace Core;

use Core\Middleware\Middleware;

class Router
{
  private function __construct() {}
  public static function getRouter(): Router
  {
    if (!isset(self::$router)) {
      self::$router = new Router();
    }

    return self::$router;
  }

  public function get(string $uri, string $controller): Router
  {
    return $this->addRoute('GET', $uri, $controller);
  }

  public function post(string $uri, string $controller): Router
  {
    return $this->addRoute('POST', $uri, $controller);
  }

  public function delete(string $uri, string $controller): Router
  {
    return $this->addRoute('DELETE', $uri, $controller);
  }

  public function patch(string $uri, string $controller): Router
  {
    return $this->addRoute('PATCH', $uri, $controller);
  }

  public function put(string $uri, string $controller): Router
  {
    return $this->addRoute('PUT', $uri, $controller);
  }

  public function only(string $key): Router
  {
    self::$routes[array_key_last(self::$routes)]['middleware'] = $key;
    return $this;
  }

  public function route(string $uri, string $method): int
  {
    $requestMethod = strtoupper($method);

    foreach (self::$routes as $route) {
      if ($route['method'] !== $requestMethod) {
        continue;
      }

      if (preg_match($route['uri_regex'], $uri, $matches)) {
        // $matches[0] is the full matched string, so skip it.
        $params = \array_slice($matches, 1);

        $controller = base_path("Http/controllers/{$route['controller']}");

        if (!file_exists($controller)) {
          $this->abort(Response::INTERNAL_SERVER_ERROR);
        }

        if (!empty($route['placeholders'])) {
          $namedParams = array_combine($route['placeholders'], $params);
          extract($namedParams);
        }

        Middleware::resolve($route['middleware']);
        return (require $controller) ?? 1;
      }
    }

    $this->abort();
    return -1;
  }

  private function addRoute(string $method, string $uri, string $controller): Router
  {
    $placeholders = [];
    preg_match_all('/\{([a-zA-Z0-9_]+)\}/', $uri, $matches);
    if (isset($matches[1])) {
      $placeholders = $matches[1];
    }

    // Convert the URI pattern with placeholders into a regex
    $escapedUri = str_replace('/', '\/', $uri);
    $uriRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $escapedUri);
    $finalRegex = "#^$uriRegex\$#"; // Add start and end anchors

    self::$routes[] = [
      'uri'           => $uri,
      'uri_regex'     => $finalRegex,
      'placeholders'  => $placeholders,
      'controller'    => $controller,
      'method'        => $method,
      'middleware'  => null
    ];

    return $this;
  }

  public function previousUrl(): string
  {
    return $_SERVER['HTTP_REFERER'];
  }

  private function abort(int $code = 404): void
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

  private static array $routes = [];
  private static ?Router $router = null;
}
