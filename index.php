<?php

include 'includes/header.php';

// Greet the visitor
// 24-hour format of an hour without leading zeros
$Hour = date('G');

if ( $Hour >= 5 && $Hour <= 11 ) {
	$greeting = "Good Morning";
    //echo "<h1>Good Morning</h1>";
} else if ( $Hour >= 12 && $Hour <= 18 ) {
	$greeting = "Good Afternoon";
    //echo "<h1>Good Afternoon</h1>";
} else if ( $Hour >= 19 || $Hour <= 4 ) {
	$greeting = "Good Evening";
    //echo "<h1>Good Evening</h1>";
}

?>
	<div class="post">
		<h2><?php echo $greeting; ?> <?=$_SESSION['firstName']?></h2>
		<p>This is the Twisted Development Team Site</p>
		<p>Where we break it, fix it, improve it and develop it!</p>
		<?php include 'blocks/adm-msg.php'; ?>
	</div>
		
	<!-- News Block -->
	<div class="post">
		<?php include 'blocks/news-block.php'; ?>
	</div>
	
<?php

// The Footer
include 'includes/footer.php';


?>
