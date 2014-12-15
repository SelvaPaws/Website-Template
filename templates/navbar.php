<div id="navbar">
<div style="float:right;" name="navbar-buttons">
<?php
if (isAuthenticated('user')) { ?>
<table class="noborder">
	<tr>
		<!-- Insert stuff to float on the right of the navbar when not logged in here -->
	</tr>
</table>
<?php } else { ?>
<table class="noborder">
	<tr>
		<!-- Insert stuff to float on the right of the navbar when logged in here -->
	</tr>
</table>
<?php } ?>
</div>
<div style="text-align: left" name="navbar-logo">
<!-- From here to the next comment is the site logo -->
<a href="/">
<img src="images/header_logo.png" alt="logo">
</a>
<!-- Insert more stuff to stay on the left of of the navbar here -->
</div>
</div>