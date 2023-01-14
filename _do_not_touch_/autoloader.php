<?php spl_autoload_register (function ($className) {

	if (file_exists("app/controllers/$className.php")) {
		require "app/controllers/$className.php";

		if (is_subclass_of($className, 'Controllers')) return;
	}

	if (file_exists("_do_not_touch_/$className.php")) {
		require_once "_do_not_touch_/$className.php";
	}

}) ?>