<?php

namespace Core;
abstract class Controller extends Layout {

  protected $dependencies = [];

  public function setDependencies($dependencies = []) {

    foreach ($dependencies as $key => $className) {
      $reflection = new \ReflectionClass($className);
      $this->dependencies[$key] = $reflection->newInstance();
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
