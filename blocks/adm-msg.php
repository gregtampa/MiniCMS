<?php

/* adm.msg.php
 * Displays admin messages
 *
 * Copywrite 2015 Twisted Development
 * https://www.twedev.com
 * regina@twedev.com
*/

// query the database
$query = mysql_query("SELECT message FROM admin_msg") or die('Error: '. mysql_error() );

// assign the variables
while($row = mysql_fetch_array($query)){
	$msg = $row['message'];
	$blocktitle = 'Administrative Message';
		
		// Display the data
		echo '<h2>'.$blocktitle.'</h2>';
		echo '<p><strong>'.$msg.'</strong></p>';
		echo '<hr>';
}

?>