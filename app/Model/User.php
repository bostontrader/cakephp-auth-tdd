<?php
class User extends AppModel {
	public function getAllUsers() {
		return $this->find(
				'all', array('fields' => array('id','username','password','is_active','is_admin'))
		);
	}
}
?>