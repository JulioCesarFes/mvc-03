<?php spl_autoload_register (function ($className) {

	require_once "_do_not_touch_/$className.php";

}) ?>