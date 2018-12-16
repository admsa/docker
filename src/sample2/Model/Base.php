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

    $partials = $this->_build_string(array_fill_keys($this->_keys, '?'));
    $values   = $this->_values;
    $values[] = $this->_primary_key;

    $stmt = $this->conn->prepare("UPDATE {$this->table_name} SET $partials WHERE {$this->primary_key} = ?");
    $stmt->execute($values);

    return $stmt->rowCount();

  }

  protected function beforeSave($attributes = []) {
    return $attributes;
  }

  public function save() {

    $this->attributes  = $this->beforeSave($this->attributes);

    $keys    = $this->_keys;
    $columns = implode(',', $keys);
    $bind    = implode(',', array_fill(0, count($keys), '?'));

    $this->conn
      ->prepare("INSERT INTO {$this->table_name} ($columns) VALUES ($bind)")
      ->execute($this->_values);

    return $this->conn->lastInsertId();

  }

  public function delete() {

    $stmt = $this->conn->prepare("DELETE FROM {$this->table_name} WHERE {$this->primary_key} = ?");
    $stmt->execute([$this->_primary_key]);

    return $stmt->rowCount();

  }

  public function setAttributes($attributes = []) {
    $this->attributes = $attributes;
    return $this;
  }

  public function getAttributes() {
    return $this->attributes;
  }

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
      case '_keys':
        return array_keys($this->_filtered_attr());
      case '_values':
        return array_values($this->_filtered_attr());
      case '_primary_key':
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
      $result[] = $key . " = " . $val;
    }

    return implode(',', $result);

  }

}
