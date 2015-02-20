<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {

	public function add() {
		if ($this->request->is(array('POST'))) {
			$result = $this->User->save($this->request->data);
		}
		else if ($this->request->is(array('GET'))){
		}
	}

	public function delete($id = null) {
		$this->autoRender = false;
		if ($this->request->is('DELETE')) {
			return $this->User->delete($id);
		}
	}

	public function edit($id = null) {
		if ($this->request->is(array('PUT'))) {
			$this->User->id = $id;
			$result = $this->User->save($this->request->data);
		}
		else if ($this->request->is(array('GET'))){
			$this->request->data = $this->User->findById($id);
		}
	}

	public function index() {
		if ($this->request->is(array('GET'))) {
			$this->set('users', $this->User->getAllUsers());
		}
	}

	public function view($id = null) {
		if ($this->request->is(array('GET'))) {
			$this->set('user', $this->User->findById($id));
		}
	}
}
?>