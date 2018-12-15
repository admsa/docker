<?php

namespace Core;
class Session extends Data {

  public function __construct() {
    $this->data = $_SESSION['site_data'] ?? [];
  }

  public function set($key, $val = null) {

    $_SESSION['site_data'][$key] = $val;
    $this->data = $_SESSION[site_data];

  }

}
