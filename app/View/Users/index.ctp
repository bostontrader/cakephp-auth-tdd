<table id='users'>
	<thead><tr><td>id</td><td>username</td><td>is_active</td><td>is_admin</td></tr></thead>
<tbody>
		<?php
			foreach ($users as $user):
				echo "<tr><td>".$user['User']['id'].
					"</td><td>".$user['User']['username'].
					// Hack to force printing 0 instead of a space
					"</td><td>".($user['User']['is_active']?"1":"0").
					"</td><td>".($user['User']['is_admin']?"1":"0")."</td></tr>";
			endforeach;
		?>
	</tbody>
</table>