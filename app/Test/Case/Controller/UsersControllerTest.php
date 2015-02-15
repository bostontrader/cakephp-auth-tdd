<?php

require_once 'simple_html_dom.php';

class UsersControllerTest extends ControllerTestCase {

	public $fixtures = array('app.user');

	public function testIndex() {
		$result = $this->testAction('/users/index', array('return' => 'view'));
		$html = str_get_html($result);
		$rows = $html->find('table[id=users] tbody tr');
		$row_cnt = count($rows);
		$this->assertEqual($row_cnt, 4);
	}
}
?>