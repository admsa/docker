<?php

namespace Core;
class Layout {

  protected $header = HEADER ?? null;
  protected $footer = FOOTER ?? null;

  protected function setHeader($header) {
    $this->header = $header;
  }

  protected function setFooter($footer) {
    $this->footer = $footer;
  }

  public function view($template, $data = []) {

    extract($data);

    require_once BASE_PATH . '/'       . $this->header . '.php';
    require_once BASE_PATH . '/views/' . $template     . '.php';
    require_once BASE_PATH . '/'       . $this->footer . '.php';

  }

}
