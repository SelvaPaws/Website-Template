<?php
if ($_SERVER['SERVER_NAME'] == 'localhost')
or ($_SERVER['SERVER_NAME'] == '127.0.0.1')
	$_MYSQL['host'] = 'localhost';
else
	$_MYSQL['host'] = $_SERVER['HTTP_HOST'];

# fill this in:
$_MYSQL['user'] = 'root';
$_MYSQL['password'] = '';
?>