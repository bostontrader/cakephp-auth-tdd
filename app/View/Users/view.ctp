<?php
	echo "<p id='id'>"       .$user['User']['id']       ."</p>";
	echo "<p id='username'>" .$user['User']['username'] ."</p>";
	// Hack to force printing 0 instead of a space
	echo "<p id='is_active'>".($user['User']['is_active']?"1":"0")."</p>";
	echo "<p id='is_admin'>" .($user['User']['is_admin']?"1":"0") ."</p>";
?>