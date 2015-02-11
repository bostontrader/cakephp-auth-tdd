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
				array('User' => array('id'=>1, 'username'=>'flunky1', 'password'=>'catfood', 'is_active'=>0, 'is_admin'=>0)),
				array('User' => array('id'=>2, 'username'=>'admin1',  'password'=>'catfood', 'is_active'=>0, 'is_admin'=>1)),
				array('User' => array('id'=>3, 'username'=>'flunky2', 'password'=>'catfood', 'is_active'=>1, 'is_admin'=>0)),
				array('User' => array('id'=>4, 'username'=>'admin2',  'password'=>'catfood', 'is_active'=>1, 'is_admin'=>1))
		);

		$this->assertEquals($expected, $result);
	}
}
?>