<?php

namespace Controller;

class Login extends \Core\Controller {

  public function index() {
    $user = new \Model\User;
    $this->view('login/index');
  }

  public function sample() {
    $this->redirect('page=login&action=index');
  }

}

