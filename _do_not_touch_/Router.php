<?php class Router extends RouterRequirements {

	static $search_locked;

	static function route ($verb, $route) {
		if (self::fail(func_get_args(), __METHOD__)) return self::class;
		
		if (self::$search_locked) return self::class;

		if ($verb != strtolower($_SERVER['REQUEST_METHOD'])) return self::class;

		if (self::fail_route_test($route)) return self::class;

		return self::class;
	}

	static $carry_locked;

	static function to ($controller, $method) {
		if (self::fail(func_get_args(), __METHOD__)) return self::class;
		
		if (self::$carry_locked) return self::class;

		return self::class;
	}

	static function root ($controller, $method) {
		return self::route('get', '/')::to($controller, $method);
	}



	private static function get_regex ($route) {
		$route = explode('/', $route);

		$route = array_map(function ($slash) {
			if (!$slash) return '';

			if (substr($slash, 0, 1) == ':') return "\/(.*)";

			return "\/$slash";
		});
		
		$route = implode('', $route);
		
		return "/^$route$/";
	}

	private static fail_route_test ($route) {
		return !preg_match(self::get_regex($route), $_SERVER['REQUEST_URI']);
	}

} ?>
