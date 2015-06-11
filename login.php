<?php

include 'includes/header.php';

?>
			<div class="post">
				<h2>Login</h2>
				<?php doLogin(); ?>
			</div>
		
<?php

// Check conditions and respond as needed'
if(!empty($_POST['username']) && !empty($_POST['password'])) {
	checkLogin();
}

// The Footer
include 'includes/footer.php';

?>