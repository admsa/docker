<?php

namespace Model;

class User extends Base {

  protected $table_name = 'users';

  public function __construct($attributes = []) {
    parent::__construct($attributes);
  }

}
