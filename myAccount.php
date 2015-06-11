<?php
/*
 * MyAccount.php
 * Displays the persons account info
 * What blogs, News, Files are associated
 * with them as well as groups.
*/

include 'includes/header.php';

if ($loggedIn == 1) {
	
// Function operatives
if (isset($_GET['op'])) {
	$d = $_GET['op'];
	} elseif (isset($_POST['op'])) { // Forms
	$d = $_POST['op'];
} else {
	$d = NULL;
}

// Site content and Functions
ob_start();

function all() {
	
// Setup the User variable
$user = $_SESSION['username'];
// Account info table
echo '<h2>My Account</h2>';
// Gather the Data for this user
$q1 = mysql_query("SELECT * FROM users WHERE username='$user'") or die('Error: '. mysql_error() );
while($r1 = mysql_fetch_array($q1)){
	$fname = $r1['firstName'];
	$lname = $r1['lastName'];
	$email = $r1['email'];
	
	// Display the Table
	echo '<p><strong>Account Information</strong></p>';
	echo '<p><em>If you need to change any of the information below. Change it in the box provided, then click "Update"</em></p>';
	echo '<form action="myAccount.php?op=updateAccount" method="post">';
	echo '<table border="0" cellpadding="2" cellspacing="2" width="100%">';
	echo '<tr>';
	echo '<td>Name:</td><td><input type="text" name="firstName" value="'.$fname.'"> <input type="text" name="lastName" value="'.$lname.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>Email:</td><td><input type="text" name="email" size="40" value="'.$email.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>Username:</td><td><input type="text" name="userid" size="40" value="'.$user.'"></td>';
	echo '</tr>';
	echo '</table>';
	echo '<div align="center"><input type="submit" value="Update" name="Submit"></div>';
	echo '</form>';
	echo '<div align="center"><a href="myAccount.php?op=updatePassword"><input type="submit" value="Change Your Password" name="changepassword"></a></div>';
	echo '<hr>';
}

// Blogs Table
echo '<p><strong>My Blogs</strong></p>';
echo '<em>Click the blog title to view it\'s contents.</em>';
echo '<table border="0" cellpadding="2" cellspacing="2" width="100%">';
echo '<tr>';
echo '<td>';
echo '<ol>';
// Gather the Data for this user
$q2 = mysql_query("SELECT bid, title, postdate FROM blogs WHERE userid='$user' ORDER BY postdate ASC") or die('Error: '. mysql_error() );
while($r2 = mysql_fetch_array($q2)){
	$blogid = $r2['bid'];
	$title = $r2['title'];
	
	echo '<li><a href="blogs.php?op=view&id='.$blogid.'">'.$title.'</a></li>';
}
echo '</ol>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<hr>';

// News Table
echo '<p><strong>My News</strong></p>';
echo '<em>Click the News Title to view it\'s contents.</em>';
echo '<table border="0" cellpadding="2" cellspacing="2" width="100%">';
echo '<tr>';
echo '<td><strong>Title</strong></td><td><strong>Options</strong></td>';
echo '</tr>';
// Gather the Data for this user
$q5 = mysql_query("SELECT id, title FROM news WHERE user='$user'") or die('Error: '. mysql_error() );
while($r5 = mysql_fetch_array($q5)){
	$nid = $r5['id'];
	$ntitle = $r5['title'];
	
	// Get the comments count for this item
	$comments = mysql_query("SELECT * FROM news_comments WHERE newsid='$nid'") or die('Error: '. mysql_error() );
	// Display the results
	$ccount = mysql_num_rows($comments);
	
echo '<tr>';
echo '<td><a href="news.php?op=view&id='.$nid.'">'.$ntitle.'</a> ('.$ccount.')</td><td>Edit | <a href="news.php?op=del&id='.$nid.'">Delete</a></td>';
echo '</tr>';
}
echo '</table>';
echo '<hr>';
}

function updateAccount() {
	if (isset($_POST['Submit'])){
		$firstname = safe($_POST['firstName']);
		$lastname = safe($_POST['lastName']);
		$userEmail = safe($_POST['email']);
		$username = safe($_POST['userid']);
		$user = $_SESSION['username'];
		
		// Put the request into the database
		$sql = "UPDATE users SET username='$username', firstName='$firstname', lastName='$lastname', email='$userEmail' WHERE username='$user'";
		$retval = mysql_query( $sql );
		if(! $retval )
		{
  			die('Sorry, your information could not be updated: ' . mysql_error());
		}
		else {
			echo '<p>Great, your information was updated. Please return to <a href="myAccount.php"><strong>Log Out</strong></a></p>';
			echo '<p>If you have changed your User Name, please <a href="logout.php"><strong>Log Out</strong></a> and log back in with your new User Name.</p>';
		}
	}
}
	

function updatePassword() {
	echo '<form action="myAccount.php?op=savePassword" method="post">';
	echo 'New Password: <input type="password" name="password" placeholder="Your New Password">';
	echo '<input type="submit" name="ChangePW" value="Change It!">';
	echo '</form>';
}


function savePassword() {
	if (isset($_POST['ChangePW'])){
		$user = $_SESSION['username'];
		$pass = safe($_POST['password']);
		
		$passwd = md5($pass);
		$updatepw = "UPDATE users SET password='$passwd'";
		$success = mysql_query($updatepw);
		if(! $success)
		{
			die('Sorry, your password could not be updated: ' . mysql_error());
		}
		else {
			echo '<p>Nice, that password was reset, please <a href="logout.php"><strong>Log Out</strong> and back in with that new password.</p>';
		}
	}

}

// Switch
switch($d) {
	case 'updateAccount':
			updateAccount();
			break;
	case 'updatePassword':
			updatePassword();
			break;
	case 'savePassword':
			savePassword();
			break;
			
	default:
		   all();
		   break;
}

}
elseif ($loggedIn == 0) {
	echo '<div id="left">';
	echo '<div class="post">';
		echo '<h2>Sorry!</h2>';
		echo '<p>You must be logged to see this content.</p>';
	echo '</div>';
echo '</div>';
}

include 'includes/footer.php';

?>
