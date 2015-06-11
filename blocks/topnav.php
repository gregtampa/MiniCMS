<?php
// topnav.php
// Top Navigation Block


echo '<ul>';
echo '<li><a href="/">Home</a></li>';

// Populate the Top Nav from the Database
$query = mysql_query("SELECT file_title, file FROM site_nav ORDER BY file_title") or die('Error: '. mysql_error() );
while($row = mysql_fetch_array($query)){
$name = $row['file_title'];
$navlink = $row['file'];

echo '<li><a href="'.$navlink.'.php">'.$name.'</a></li>';
}

// Here we will check for Logged in and display Logout
// otherwise we will display Login
if ($loggedIn == 1) {
	echo '<li><a href="logout.php">Logout</a></li>';
}
elseif ($loggedIn == 0) {

	echo '<li><a href="login.php">Login</a></li>';
}

echo '</ul>';

?>
