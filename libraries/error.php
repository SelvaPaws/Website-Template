<?php
require_once("settings/error_list.php");

class ErrorController extends Controller {
	
	protected $errorCode;
	protected $errorName;
	protected $errorMessage;
	
	public function __construct($errorCode = 500) {
		$this->setErrorCode($errorCode);
		$this->setViewName('error');
		$this->pageTitle = $errorCode.' Error';
		$this->template = 'default';
	}
	
	private function setErrorCode($errorCode) {
		global $_ERRORS;
		$this->errorCode = $errorCode;
		if (isset($_ERRORS[$this->errorCode])) {
			$this->errorName = strval($this->errorCode)." ".$_ERRORS[$this->errorCode][0];
			$this->errorMessage = $_ERRORS[$this->errorCode][1];
		} else {
			$this->errorName = "Unknown";
			$this->errorMessage = "An unknown error has occurred.";
		}
	}
}

function raiseError($errorCode) {
	$errorController = new ErrorController($errorCode);
	$errorController->view();
	die();
}
?>