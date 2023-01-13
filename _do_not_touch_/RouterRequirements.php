<?php class RouterRequirements {

	static function fail ($arguments, $method_name) {
		return self::$method_name(...$arguments);
	}

	static function route ($verb, $route) {
		if ($verb == 'get' && $route == '/') return false;

		return true; 
	}

	static function to ($controller, $method) {
		if (false) return false;
		return true;
	}

} ?>