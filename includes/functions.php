<?php

/*
 * Site wide functions
 * To be used throughout the entire site
 * Revolving document and may chaneg without notice
 *
*/

function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}

function mysql_prep($string) {
	global $connection;
		
	$escaped_string = mysqli_real_escape_string($connection, $string);
	return $escaped_string;
}

// Fixing the Apostrophe issue
function safe($value){
   return mysql_real_escape_string($value);
}

// Error
function show_error($myError)
{
	echo '<b>Please correct the following error:</b><br />';
    echo $myError;
    echo '</p>';
    
    exit();
}

// Check input
function check_input($data, $problem='')
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($problem && strlen($data) == 0)
    {
        show_error($problem);
    }
    return $data;
}

// Reverse the annoying escapes
function reverse_escape($str)
{
  $search=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
  $replace=array("\\","\0","\n","\r","\x1a","'",'"');
  return str_replace($search,$replace,$str);
}

function doLogin() {
	// login form
	echo '<form method="post" action="login.php" name="loginform" id="loginform">';
		echo 'Username: <input type="text" name="username" id="username" /><br>';
		echo 'Password: <input type="password" name="password" id="password" /><br>';
		echo '<input type="submit" name="login" id="login" value="Login" />';
	echo '</form>';
	echo '<p><a href="signup.php">Sign Up</a>&nbsp; | &nbsp;<a href="forgot.php">Forgot Password</a></p>';
	
}

function checkLogin() {
	$username = safe($_POST['username']);
    $password = md5(safe($_POST['password']));
    
	$checklogin = mysql_query("SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."'");
    
    if(mysql_num_rows($checklogin) == 1)
    {
    	 $row = mysql_fetch_array($checklogin);
         $email = $row['email'];
         $firstname = $row['firstName'];
         $lastname = $row['lastName'];
         $isadm = $row['isAdmin'];
         $team = $row['isTeam'];
         $username = $row['username'];
        
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['firstName'] = $firstname;
        $_SESSION['lastName'] = $lastname;
        $_SESSION['email'] = $email;
        $_SESSION['isAdmin'] = $isadm;
        $_SESSION['isTeam'] = $team;
        $_SESSION['LoggedIn'] = 1;
        
    	 echo "<h1>Success</h1>";
        echo "<p>We are now redirecting you to the member area.</p>";
        echo "<meta http-equiv='refresh' content='=2;index.php' />";
        
        $login = mysql_query("UPDATE users SET online=1 WHERE username='$username'");
    }
    
    else
    {
    	 echo '<h1>Error</h1>';
        echo '<p>Sorry, your account could not be found. Please <a href="index.php">click here to try again</a>.</p>';
        echo '<p><a href="fg.php"><strong>Forgot your Password?</strong></a></p>';
    }
}

// Log Out
function doLogOut() {
	$username = $_SESSION['username'];
	mysql_query("UPDATE users SET online = 0 WHERE username = '$username'");
	
}


// Sign up
function signUp() {
	// login form
	echo '<p>Sign up with us today by filling in everything in the form below.</p><br>';
	echo '<form method="post" action="" name="signupform" id="signupform">';
		echo 'First Name: <input type="text" name="firstName" id="firstName" /><br>';
		echo 'Last Name: <input type="text" name="lastName" id="lastName" /><br>';
		echo 'Email Address: <input type="text" name="email" id="email" /><br>';
		echo 'Username: <input type="text" name="username" id="username" /><br>';
		echo 'Password: <input type="password" name="password" id="password" /><br>';
		echo 'Newsletter: <select name="newsletter" id="newsletter"><option>Choose</option><option value="1">Yes</option><option value="0">No</option></select><br>';
		echo '<input type="submit" name="Submit" id="Submit" value="Sign Up" />';
	echo '</form>';
	
	// If the Submit Button is Clicked
	if (isset($_POST['Submit'])){
		// Setup the variables
		$firstname =  $_POST['firstName'];
		$lastname = $_POST['lastName'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		$passwd = $_POST['password'];
		$password = md5($passwd);
		$newsletter = $_POST['newsletter'];
		
		// Put the user into the database
		$nuser = mysql_query("INSERT INTO users (username, password, isUser, isAdmin, isTeam, firstName, lastName, role, email, newsletter, online) VALUES ('$username','$password','1','0','0','$firstname','$lastname','User','$email','$newsletter','0')");
		if(!$nuser) {
			echo '<p><strong>Sorry! There appears to be an error. Please try again at a later time.</strong></p>';
			echo 'Error: '. mysql_error();
		}
		else {
			// If it's good
			echo '<p><strong>Congrats, your account has been created. Please <a href="login.php">Log In HERE</a></strong></p>';
		}
	}
	
}

function loginBlock() {
	// build the login block
	echo '<h2>Log In</h2>';
	echo '<form method="post" action="login.php" name="loginform" id="loginform">';
		echo 'Username<br><input type="text" name="username" id="username" /><br>';
		echo 'Password<br><input type="password" name="password" id="password" /><br>';
		echo '<input type="submit" name="login" id="login" value="Login" />';
	echo '</form>';
	echo '<p><a href="signup.php">Sign Up</a>&nbsp; | &nbsp;<a href="forgot.php">Forgot Password</a></p>';
}
  ?>


