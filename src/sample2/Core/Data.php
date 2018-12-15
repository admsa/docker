<?php

namespace Core;
abstract class Data {

  protected $data = [];

  public function set($key, $val = null) {

    if (is_array($key)) {
      $this->data = $key;
    } else {
      $this->data[$key] = $val;
    }

  }

  public function get($key = null) {
    return ($key === null) ? $this->data : ($this->data[$key] ?? null);
  }

}

