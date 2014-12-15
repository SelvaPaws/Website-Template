<?php

global $_URI;
if (!isset($_URI[1])) {
	raiseError(400);
}

if (($_URI[1] == "sql") or ($_URI[1] == "mysql"))
	require("views/sub/exec_mysql.php");
elseif ($_URI[1] == "php")
	require("views/sub/exec_php.php");
else
	raiseError(404);

?>