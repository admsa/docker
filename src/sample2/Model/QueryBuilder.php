<?php

namespace Model;

trait QueryBuilder {

  protected $select = [];
  protected $where  = [];
  protected $or     = [];

  public function where($column, $operator, $value) {
    $this->where[] = [
      'column'   => $column,
      'operator' => $operator,
      'value'    => $value
    ];
    return $this;
  }

  public function or($column, $operator, $value) {
    $this->or[] = [
      'column'   => $column,
      'operator' => $operator,
      'value'    => $value
    ];
    return $this;
  }

  protected function bindValue($clause = [], $type = 'AND') {
    if (empty($clause)) {
      return [
        'string' => '',
        'values' => [],
      ];
    }

    $string = []; $values = [];
    foreach($clause as $data) {

      extract($data);
      $values[":" . $column] =  $value;
      $string[] = $column . " " . $operator . " :" . $column;

    }

    $string = implode(" {$type} ", $string);
    return compact('string', 'values');

  }

  public function count() {

    $whereBind = $this->bindValue($this->where, 'AND');
    $orBind    = $this->bindValue($this->or, 'OR');

    $where = $whereBind['string'];
    $values = $whereBind['values'];

    $stmt = $this->conn->prepare("SELECT count(1) FROM " . $this->table_name . " WHERE " . $where);
    $stmt->execute($values);

    return $stmt->fetchColumn();

  }

}
