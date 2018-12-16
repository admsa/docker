<?php

namespace Model;
use Model\MySQL;
use Model\QueryBuilder;

class Base extends QueryBuilder {

  protected $conn;
  protected $attributes;
  protected $table_name;
  protected $fillable = [];
  protected $primary_key = 'id';

  public function __construct() {

    $db = MySQL::getInstance();
    $this->conn = $db::getConnection();

  }

  public function update() {

    $keys = implode(',', $this->__k);
    $bind = ':' . implode(',:', $this->__k);

    $set = array_combine(explode(',', $keys), explode(',', $bind));
    $partial = $this->_build_string($set);

    $exec = array_combine(explode(',', $bind), $this->__v);
    $exec[':pk'] = $this->__pk;

    $stmt = $this->conn->prepare("UPDATE {$this->table_name} SET " . $partial . " WHERE {$this->primary_key} = :pk");
    $stmt->execute($exec);

    return $stmt->rowCount();

  }

  public function save() {

    $keys = implode(',', $this->__k);
    $bind = ':' . implode(',:', $this->__k);

    $this->conn
      ->prepare("INSERT INTO {$this->table_name} ({$keys}) VALUES ({$bind})")
      ->execute(array_combine(explode(',', $bind), $this->__v));

    return $this->conn->lastInsertId();

  }

  public function delete() {

    $stmt = $this->conn->prepare("DELETE FROM {$this->table_name} WHERE {$this->primary_key} = ?");
    $stmt->execute([$this->__pk]);

    return $stmt->rowCount();

  }

  public function setAttributes($attributes = []) {
    $this->attributes = $attributes;
    return $this;
  }

  // protected function limit($limit) {
  //   $this->limit = intval($limit);
  //   return $this;
  // }

  // protected function offset($offset) {
  //   $this->offset = intval($offset);
  //   return $this;
  // }

  public function __set($key, $val = null) {

    if (property_exists($this, $key)) {
      $this->$key = $val;
    } else {
      $this->attributes[$key] = $val;
    }

  }

  public function __get($property) {

    if (property_exists($this, $property)) {
      return $this->$property;
    }

    else if (isset($this->attributes[$property])) {
      return $this->attributes[$property];
    }

    switch ($property) {
      case '__k':
        return array_keys($this->_filtered_attr());
      case '__v':
        return array_values($this->_filtered_attr());
      case '__pk':
        return $this->attributes[$this->primary_key];
    }

    return null;

  }

  private function _filtered_attr() {

    if (empty($this->fillable)) return $this->attributes;

    return array_filter($this->attributes, function($key) {
        return in_array($key, $this->fillable);
    }, ARRAY_FILTER_USE_KEY);

  }

  private function _build_string($args = []) {

    $result = [];

    foreach ($args as $key => $val) {
      $result[] = $key . "=" . $val;
    }

    return implode(',', $result);

  }

}
