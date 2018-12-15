<?php

namespace Controller;
class Home extends \Core\Controller {

  public function index() {
    $this->view('home/index');
  }

}

