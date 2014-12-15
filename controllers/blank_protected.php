<?php
class ProtectedController extends Controller {
	
	function __construct($requestArguments) {
		if (!isAuthenticated('user'))
			raiseError(401);
	}
}
?>