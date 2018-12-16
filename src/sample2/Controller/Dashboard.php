<?php

namespace Controller;
use Model\User;

class Dashboard extends \Core\Controller {

  public function index() {

    $per_page = $this->input->get('limit', 2);
    $offset   = $this->input->get('offset', 0);

    $user = new User;
    $count = $user->count();
    $users = $user->limit($per_page)->offset($offset)->findAll();

    $this->view('dashboard/index', compact('users', 'count', 'per_page'));

  }

  public function delete() {

    $id = $this->input->get('id');
    if (!$id) $this->redirect('page=dashboard');

    $user = (new User)->find($id);
    if ($user->delete()) {
      $this->redirect('page=dashboard');
    }

  }

}

