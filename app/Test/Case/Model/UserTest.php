<?php
App::uses('User', 'Model');

class UserTest extends CakeTestCase {
	public $fixtures = array('app.user');

	public function setUp() {
		parent::setUp();
		$this->User = ClassRegistry::init('User');
	}

	public function testGetAllUsers() {
		$result = $this->User->getAllUsers();
	}
}
?>