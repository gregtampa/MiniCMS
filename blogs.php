<?php

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
	
// Functions only below this line

function all() {
	
	// open the post div
	echo '<h2>Blogs</h2>';
	echo '<p>All posted blogs are listed below.</p>';
	
	// Query the database
	$query = mysql_query("SELECT * FROM blogs ORDER BY postdate DESC") or die('Error: '. mysql_error() );
	
	// Assign the variables
	while($row = mysql_fetch_array($query)){
		$id = $row['bid'];
		$topic = reverse_escape($row['topic']);
		$title = reverse_escape($row['title']);
		$editor = $row['editor'];
		$project = reverse_escape($row['project']);
		$blog_date = date("F d, Y",strtotime($row['postdate']));
		$blog_time = date("H:i A",strtotime($row['postdate']));
		
		// Display the blogs below
    	echo '<p><a href="blogs.php?op=view&id='.$id.'"><h2>'.$title.'</h2></a> '.$blog_date.'</p>';
    	echo '<p><h3>Project:  '.$project.'</h3> &nbsp;<strong>Author:</strong>&nbsp;  '.$editor.'</p>';
    }
}

function view() {
	// Get the Blog ID from all()
	$id = (int) $_GET['id'];
	
	// Query the database
	$query = mysql_query("SELECT * FROM blogs WHERE bid='$id'") or die('Error: '. mysql_error() );
	
	// Assign variables
	$row = mysql_fetch_array($query);
	$id = $row['bid'];
	$topic = reverse_escape($row['topic']);
	$title = reverse_escape($row['title']);
	$editor = $row['editor'];
	$project = reverse_escape($row['project']);
	$post = reverse_escape($row['post']);
	$blog_date = date("F d, Y",strtotime($row['postdate']));
	$blog_time = date("H:i A",strtotime($row['postdate']));
	
	// Display the results
    echo '<p><h2>'.$title.'</h2></p>';
    echo '<p><h3>Project:  '.$project.'</h3></p>';
    echo '<p><h3>Posted By: '.$editor.'</h3></p>';
    echo '<p><strong>Topic:</strong>&nbsp;'.$topic.'</p>';
    echo '<p>'.$post.'</p>';
    echo '<p><strong>Posted:</strong> '.$blog_date.' at '.$blog_time.'</p>';
    
}

function write() {

	if (isset($_POST['Submit'])){
	// Setup the variables
	$topic = safe($_POST['topic']);
	$title = safe($_POST['title']);
	$project = safe($_POST['project']);
	$content = safe($_POST['post']);;
	$curr_timestamp = date('Y-m-d H:i:s');
	$editor = $_SESSION['firstname'];
	// Setup the User variable
	$user = $_SESSION['username'];
	
	// Put the request into the database
	$sql = "INSERT INTO blogs (postdate, topic, project, title, post, editor, userid) VALUES ('$curr_timestamp','$topic','$project','$title','$content','$editor','$user')";
	$retval = mysql_query( $sql );
	if(! $retval )
		{
  			die('Sorry, could not submit your blog: ' . mysql_error());
		}
		else {
			echo '<p>Thank you, your blog was recorded. <a href="blogs.php"><b>Return to the Blogs</b></a></p>';
		}
	}

	// Code
	echo '<h2>Write a New Blog</h2>';
	echo '<p><form action="blogs.php" method="post">';
	echo '<table border="0" cellpadding="0" cellspacing="1" width="100%">';
	echo '<tr>';
	echo '<td><b>Hello</b></td><td></td><td><input type="hidden" name="editor" value="'.$_SESSION['firstName'].' '.$_SESSION['lastName'].'">'.$_SESSION['firstName'].' '.$_SESSION['lastName'].'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td></td><td></td><td>Please enter your Blog below.<br></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Topic:</td><td>&nbsp;</td><td><input type="text" name="topic" placeholder="Your Blog Topic"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Project:</td><td>&nbsp;</td><td><input type="text" name="project" placeholder="Your Project"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Title:</strong></td><td>&nbsp;</td><td><input type="text" name="title" placeholder="Your Blog Title"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td valign="top"><strong>Content:</td><td>&nbsp;</td><td><textarea cols="40" rows="20" name="post">Write your blog here...</textarea></td>';
	echo '</table></p>';
	echo '<p><div align="center"><input type="submit" value="Continue" name="Submit"><input type="reset" value="Reset this Form"></div></p></form>';
	echo '<p><strong>Only the HTML5 Code listed below may be used for blogs on this platform</strong></p>';
	include 'includes/allowedHTML.php';
	
}
// Switch
switch($d) {
	case 'view':
			view();
			break;
	case 'write':
			write();
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
		echo '<p>You must be a member of this to see this content.</p>';
	echo '</div>';
echo '</div>';
}

// The Footer
include 'includes/footer.php';


?>
