<?php

namespace Controller;
class Dashboard extends \Core\Controller {

  public function index() {
    $this->view('dashboard/index');
  }

}

