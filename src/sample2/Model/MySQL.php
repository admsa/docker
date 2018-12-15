<?php

namespace Model;

class MySQL {

  protected static $PDO = null;
  protected static $instance;

  private function __construct() {

    $host = DATABASE['mysql']['host'];
    $db   = DATABASE['mysql']['db'];
    $user = DATABASE['mysql']['user'];
    $pass = DATABASE['mysql']['pass'];

    $dsn = "mysql:host=$host;dbname=$db";

    try {
      static::$PDO = new \PDO($dsn, $user, $pass);
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

  }

  private function __clone() {}

  public static function getInstance() {
    if ( !isset(static::$instance)) {
      static::$instance = new static;
    }
    return static::$instance;
  }

  public static function getConnection() {
    return static::$PDO;
  }

}
