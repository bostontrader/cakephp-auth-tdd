<?php

require_once 'simple_html_dom.php';

class UsersControllerTest extends ControllerTestCase {

	public $fixtures = array('app.user');

	public function testIndex() {
		$result = $this->testAction('/users/index', array('return' => 'view'));
		$html = str_get_html($result);

		// 1. Ensure that the single row of the thead section
		//    has a column for id and username, in that order
		$rows = $html->find('table[id=users]',0)->find('thead',0)->find('tr');
		$row_cnt = count($rows);
		$this->assertEqual($row_cnt, 1);

		// 2. Ensure that the thead section has a heading
		//    for id and username.
		$columns = $rows[0]->find('td');
		$this->assertEqual($columns[0]->plaintext, 'id');
		$this->assertEqual($columns[1]->plaintext, 'username');

		// 3. Ensure that the tbody section has the same
		//    quantity of rows as the count of user records in the fixture.
		//    For each of these rows, ensure that the id and username match 
		$userFixture = new UserFixture();
		$rowsInHTMLTable = $html->find('table[id=users]',0)->find('tbody',0)->find('tr');
		$this->assertEqual(count($userFixture->records), count($rowsInHTMLTable));

		$iterator = new MultipleIterator;
		$iterator->attachIterator(new ArrayIterator($userFixture->records));
		$iterator->attachIterator(new ArrayIterator($rowsInHTMLTable));
		
		foreach ($iterator as $values) {

			$fixtureRecord = $values[0];
			$htmlRow = $values[1];
			$htmlColumns = $htmlRow->find('td');

			$this->assertEqual($fixtureRecord['id'],       $htmlColumns[0]->plaintext);
			$this->assertEqual($fixtureRecord['username'], $htmlColumns[1]->plaintext);
		}

	}
}
?>