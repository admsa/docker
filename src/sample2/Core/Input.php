<?php

namespace Core;

use Core\Session;

class Input {

  protected $data = [];

  protected $session;

  public function __construct() {
    $this->session = new Session;
  }

  public function only($attr = []) {
    return array_filter($this->data, function($key) use($attr) {
        return in_array($key, $attr);
      },
      ARRAY_FILTER_USE_KEY
    );
  }

  public function set($key, $val = null) {

    if (is_array($key)) {

      $this->data = $key;

      $old = $this->session->get('input');
      $this->session->set('old', $old);

      $this->session->set('input', $key);

    } else {
      $this->data[$key] = $val;
    }

  }

  public function old($key, $val = null) {

    $old = $this->session->get('old');
    return $old[$key] ?? null;

  }

  public function get($key = null) {
    return ($key === null) ? $this->data : ($this->data[$key] ?? null);
  }


}
