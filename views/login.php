<div id="title">
	<p>Log In</p>
</div>
<div id="login-body">
<div id="login-links">
	<p>Don't have an account? Click <a href="<?php echo $siteroot; ?>/signup">here</a> to make one.</p>
</div>
<form id="login" name="login" method="post" action="<?php echo $siteroot; ?>/login">
	<table class="noborder">
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username" id="username" size="30" maxlength="16" /><br /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password" id="password" size="30" maxlength="255" /></td>
		</tr>
	</table>

	<?php if ($this->message){?>
	<div id="login-message"><?php echo $this->message; ?></div>
	<?php }?>
	<div id="login-buttons">
		<input type="submit" value="Login" />
		<input type="reset" value="Clear" />
	</div>
</form>
</div>