<?php
session_start();

$dbhost = "localhost"; 			// this will ususally be 'localhost', but can sometimes differ
$dbname = ""; 		// the name of the database that you are going to use for this project
$dbuser = ""; 	// the username that you created, or were given, to access your database
$dbpass = ""; 			// the password that you created, or were given, to access your database

// Connect to your server and database
mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());
mysql_select_db($dbname) or die("MySQL Error: " . mysql_error());

// Definitions
define('INCLUDE_PATH', '../includes');

// Site variables
$site = mysql_query("SELECT * FROM settings") or die('Error: '. mysql_error() );
$row = mysql_fetch_array($site);
$site_description = $row['site_description'];
$site_keywords = $row['site_keywords'];
$sitename = $row['sitename'];
$siteurl = $row['site_url'];
$slogan = $row['site_slogan'];
$site_email = $row['site_email'];
$copyright = $row['site_copyright'];
// facebook
$facebook = $row['site_facebook'];
$fb_active = $row['allow_facebook'];
// Twitter
$twitter = $row['site_twitter'];
$tw_active = $row['allow_twitter'];
// Tumblr
$tumblr = $row['site_tumblr'];
$tu_active = $row['allow_tumblr'];
// Google+
$gplus = $row['site_gplus'];
$gplus_active = $row['allow_gplus'];
// LinkedIn
$linkedin = $row['site_linkedin'];
$linkedin_active = $row['allow_linkedin'];
// Site Registration
$allow_reg = $row['allow_reg'];
// RSS Syndication Feed
$rssfeed = 'rss.php';
$allow_rss = $row['allow_rss'];
// Honeypot
$honeypot = $row['site_honeypot'];



// Session Variables

// Logged in variable
$loggedIn = $_SESSION['LoggedIn'];
$isadm = $_SESSION['isAdmin'];
$team = $_SESSION['isTeam'];
$firstname = $_SESSION['firstName'];
$lastname = $_SESSION['lastName'];

// Needed data and variable for online status
$sql = mysql_query("SELECT online FROM users") or die('Error: '. mysql_error() );
$row = mysql_fetch_array($sql);
$online = $row['online'];



?>
