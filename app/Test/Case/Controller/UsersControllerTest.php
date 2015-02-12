<?php
class UsersControllerTest extends ControllerTestCase {

	public $fixtures = array('app.user');

	public function testIndex() {
		$result = $this->testAction('/users');
	}

}
?>