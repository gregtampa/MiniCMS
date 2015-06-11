<?php

// DevTeam Block

?>

<h2>Who's Online</h2>
<table border="0" cellpadding="3" cellspacing=3" width="100%">
  <tr>
    <td>
    <p>
    <ul>
	<?php
	$getonline = mysql_query("SELECT username, online FROM users WHERE online = '1'");
	while($row = mysql_fetch_array($getonline)){	
		$who = $row['username'];
		echo '<li>'.$who.'</li>';
	}
	?>
	</ul>
	</p>
	</td>
  </tr>
</table>