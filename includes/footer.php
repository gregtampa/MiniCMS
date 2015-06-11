<?php

/* footer.php
 * Footer for twistedmsn.net
 * Inluded in every page
 * Adapted from TweDev Mini CMS
 * Last change 2014 Aug 15 11:35PM UTC
 */
 // close the left div
  echo '</div>';
 // show the right blocks
 include 'blocks/right-block.php';
 
 // Check to see if FaceBook is allowed
 if ($fb_active == 1) {
	 $getFaceBook = '<a href="'.$facebook.'" target="_blank"><img src="images/facebook.png" alt="Join us on FaceBook"></a>';
}

// Check to see if Twitter is allowed
 elseif ($tw_active == 1) {
	 $getTwitter = '<a href="'.$twitter.'" target="_blank"><img src="images/twitter.png" alt="Join us on Twitter"></a>';
}

// Check to see if Google+ is allowed
 elseif ($gplus_active == 1) {
	 $getGPlus = '<a href="'.$gplus.'" target="_blank"><img src="images/g+.png" alt="Join us on Google+"></a>';
}

// Check to see if LinkedIn is allowed
 elseif ($linkedin_active == 1) {
	 $getLinkedIn = '<a href="'.$linkedin.'" target="_blank"><img src="images/linkedin.png" alt="Join us on LinkedIn"></a>';
}

// Check to see if Tumblr is allowed
 elseif ($tu_active == 1) {
	 $getTumblr = '<a href="'.$tumblr.'" target="_blank"><img src="images/tumblr.png" alt="Join us on Tumblr"></a>';
}

// Check to see if the RSS Feed is allowed
 elseif ($allow_rss == 1) {
	 $getRSS = '<a href="'.$rssfeed.'" target="_blank"><img src="images/rss.png" alt="RSS Feed"></a>';
}
else {
}

 ?>
<!-- End the Main Content -->
</div>
	<div id="footer">
		<p class="copyright">Copyright &copy; <script type="text/javascript">var dt = new Date(); var year = dt.getFullYear(); document.write(year)</script> <?php echo $copyright; ?></p>
		<p class="links">
		<?php echo $getFaceBook; ?>
		<?php echo $getTwitter; ?>
		<?php echo $getGPlus; ?>
		<?php echo $getLinkedIn; ?>
		<?php echo $getTumblr; ?>
		<?php echo $getRSS; ?>
		<!-- Honeypot -->
		<a href="<?php echo $siteurl; ?>/<?php echo $honeypot; ?>"><!-- random --></a>
	</div>
</div>
</body>
</html>