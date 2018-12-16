<?php

namespace Controller;

class Login extends \Core\Controller {

  public function index() {
    $this->view('login/index');
  }

  public function sample() {
    $this->redirect('page=login&action=index');
  }

}

