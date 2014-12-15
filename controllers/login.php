<?php
class LoginController extends Controller {
	
	function __construct() {
		$this->message = "";
		if (isset($_SESSION['currentAccount'])) {
			$SQL = new Db();
			$query = "SELECT username FROM users WHERE id=".$_SESSION['currentAccount'];
			$this->message = "Logged in as ".$SQL->fetchSingleField($query,'username');
		}
		if ($_POST)
			$this->login();
		if ((isset($_ARGS['logout'])) && (isset($_SESSION['currentAccount'])))
			$this->logout();
		$this->pageTitle = "Log In";
	}
	
	protected function hashPass($password) {
		return hash("whirlpool",strval(strlen($password)).hash("sha512",$password));
	}
	
	protected function login() {
		if (!isset_r($_POST, array('username', 'password')))
			raiseError(400);
		$SQL = new DatabaseAccess('UserControl');
		$query = "SELECT id FROM users WHERE username='".fixMySQL($_POST['username'])."' AND passhex='".$this->hashPass($_POST['password'])."'";
		if ($SQL->count($query) == 1) {
			$_SESSION['currentAccount'] = $SQL->fetchSingleField($query,'id');
			require("settings/settings.php");
			header("Location: ".$siteroot."/".$defaultPage2);
		} else {
			$this->message = "Username or Password Incorrect.";
		}
	}
	
	protected function logout() {
		unset($_SESSION);
		session_destroy();
		$this->message = "Successfully logged out.";
	}
}
?>