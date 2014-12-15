<?php
abstract class Controller {
	
	protected $viewName;
	protected $pageTitle;
	protected $template;
	
	final private function setup($template = 'default') {
		global $_URI;
		if (!isset($this->viewName))  $this->viewName  = strtolower($_URI[0]);
		if (!isset($this->pageTitle)) $this->pageTitle = ucfirst($_URI[0]);
		if (!isset($this->template))  $this->template  = $template;
	}
	
	public function __construct() {
		$this->setup();
	}
	
	final protected function setViewName($name) {
		if (!is_string($name))
			$name = strval($name);
		
		if ($name == '')
			raiseError(501); //Not Implemented
		
		$this->viewName = $name;
	}
	
	final public function view() {
		if ((!isset($this->viewName)) or (!isset($this->pageTitle)) or (!isset($this->template)))
			$this->setup();
	
		global $_URI;
		if (!isset($this->viewName))
			$this->setViewName(strtolower($_URI[0]));
		if (!isset($this->pageTitle))
			$pageTitle = ucfirst($this->viewName);
		
		$viewAddress = 'views/'.$this->viewName.'.php';
		if (!file_exists($viewAddress))
			raiseError(404); //File Not Found
		
		global $_URI, $_ARGS;
		if ($this->template == NULL)
			$this->template = 'default';
		require('templates/'.$this->template.'.php'); //this also requires $viewAddress
	}
}

?>