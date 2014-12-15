<?php
session_start();
require("libraries/controller.php");
require("libraries/error.php");

//remove the subpath to the root from the URI
global $_URI, $_ARGS;
$_URI = $_SERVER['REQUEST_URI'];
$_URI = str_replace('^/', '', '^'.$_URI);

//take out the $_GET request part if it's there (and put it into the actual $_GET array)
if (substr_count($_URI, "?") > 0) {
	$delimpos = strpos($_URI, "?");
	$getPart = substr($_URI, $delimpos+1);
	$_URI = substr($_URI, 0, $delimpos);
	$getPart = explode("&", $getPart);
	foreach ($getPart as $i) {
		$pair = explode("=", $i, 2);
		if (sizeof($pair) > 2)
			raiseError(500);
		elseif (sizeof($pair) == 2)
			$_GET[$pair[0]] = $pair[1];
		else
			$_GET[$pair[0]] = "";
	}
	unset($delimpos);
	unset($getPart);
	unset($pair);
}

//explode $_URI by forward slashes, consider the first part of the url as the "command" of sorts, in $_URI[0]
$_URI = trim($_URI, "/");
$_URI = explode('/', $_URI);
$_URI[0] = strtolower($_URI[0]);

//take pairs from the remaining url segments (1..n-1) as $_ARGS[key]=value, where key is always lowercase
$_ARGS = array();
for ($i = 1; $i < sizeof($_URI)-1; $i += 2)
	$_ARGS[strtolower($_URI[$i])] = $_URI[$i+1];
if ($i == sizeof($_URI)-1) //add a trailing parameter (if existent) as $_ARGS[key]=""
	$_ARGS[strtolower($_URI[$i])] = "";
	
//request a page directly (/ajax or /static)
if (($_URI[0] == "ajax") || ($_URI[0] == "static")) {
	if (!isset($_SESSION['currentAccount']))
		raiseError(401);
	if (sizeof($_ARGS) == 0)
		raiseError(400);
	if (!file_exists("ajax/" . $_URI[1]))
		raiseError(404);
	require("ajax/" . $_URI[1]);
	die();
}

//redirect to a main place if no page requested (ie. "/")
if ($_URI[0] == "") {
	//option 1:
	header("Location: /main");
	//option 2:
	$_URI[0] = "_";
}

//load the requested page via a controller, else show 404
if (file_exists("controllers/" . $_URI[0] . ".php")) {
	require("libraries/mysql.php");
	require("libraries/escape.php");
	require("libraries/misc.php");
	require("libraries/auth.php");
	
	require("controllers/" . $_URI[0] . ".php");
	$controllerName = ucfirst($_URI[0]) . "Controller";
	$controller = new $controllerName();
	$controller->view();
} else {
	raiseError(404);
}
?>