<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {

	public function index() {
		$this->set('users', $this->User->getAllUsers());
	}

	public function view($id = null) {
		$this->set('user', $this->User->findById($id));
	}
}
?>