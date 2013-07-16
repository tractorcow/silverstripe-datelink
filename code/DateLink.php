<?php

/**
 * Configuration class for the datelink module 
 * Provides a static wrapper to the module route handler instance
 * 
 * @package datelink
 * @author Damian Mooyman
 */
class DateLink extends Object {

	/**
	 * Instance of date link router to use
	 * @var IDateLinkRouter
	 */
	private static $_instance = null;

	/**
	 * Returns or constructs the route object to use for this module
	 * @return IDateLinkRouter
	 */
	public static function instance() {
		if (empty(self::$_instance)) {
			self::$_instance = DateLinkRouter::create();
		}
		return self::$_instance;
	}

	/**
	 * Registers a class beneath which all child pages will be date-mapped.
	 * @param type $className Name of the class to register
	 * @param callback|boolean $filter a boolean, callback, or other closure that can be passed instances of the
	 * specified class to determine if it should be consitered when filtering
	 */
	public static function register_class($className, $filter = true) {
		self::instance()->RegisterClass($className, $filter);
	}

	/**
	 * Instructs the module to refresh the routing XML cache file
	 * This may not be called during manifest initialisation (_config.php) as database access is not available
	 */
	public static function refresh_cache() {
		self::instance()->RefreshCache();
	}
	
	public static function register_routes() {
		self::instance()->RegisterRoutes();
	}

}
