<?php

namespace Controller;

class Login extends \Core\Controller {

  public function __construct() {

    parent::__construct();
    
    $this->rules = ['post' => ['login']];

    $this->middleware('index', function() {

        $user = $this->session->get('user');
        if ($user) {
          $this->redirect('page=dashboard');
        }

        return true;
        
      }
    );

  }

  public function index() {
    $this->view('login/index');
  }

  public function login() {

    $email    = $this->input->get('email');
    $password = $this->input->get('password');

    $user_model = new \Model\User;
    $user = $user_model->where('email', '=', $email)->get();

    if ($user && password_verify($password, $user->password)) {
      $this->session->set('user', (object) $user->getAttributes());
      $this->redirect('page=dashboard');
    }

    $this->session->setFlash('message', 'Invalid credentials.');
    $this->back();

  }

}

