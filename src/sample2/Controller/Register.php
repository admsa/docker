<?php

namespace Controller;

class Register extends \Core\Controller {

  public function __construct() {

    parent::__construct();
    
    $this->rules = ['post' => ['register']];

    $this->middleware('index', function() {
        return true;
      }
    );

  }

  public function index() {
    $this->view('register/index');
  }

  public function register() {
    $attributes = $this->input->only([
        'email', 'password', 'firstname', 'lastname', 'password_confirm'
      ]
    );

    $rules = [
      'email'             => 'email',
      'password'          => 'required',
      'password_confirm'  => 'match:password',
      'firstname'         => 'required',
      'lastname'          => 'required',
    ];

    $errors = $this->validate($attributes, $rules);

    if (!empty($errors)) {

      $this->back();
      
    } else {

      unset($attributes['password_confirm']);

      $user = new \Model\User;
      $user->setAttributes($attributes);
      $user->save();

      $this->redirect('page=login');

    }

  }

  protected function validate($attributes = [], $rules = []) {
    $errors = [];

    foreach($attributes as $key => $val) {

      if ( !isset($rules[$key])) continue;

      $validators = explode('|', $rules[$key]);

      foreach ($validators as $validator) {

        $name = explode(':', $validator);

        switch ($name[0]) {
          case 'required':
              if ($val === '') 
                $errors[$key] = "The $key field is required.";
            break;
          case 'email':
              if (!filter_var($val, FILTER_VALIDATE_EMAIL))
                $errors[$key] = "The $key field must be a valid email.";
            break;
          case 'match':
              if ($val !== $attributes[$name[1]]) 
                $errors[$key] = "The $key field doesn't match $name[1] field.";
            break;
        }

      }

    }

    $this->session->set('validation_errors', $errors);
    return $errors;

  }

}

