<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {

	public function add() {
		if ($this->request->is('POST')) {
			$result = $this->User->save($this->request->data);
		}
		else if ($this->request->is(array('GET'))){
			// Default behavior will deal with this
		}
		else {
			$this->autoRender = false;
			return false;
		}
	}

	public function delete($id = null) {
		if ($this->request->is('DELETE')) {
			return $this->User->delete($id);
		}
		else {
			$this->autoRender = false;
			return false;
		}
	}

	public function edit($id = null) {
		if ($this->request->is('PUT')) {
			$this->User->id = $id;
			$result = $this->User->save($this->request->data);
		}
		else if ($this->request->is(array('GET'))){
			$this->request->data = $this->User->findById($id);
		}
		else {
			$this->autoRender = false;
			return false;
		}
	}

	public function index() {
		if ($this->request->is('GET')) {
			$this->set('users', $this->User->getAllUsers());
		}
		else {
			$this->autoRender = false;
			return false;
		}
	}

	public function view($id = null) {
		if ($this->request->is('GET')) {
			$this->set('user', $this->User->findById($id));
		}
		else {
			$this->autoRender = false;
			return false;
		}
	}
}
?>