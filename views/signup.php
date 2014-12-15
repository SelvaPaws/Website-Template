<div id="title">
	<p>Sign Up</p>
</div>
<div id="signup-body">
<div id="login-links">
	<p>Already have an account? Click <a href="<?php echo $siteroot; ?>/login">here</a> to log in.</p>
</div>
<form id="signup" name="signup" method="post" action="<?php echo $siteroot; ?>/signup">
	<table class="noborder">
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username" id="username" size="30" maxlength="16" /><br /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password1" id="password1" size="30" maxlength="255" /></td>
		</tr>
		<tr>
			<td>Retype:</td>
			<td><input type="password" name="password2" id="password2" size="30" maxlength="255" /></td>
		</tr>
	</table>

	<?php if ($this->message){?>
	<div id="signup-message"><?php echo $this->message; ?></div>
	<?php }?>
	<div id="signup-buttons">
		<input type="submit" value="Create" />
		<input type="reset" value="Clear" />
	</div>
</form>
</div>