<?php

namespace Controller;

class Register extends \Core\Controller {

  public function __construct() {
    
    parent::__construct();
    
    $this->rules = ['post' => ['sample']];

    $this->middleware('index', function() {
        return true;
      }
    );

    

  }

  public function index() {
    $this->view('register/index');
  }

}

