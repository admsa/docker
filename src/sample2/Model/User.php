<?php

namespace Model;

class User extends Base {

  protected $table_name = 'users';

  protected function beforeSave($attributes = []) {
    $attributes['password'] = password_hash($attributes['password'], PASSWORD_BCRYPT);
    return $attributes;
  }

}
