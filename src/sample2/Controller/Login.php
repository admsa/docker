<?php

namespace Controller;

class Login extends \Core\Controller {

  public function index() {
    $user = new \Model\User;
    $count = $user
      ->where('lastname', '=', 'bogart')
      //->where('firstname', '=', 'doe')
      ->count();
    var_dump($count);
    $this->view('login/index');
  }

  public function sample() {
    $this->redirect('page=login&action=index');
  }

}

