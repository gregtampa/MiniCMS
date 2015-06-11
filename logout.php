<?php

include 'includes/header.php';

doLogOut();

$_SESSION = array(); session_destroy();
// Set user status online
?>


	<div class="post">
		<p>You have been logged out and set offline.</p>
		<p>Please return soon.</p>
		<?php echo "<meta http-equiv='refresh' content='=10;index.php' />"; ?>
	</div>


<?php

// The Footer
include 'includes/footer.php';