<?php

/*
 * News Feed Syndication
 * Utilizing Datapulls from Data to display as xml
 * in RSS format
 */
 

// include the configuration
// Connection Strings are held in config
include 'includes/base.php';

// Pull the data we need
$sql = "SELECT * FROM news";
$q	 = mysql_query($sql) or die(mysql_error());

//header('Content-type: rss+xml');
echo '<?xml version="1.0"?>';
echo '<rss version="2.0">';
echo '<channel>';

// Pull the loop and display the data
while($row = mysql_fetch_array($q))
{
	$title = $row['title'];
	$content = $row['content'];
	$link = $row['link'];
	$author = $row['author'];
	
	// Produce the xml per item
	echo '<item>';
	echo '<title>'.$title.'</title>';
	echo '<description>'.$content.'</description>';
	echo '<link>'.$link.'</link>';
	echo '<author>'.$author.'</author>';
	echo '</item>';
}
echo '</channel>';
echo '</rss>';
 
?>
