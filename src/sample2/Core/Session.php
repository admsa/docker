<?php

namespace Core;
class Session {

  protected $data = [];

  public function __construct() {
    $this->data = $_SESSION['site'] ?? [];
  }

  public function set($key, $val = null) {

    $_SESSION['site'][$key] = $val;
    $this->data = $_SESSION['site'];

  }

  public function get($key = null) {
    return $this->data[$key] ?? null;
  }

  public function setFlash($key, $value) {
    $this->set($key, [
        'expires' => time() + 5, // Expires after 5 seconds
        'message' => $value
      ]
    );
  }

  public function getFlash($key) {

    $flash = $this->get($key);

    return (time() < $flash['expires']) ? $flash['message'] : null;

  }

  public function getErrors() {
    return $this->data['validation_errors'];
  }

}
