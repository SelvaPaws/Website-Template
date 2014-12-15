<?php
class SignupController extends Controller {
	
	function __construct() {
		$this->message = "";
		if ($_POST)
			$this->makeAccount();
		$this->pageTitle = "Sign Up";
	}

	protected function userExists($username) {
		$SQL = new DatabaseAccess('UserControl');
		$query = "SELECT NULL FROM Users WHERE username='".fixMySQL($username)."'";
		return ($SQL->count($query) > 0);
	}
	
	protected function hashPass($password) {
		return hash("whirlpool",strval(strlen($password)).hash("sha512",$password));
	}
	
	protected function makeAccount() {
		if (!all_in($_POST,array('username', 'password1', 'password2')))
			raiseError(400);
		$SQL = new Db();
		if (strlen($_POST['username']) > 0) {
			if (!$this->userExists($_POST['username'])) {
				if ($_POST['password1'] == $_POST['password2']) {
					if (strlen($_POST['password1']) > 0) {
						//all is well
						$query = "INSERT INTO users (username, passhex, joined) VALUES ('".fixMySQL($_POST['username'])."', '".$this->hashPass($_POST['password1'])."', CURRENT_TIMESTAMP)";
						$SQL->insert($query);
						$query = "SELECT id FROM users WHERE username='".fixMySQL($_POST['username'])."'";
						$_SESSION['currentAccount'] = $SQL->fetchSingleField($query,'id');
						require("settings/settings.php");
						header("Location: " . $siteroot . "/" . $defaultPage2);
					} else {
						$this->message = "No password was entered.";
					}
				} else {
					$this->message = "Entered passwords don't match.";
				}
			} else {
				$this->message = "Username is unavailable.";
			}
		} else {
			$this->message = "No username was entered.";
		}
	}
}
?>