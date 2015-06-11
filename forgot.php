<?php
/*
 * Last Update
 * 20141010 2118 Scott
 * forgot.php
 * Twisted Development
 * www.twedev.com
 * (c) 2014 Twisted Development
*/

include 'includes/header.php';

ob_start();

// Set the function variable
if (isset($_GET['op'])) {
	$d = $_GET['op'];
	} elseif (isset($_POST['op'])) { // Forms
	$d = $_POST['op'];
} else {
	$d = NULL;
}
function all() {
?>
<p>Please enter your email address below to have a new Password created and emailed to you.</p>
<form action="forgot.php?&op=send" method="post">
<label> Enter Email Address : </label>
<input id="email" type="text" name="email" />
<input id="button" type="submit" name="button" value="Submit" />
</form>

<?php
}

function createRandomPassword() {
 
    $chars = "abcdefghijkmnopqrstuvwxyz023456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!#_";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
 
    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
 
    return $pass;
 
}

function send() {
	if (isset($_POST['button'])){
		$eaddress = $_POST['email'];
		$query="select email, firstName from users where email='$eaddress'";
		$result = mysql_query($query);
		$count=mysql_num_rows($result);
		// If the count is equal to one, we will send message other wise display an error message.
		if($count == 1){
			$rows=mysql_fetch_array($result);
			$em = $rows['email'];
			$fn = $rows['firstName'];

			
			$password = createRandomPassword();
			
			// We need site information
			$s2 = mysql_query("SELECT site_email, sitename FROM settings") or die('Error: '. mysql_error() );
			$row = mysql_fetch_array($s2);
			$s_email = $row['site_email'];
			$site_name = $row['sitename'];
		
			// Setup the email
			/* Set e-mail recipient */
			$from = 'From: '.$s_email.'';
			$subject = 'Password Reset Request for '.$site_name.'';
			/*
			echo '<p>'.$em.'</p>';
			echo '<p>'.$fn.'</p>';
			echo '<p>'.$password.'</p>';
			echo '<p>'$s_email'</p>';
			echo '<p>'.$site_name.'</p>';
			*/
					
// Let's prepare the message for the e-mail 
$message = "Hello $fn
			
A Recent request made by you to recover your password has been received.
			
Your new password for $site_name is $password
Please keep this for your records.
			
Thank you and keep being you.
			
$site_name Administrator
";
			
// Send the message using mail() function 
mail($em, $subject, $message, $from);
	
// MD5 the generated password
$pass = md5($password);		
mysql_query("UPDATE users SET password = '$pass' WHERE email = '$em'");
			
			echo '<h2>Hello</h2>';
			echo '<p>An email has been sent to your registered email address from the Site Administrator.</p>';
			echo '<p>Please check your email!</p>';
			echo '<p>Thank you!</p>';
		}
		elseif ($count == 0) {
			echo '<p>Sorry, that email address was not found, please try again</p>';
		}
	}
}

// Switches
switch($d) {
	
	case 'send':
			send();
			break;	
			
	default:
		   all();
		   break;
		   
die();
}
// Include the footer
include 'includes/footer.php';
exit;
?>