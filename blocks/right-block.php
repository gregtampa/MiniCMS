
<?php
echo '<div id="right">';
$blocks = mysql_query("SELECT blockname, isActive FROM blocks WHERE isActive=1") or die('Error: '. mysql_error() );
while($row = mysql_fetch_array($blocks)){
	$block = $row['blockname'];
	
	include 'blocks/'.$block.'.php';
}

echo '</div>';