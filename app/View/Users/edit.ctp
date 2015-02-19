<?php
	echo $this->Form->create('User', array('type'=>'put'));
	echo $this->Form->input('username');
	echo $this->Form->input('is_active');
	echo $this->Form->input('is_admin');
	echo $this->Form->end('Save User');
?>