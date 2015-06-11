<?php

include 'includes/header.php';

// open the left div
echo '<div id="left">';

// Pull data to get the enabled or disabled variable
$reg = mysql_query("SELECT allow_reg FROM settings") or die('Error: '. mysql_error() );
$row = mysql_fetch_array($reg);
// Assign the enabled variable to allowed_reg
$enabled = $row['allow_reg'];
	
	// open the post div
	echo '<div class="post">';
		echo '<h2>Get Signed up!</h2>';
		
		// If site registration is disabled
		if ($enabled == 0) {
			echo '<p>Sorry! Registration for this site is currently disabled.</p>';
		}
		
		// If site registration is enabled
		elseif ($enabled == 1) {
			signUp();
		}
		// End the if statements
		
	// Close the post div	
	echo '</div>';
	
//End the Left DIV
echo '</div>';	


// The Footer
include 'includes/footer.php';

?>
