<?php

namespace Core;
abstract class Controller extends Layout {

  private $dependencies = [];
  private $middlewares  = [];
  private $class_name = null;

  protected $rules = [];

  public function __construct() {
    $this->class_name = get_class($this);
  }

  protected function middleware($name, $fn) {

    $this->middlewares[$this->class_name][$name] = $fn;

  }

  public function applyMiddleware($action) {

    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $rules = $this->rules['post'] ?? [];
    
    if ($method === 'get' && !empty($rules) && in_array($action, $rules)) {

      $this->view('404');


    } else {

      $middlewares = $this->middlewares[$this->class_name] ?? [];
      $fn = $middlewares[$action] ?? false;

      $fn ? ($fn() ? $this->$action() : $this->view('404')) : $this->$action();

    }
    
  }

  public function setDependencies($deps = []) {

    foreach ($deps as $key => $className) {
      $this->dependencies[$key] = (new \ReflectionClass($className))->newInstance();
    }

    return $this;

  }

  public function setInput($key, $value = null) {

    $this->input->set($key, $value);
    return $this;

  }

  /**
   * Use inside controller:
   *
   * $uri = ['page' = 'login', 'action' = 'index'] #OR
   * $uri = 'page=login&action=index'
   *
   * $this->redirect($uri);
   *
   */
  protected function redirect($uri) {

    $url = BASE_URL;

    if (!empty($uri)) {
      $url .= '?' . (is_array($uri) ? http_build_query($uri) : $uri);
    }

    header("Location: " . $url);
    exit;

  }

  /**
   * Redirect back
   *
   */
  protected function back() {
    
    $uri = [
      'page'   => $this->input->old('page'),
      'action' => $this->input->old('action'),
    ];

    header("Location: " . BASE_URL . "?" . http_build_query($uri));
    exit;

  }

  public function __get($property) {

    if (property_exists($this, $property)) {
      return $this->$property;
    }

    if (isset($this->dependencies[$property])) {
      return $this->dependencies[$property];
    }

    return null;

  }

}
