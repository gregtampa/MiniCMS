<?php

/* account-block.php
 * Displays links to the users account
 * and functions
 *
 * Copywrite 2015 Twisted Development
 * https://www.twedev.com
 * scott@twedev.com
*/

// Some Variables
$blocktitle = 'Your Account';

$loggedIn = $_SESSION['LoggedIn'];

if ($loggedIn == 1) {
	// Diplay the Block Title
	echo '<h2>'.$blocktitle.'</h2>';
	echo '<p>';
	echo '<ul>';
	echo '<li><img src="images/myaccount_16.png" class="textmiddle" alt="">&nbsp;&nbsp;<a href="myAccount.php">My Account</a></li>';
	echo '<li><img src="images/news_16.png" class="textmiddle" alt="">&nbsp;&nbsp;<a href="">New News</a> Disabled</li>';
	echo '<li><img src="images/blogger_16.png" class="textmiddle" alt="">&nbsp;&nbsp;<a href="blogs.php?op=write">Write a Blog</a></li>';
	echo '</ul>';
	echo '<p>';
}

else {
	loginBlock();
}

?>
