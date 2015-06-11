<?php

/* header.php
 * Header for twistedmsn.net
 * Inluded in every page
 * Adapted from TweDev Mini CMS
 * Last change 2014 Aug 15 11:33PM UTC
 */
 
 // include the site-wide settings
 include 'includes/base.php';
 
 // include the site functions
 include 'includes/functions.php';
 ?>
 
  <!DOCTYPE html>
<html lang="en">
<head>
<meta charset=utf-8>
<meta name="Robots" content="All">
<meta name="Distributor" content="Global">
<meta name="Rating" content="General">
<meta name="Revisit-After" content="1 days">
<meta name="DESCRIPTION" content="<?php echo $site_description; ?>">
<meta name="KEYWORDS" content="<?php echo $site_keywords; ?>">
<meta name="no-email-collection" content="http://www.unspam.com/noemailcollection/">
<link rel="stylesheet" href="css/style.css">
<title><?php echo $sitename; ?></title>
<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<script src="js/IE9.js"></script>
<![endif]-->
</head>

<body>
<div id="wrapper">
	<div id="header">
		<h1><?php echo $sitename; ?></h1>
		<h2><?php echo $slogan; ?></h2>
		<!-- Honeypot -->
		<a href="<?php echo $siteurl; ?>/<?php echo $honeypot; ?>.php"><!-- tryme --></a>
	</div>
	<div id="menu">
		<?php include 'blocks/topnav.php'; ?>
	</div>
	<div id="content">
	
	<div id="left">