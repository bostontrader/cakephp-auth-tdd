<table id='users'>
	<thead><tr><td>id</td><td>username</td></tr></thead>
<tbody>
		<?php
			foreach ($users as $user):
				echo "<tr><td>".$user['User']['id']."</td><td>".$user['User']['username']."</td></tr>";
			endforeach;
		?>
	</tbody>
</table>