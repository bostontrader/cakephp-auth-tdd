<?php
App::uses('User', 'Model');

class UserTest extends CakeTestCase {

	public function setUp() {
		parent::setUp();
		$this->User = ClassRegistry::init('User');
	}

	// This method does nothing, but it looks like a test and thus
	// this class is now a valid CakeTestCase.
	public function test() {}
}
?>