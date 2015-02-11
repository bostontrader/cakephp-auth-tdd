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
		$expected = array(
				array('User' => array('id'=>1)),
				array('User' => array('id'=>2)),
				array('User' => array('id'=>3)),
				array('User' => array('id'=>4))
		);

		$this->assertEquals($expected, $result);
	}
}
?>