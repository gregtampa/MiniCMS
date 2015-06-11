<?php

include 'includes/header.php';



// We need the username variable
$username = $_SESSION['username'];
// Pull data to get the enabled or disabled variable
$admin = mysql_query("SELECT isAdmin, firstName FROM users WHERE username='$username'") or die('Error: '. mysql_error() );
$row = mysql_fetch_array($admin);
// Assign the needed variables
$isadm = $row['isAdmin'];
$firstname = $row['firstName'];

// If the person is not an administrator
if ($isadm == 0) {
	echo '<p>Sorry, you don\'t belong here!</p>';
	echo "<meta http-equiv='refresh' content='=0;oops.php' />";
}
else {
}


// Function operatives
if (isset($_GET['op'])) {
	$d = $_GET['op'];
	} elseif (isset($_POST['op'])) { // Forms
	$d = $_POST['op'];
} else {
	$d = NULL;
}


// Switch
switch($d) {
	case 'projects':
			projects();
			break;
	case 'addProject':
			addProject();
			break;
	case 'editProject':
		    editProject();
		    break;
	case 'deleteProject':
		    deleteProject();
		    break;
		    
	// Settings
	case 'settings':
			settings();
			break;
			
	default:
		   all();
		   break;
}

// Functions only below this line

function all() {
	
		echo '<h2>Site Administration</h2>';
		echo '<p>You are now at your site\'s administration page. Use the provided links to manage this site.</p>';
		
		echo '<table border="0" width="100%" align="center">';
		echo '<tr>';
		
		// Gather the Projects Data by title, phase and developer
		$admin_links = mysql_query("SELECT * FROM admin_links ORDER BY label") or die('Error: '. mysql_error() );
		while($row = mysql_fetch_array($admin_links)){
			$linkid = $row['id'];
			$label = $row['label'];
			$admfile = $row['file'];
			$image = $row['image'];
			
			echo '<td align="center">';
			echo '<a href="manage.php?op='.$admfile.'"><img src="images/admin/'.$admfile.'.png" height="40" width="40"><br>'.$label.'</a>';
			echo '</td>';
		}
		echo '</tr>';
		echo '</table>';
}

function projects() {
	// Code
	echo '<p>Manage Projects</p>';
	echo '<p><table border="0" width="100%" align="center">';
	echo '<tr>';
	echo '<td><strong>Project</strong></td>';
	echo '<td><strong>Developer</strong></td>';
	echo '<td><strong>Phase</strong></td>';
	echo '<td><strong>Tools</strong></td>';
	echo '</tr>';
	// Gather the Projects Data by title, phase and developer
	$pjs = mysql_query("SELECT id, developer, project, project_phase FROM projects ORDER BY project") or die('Error: '. mysql_error() );
	while($row = mysql_fetch_array($pjs)){
		$dev = $row['developer'];
		$proj = $row['project'];
		$prophase = $row['project_phase'];
		$projid = $row['id'];
		
		// Display the projects and tools
		echo '<tr>';
		echo '<td>'.$proj.'</td>';
		echo '<td>'.$dev.'</td>';
		echo '<td>'.$prophase.'</td>';
		echo '<td><strong><a href="manage.php?op=editProject&id='.$projid.'">Edit</a> | <a href="manage.php?op=deleteProject&id='.$projid.'">Delete</a> | <a href="manage.php?op=addProject">Add</a></strong></td>';
		echo '</tr>';
	}
	echo '</table></p>';
	
}

function editProject() {
	// Get the id from the projects function
	$id = (int) $_GET['id'];
	$eproj = mysql_query("SELECT * FROM projects WHERE id = '$id'") or die('Error: '. mysql_error() );
	$row = mysql_fetch_array($eproj);
	$dev = $row['developer'];
	$project = reverse_escape($row['project']);
	$description = reverse_escape($row['project_description']);
	$percentage = reverse_escape($row['completion_percentage']);
	$phase = reverse_escape($row['project_phase']);
	
	echo '<h2>Edit Project -- '.$project.'</h2>';
	echo '<form action="" method="post">';
	echo '<table border="0" width="100%">';
	echo '<tr>';
	echo '<td><strong>Developer:</strong></td>';
	echo '<td><input type="text" name="developer" value="'.$dev.'"></td>';
	echo '</tr><tr>';
	echo '<td><strong>Project:</strong></td>';
	echo '<td><input type="text" name="project" value="'.$project.'"></td>';
	echo '</tr><tr>';
	echo '<td valign="top"><strong>Description:</strong></td>';
	echo '<td><textarea cols="40" rows="20" name="project_description">'.$description.'</textarea></td>';
	echo '</tr><tr>';
	echo '<td><strong>Complete:</strong></td>';
	echo '<td><input type="text" name="percentage" value="'.$percentage.'">%</td>';
	echo '</tr><tr>';
	echo '<td><strong>Phase:</td>';
	echo '<td><input type="text" name="project_phase" value="'.$phase.'"></td>';
	echo '</tr>';
	echo '</table>';
	echo '<div><input type="submit" value="Update" name="Submit"></div>';
	echo '</form>';
	
	// If the Submit Button is Clicked
	if (isset($_POST['Submit'])){
		// Setup the variables
		$dev = safe($_POST['developer']);
		$proj = safe($_POST['project']);
		$desc = safe($_POST['project_description']);
		$percent = safe($_POST['percentage']);
		$proj_phase = safe($_POST['project_phase']);
		
		// Put the request into the database
		$sql = mysql_query("UPDATE projects SET developer='$dev', project='$proj', project_description='$desc', completion_percentage='$percent', project_phase='$proj_phase' WHERE id='$id'") or die('Error: '. mysql_error() );
		// If it's no good
		if(!$sql) {
			echo '<p><b>Sorry! This Project could not be updated.</b></p>';
		}
		else {
			// If it's good
			echo '<p><b>Project Successfully Updated.</b></p>';
		}
	}
	
}

function addProject() {
	// The Form
	echo '<h2>Add a New Project</h2>';
	echo '<form action="" method="post">';
	echo '<table border="0" width="100%">';
	echo '<tr>';
	echo '<td><strong>Developer:</strong></td>';
	echo '<td><input type="text" name="developer"></td>';
	echo '</tr><tr>';
	echo '<td><strong>Project:</strong></td>';
	echo '<td><input type="text" name="project"></td>';
	echo '</tr><tr>';
	echo '<td valign="top"><strong>Description:</strong></td>';
	echo '<td><textarea cols="40" rows="20" name="project_description"></textarea></td>';
	echo '</tr><tr>';
	echo '<td><strong>Complete:</strong></td>';
	echo '<td><input type="text" name="percentage">%</td>';
	echo '</tr><tr>';
	echo '<td><strong>Phase:</td>';
	echo '<td><input type="text" name="project_phase"></td>';
	echo '</tr>';
	echo '</table>';
	echo '<div><input type="submit" value="Update" name="Submit"></div>';
	echo '</form>';
	
	// If the Submit Button is Clicked
	if (isset($_POST['Submit'])){
		// Setup the variables
		$dev = safe($_POST['developer']);
		$proj = safe($_POST['project']);
		$desc = safe($_POST['project_description']);
		$percent = safe($_POST['percentage']);
		$proj_phase = safe($_POST['project_phase']);
		
		// Put the request into the database
		$sql = mysql_query("INSERT INTO projects (developer, project, project_description, completion_percentage, project_phase, start_date) VALUES ('$dev','$proj','$desc','$percent','$proj_phase',CURDATE() )");
		
		// If it's no good
		if(!$sql) {
			echo '<p><b>Sorry! This Project could not be Added.</b></p>';
			echo 'Error: '. mysql_error();
		}
		else {
			// If it's good
			echo '<p><b>Project Successfully Added.</b></p>';
		}
	}
}

function deleteProject() {
	// Drop the project by it's ID
	$projid = (int) $_GET['id'];
	$rp = mysql_query("DELETE FROM projects WHERE id='$projid'")or die('Error: '. mysql_error() );
	// If it's no good
	if(!$rp) {
		echo '<p><b>Sorry! This Project could not be deleted.</b></p>';
	}
	else {
		// If it's good
		echo '<p><b>Project Successfully Deleted.</b></p>';
	}

}

function settings() {
	// Query the database
	$site = mysql_query("SELECT * FROM settings") or die('Error: '. mysql_error() );
	// Assign variables
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
	$allow_rss = $row['allow_rss'];
	// Honeypot
	$honeypot = $row['site_honeypot'];
	
	// Create and populate the form table
	echo '<form action="" method="post">';
	echo '<table border="0" width="100%">';
	echo '<tr>';
	echo '<td></td><td><h3>Basic Settings:</h3></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Description:</strong></td><td><input type="text" name="site_description" id="site_description" size="55" value="'.$site_description.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td valign="top"><strong>Keywords:</strong></td><td><textarea cols="45" rows="10" name="site_keywords">'.$site_keywords.'</textarea></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Site Name:</strong></td><td><input type="text" name="sitename" id="sitename" size="55"  value="'.$sitename.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Site URL:</strong></td><td><input type="text" name="site_url" id="site_url" size="55"  value="'.$siteurl.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Site Slogan:</strong></td><td><input type="text" name="site_slogan" id="site_slogan" size="55" value="'.$slogan.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Site Email:</strong></td><td><input type="text" name="site_email" id="site_email" size="55" value="'.$site_email.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Copyright:</strong></td><td><input type="text" name="site_copyright" id="site_copyright" size="55" value="'.$copyright.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td></td><td><p><h3>Social Media</h3></p></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>FaceBook:</strong></td><td><input type="text" name="site_facebook" id="site_facebook" size="55" value="'.$facebook.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Use:</strong></td><td><input type="radio" name="allow_facebook" value="1" checked>Yes &nbsp;<input type="radio" name="allow_facebook" value="0">No &nbsp;<em>Use Facebook?</em></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Twitter:</strong></td><td><input type="text" name="site_twitter" id="site_twitter" size="55" value="'.$twitter.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Use:</strong></td><td><input type="radio" name="allow_twitter" value="1" checked>Yes &nbsp;<input type="radio" name="allow_twitter" value="0">No &nbsp;<em>Use Twitter?</em></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Tumblr:</strong></td><td><input type="text" name="site_tumblr" id="site_tumblr" size="55" value="'.$tumblr.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Use:</strong></td><td><input type="radio" name="allow_tumblr" value="1">Yes &nbsp;<input type="radio" name="allow_tumblr" value="0" checked>No &nbsp;<em>Use Tumblr?</em></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Google+:</strong></td><td><input type="text" name="site_gplus" id="site_gplus" size="55" value="'.$gplus.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Use:</strong></td><td><input type="radio" name="allow_gplus" value="1">Yes &nbsp;<input type="radio" name="allow_gplus" value="0" checked>No &nbsp;<em>Use Google+?</em></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>LinkedIn:</strong></td><td><input type="text" name="site_linkedin" id="site_linkedin" size="55" value="'.$linkedin.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Use:</strong></td><td><input type="radio" name="allow_linkedin" value="1">Yes &nbsp;<input type="radio" name="allow_linkedin" value="0" checked>No &nbsp;<em>Use LinkedIn?</em></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td></td><td><p><h3>RSS Syndication</h3></p></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Use RSS?:</strong></td><td><input type="radio" name="allow_rss" value="1" checked>Yes &nbsp;<input type="radio" name="allow_rss" value="0">No &nbsp;<em>Your RSS News Feed</em></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td></td><td><p><h3>Site Registration</h3></p></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>Registration:</strong></td><td><input type="radio" name="allow_reg" value="1">Yes &nbsp;<input type="radio" name="allow_reg" value="0" checked>No &nbsp;<em>Allow users to register on your site?</em></td>';
	echo '</tr>';
	echo '<td></td><td><p><h3>Honey Pot</h3></p></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td></td><td><em>Get your HoneyPot from <a href="http://www.projecthoneypot.org" target="_blank"><strong>Project Honeypot</strong></a></em></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong>HoneyPot:</strong></td><td><input type="text" name="site_honeypot" id="site_honeypot" size="55" value="'.$honeypot.'"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td></td><td><em>Just the name of your Honeypot file without the file extension. IE: honeypot.php would just be honeypot</em></td>';
	echo '</tr>';
	echo '</table>';
	echo '<br>';
	echo '<div align="center"><input type="submit" value="Update" name="Submit"></div>';
	echo '</form>';
	
	// If the Submit Button is Clicked
	if (isset($_POST['Submit'])){
		// Setup the variables
		$site_description = safe($_POST['site_description']);
		$site_keywords = safe($_POST['site_keywords']);
		$sitename = safe($_POST['sitename']);
		$siteurl = safe($_POST['site_url']);
		$slogan = safe($_POST['site_slogan']);
		$site_email = safe($_POST['site_email']);
		$copyright = safe($_POST['site_copyright']);
		// Facebook
		$facebook = safe($_POST['site_facebook']);
		$fb_active = safe($_POST['allow_facebook']);
		// Twitter
		$twitter = safe($_POST['site_twitter']);
		$tw_active = safe($_POST['allow_twitter']);
		// Tumblr
		$tumblr = safe($_POST['site_tumblr']);
		$tu_active = safe($_POST['allow_tumblr']);
		// Google+
		$gplus = safe($_POST['site_gplus']);
		$gplus_active = safe($_POST['allow_gplus']);
		// LinkedIn
		$linkedin = safe($_POST['site_linkedin']);
		$linkedin_active = safe($_POST['allow_linkedin']);
		// User Registration
		$allow_reg = safe($_POST['allow_reg']);
		// RSS
		$allow_rss = safe($_POST['allow_rss']);
		// HoneyPot
		$honeypot = safe($_POST['site_honeypot']);
		
		// Put the request into the database
		$update = mysql_query("UPDATE settings SET site_description='$site_description', site_keywords='$site_keywords', sitename='$sitename', site_url='$siteurl', site_slogan='$slogan', site_email='$site_email', site_copyright='$copyright', site_facebook='$facebook', allow_facebook='$fb_active', site_twitter='$twitter', allow_twitter='$tw_active', site_tumblr='$tumblr', allow_tumblr='$tu_active', site_gplus='$gplus', allow_gplus='$gplus_active', site_linkedin='$linkedin', allow_linkedin='$linkedin_active', allow_reg='$allow_reg', allow_rss='$allow_rss', site_honeypot='$honeypot'") or die('Error: '. mysql_error() );
		// If it's no good
		if(!$update) {
			echo '<p><b>Sorry! The Settings could not be updated.</b></p>';
			echo 'Error: '. mysql_error();
		}
		else {
			// If it's good
			echo '<p><b>Settings were Successfully Updated.</b></p>';
		}
	}
	
}

// The Footer
include 'includes/footer.php';


?>