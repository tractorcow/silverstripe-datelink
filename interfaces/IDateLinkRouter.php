<?php

/**
 * Interface for the date link route handler
 * @author Damian Mooyman
 */
interface IDateLinkRouter {

	/**
	 * Initiates all previously defined routes.
	 */
	public function RegisterRoutes();

	/**
	 * Instructs the module to refresh the routing XML cache file
	 * This may not be called during manifest initialisation (_config.php) as database access is not available
	 */
	public function RefreshCache();

}
