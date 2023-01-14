<?php class Router {

	static $search_locked = false;
	static $carry_params = null;

	static function route ($verb, $route) {
		$carry_params = null;

		if (self::$search_locked) return self::class;
		
		if ($verb != strtolower($_SERVER['REQUEST_METHOD'])) return self::class;
		
		if (self::fail_route_test($route)) return self::class;
		
		self::$carry_params = self::get_params($route);

		return self::class;
	}

	static function to ($controller, $method) {
		if (self::$search_locked) return self::class;
		if (self::$carry_params == null) return self::class;

		self::$search_locked = true;

		$controller .= 'Controller';

		if (!class_exists($controller)) return self::class;

		if (!method_exists($controller, $method)) return self::class;
		
		$controller = new $controller;
		$controller->$method(...self::$carry_params);

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
		}, $route);
		
		$route = implode('', $route);
		
		return "/^$route\/?$/";
	}

	private static function fail_route_test ($route) {
		return !preg_match(self::get_regex($route), $_SERVER['REQUEST_URI']);
	}
	
	private static function get_params ($route) {
		preg_match(self::get_regex($route), $_SERVER['REQUEST_URI'], $matches);
		return $matches;
	}

} ?>
