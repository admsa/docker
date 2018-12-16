<?php

namespace Controller;

class Logout extends \Core\Controller {

  public function __construct() {

    parent::__construct();
    
  }

  public function index() {
    session_destroy();
    $this->redirect('page=login');
  }

}

