<?php

namespace Controller;
use Model\User;

class Dashboard extends \Core\Controller {

  public function index() {

    $per_page = $this->input->get('limit', 2);
    $offset   = $this->input->get('offset', 0);
    $query    = $this->input->get('q', null);

    $user = new User;
    $count = $user->where('email', 'like', "%$query%")->count();
    $users = $user->where('email', 'like', "%$query%")->limit($per_page)->offset($offset)->findAll();

    $this->view('dashboard/index', compact('users', 'count', 'per_page', 'query'));

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

