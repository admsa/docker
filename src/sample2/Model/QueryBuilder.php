<?php

namespace Model;
use Model\Collection;

class QueryBuilder {
  
  protected $select = '*';
  protected $where  = [];
  protected $or     = [];

  protected $limit = 50;
  protected $offset = 0;

  public function select($select) {
    $this->select = is_array($select) ? implode(',', $select) : $select;
    return $this;
  }

  protected function parse_where($column, $operator, $value, $query_data = [], $type = 'AND') {

    $query = $query_data['query'] ?? '';
    $bind  = $query_data['bind']  ?? [];

    $query = ltrim($query, '(');
    $query = rtrim($query, ')');

    $where = "$column $operator ?";

    $query .= empty($query) ? $where : " $type " . $where;
    $bind[] = $value;

    $query = "($query)";

    return compact('query', 'bind');

  }

  protected function execute($_limit = true) {

    $query = '';
    
    $q_where = $this->where['query'] ?? '';
    $b_where = $this->where['bind'] ?? [];

    $q_or    = $this->or['query'] ?? '';
    $b_or    = $this->or['bind'] ?? [];

    if (!empty($q_where) && !empty($q_or)) {
      $query = (count($b_or) === 1) ? "($q_where OR $q_or)" : "($q_where AND $q_or)";
    }
    else if (empty($q_where)) {
      $query = $q_or;
    } 
    else {
      $query = $q_where;
    }


    # Add WHERE clause
    if (!empty($query)) {
      $query = " WHERE {$query}";
    }

    $limit = '';
    if ($_limit) {
      $limit .= " LIMIT {$this->offset}, {$this->limit}";
    }

    $stmt = $this->conn->prepare("SELECT {$this->select} FROM {$this->table_name} {$query} {$limit}");
    $stmt->execute(array_merge($b_where, $b_or));

    return $stmt;

  }

  public function where($column, $operator, $value) {
    $this->where = $this->parse_where($column, $operator, $value, $this->where, 'AND');
    return $this;
  }

  public function or($column, $operator, $value) {
    $this->or = $this->parse_where($column, $operator, $value, $this->or, 'OR');
    return $this;
  }

  public function count() {
    return $this->select('count(1)')->execute(false)->fetchColumn();
  }

  public function find($pk) {

    $result = $this->select('*')->where($this->primary_key, '=', $pk)->execute()->fetch(\PDO::FETCH_ASSOC);

    if ($result) {
      $this->attributes = $result;
    }

    return $result;

  }

  public function findAll() {

    $results = $this->select('*')->execute()->fetchAll(\PDO::FETCH_CLASS);
    return new Collection(get_class($this), $results);

  }


  public function limit($limit) {
    $this->limit = intval($limit);
    return $this;
  }

  public function offset($offset) {
    $this->offset = intval($offset);
    return $this;
  }

}
