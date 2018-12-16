<?php

namespace Model;

use Iterator, Countable;

class Collection implements Iterator, Countable {

  private $position = 0;
  private $className;
  private $data = [];


  public function __construct($className, $data = []) {
    $this->position = 0;
    $this->data     = $data;
    $this->className= $className;
  }

  public function rewind() {
    $this->position = 0;
  }

  public function current() {
    
    $current = $this->data[$this->position];
    
    $instance = new $this->className();
    $instance->setAttributes(get_object_vars($current));
    
    return $instance;

  }

  public function key() {
    return $this->position;
  }

  public function next() {
    ++$this->position;
  }

  public function valid() {
    return isset($this->data[$this->position]);
  }

  public function count() {
    return count($this->data);
  }

  public function toArray() {
    return $this->data;
  }

}

