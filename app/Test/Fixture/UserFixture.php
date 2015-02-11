<?php
class UserFixture extends CakeTestFixture {

	public $import = 'User';

	public $records = array(
		array('id'=>1, 'username'=>'flunky1', 'password'=>'catfood', 'is_active'=>0, 'is_admin'=>0),
		array('id'=>2, 'username'=>'admin1',  'password'=>'catfood', 'is_active'=>0, 'is_admin'=>1),
		array('id'=>3, 'username'=>'flunky2', 'password'=>'catfood', 'is_active'=>1, 'is_admin'=>0),
		array('id'=>4, 'username'=>'admin2',  'password'=>'catfood', 'is_active'=>1, 'is_admin'=>1)
	);

}
?>