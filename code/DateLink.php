<?php

/**
 * Configuration class for the datelink module 
 * Provides a static wrapper to the module route handler instance
 * @author Damian Mooyman
 */
class DateLink
{
    /**
     * Class to use for implementation of IDateLinkrouter
     * @see IDateLinkRouter
     * @var string
     */
    public static $router_class = 'DateLinkRouter';

    /**
     * Default value for the url pattern to use in routing
     * Care must be taken when constructing this, as it must follow some exact rules:
     * - $Year MUST appear somewhere as too many wildcards will cause it to match too many false positives in routing
     * - This pattern is used both in routing and in building URLS for date linked pages. When building links everything
     *   after the // will be cut off and have any $action appended on the end
     * - The $ParentLink field will be replaced with the actual parent url both in routing and in building links
     * - You can use $Year, $Month, $MonthName, $Date, $Weekday, $ParentLink, $URLSegment and constants
     * - You can use #$Month and #$Date for zero-padded versions
     * - All patterns before the // should end with ! to tell Silverstripe that this is a required pattern
     * @see DateLinkRouter::urlPattern
     * @var string
     */
    public static $default_url_pattern = '$ParentLink!/$Year!/$Month!/$URLSegment!//$Action/$ID/$OtherID';
    
    /**
     * Default value for the date field to use
     * @see DateLinkRouter::dateField
     * @var string
     */
    public static $default_date_field = 'Created';

    /**
     * Instance of date link router to use
     * @var IDateLinkRouter
     */
    private static $_instance = null;

    /**
     * Returns or constructs the route object to use for this module
     * @return IDateLinkRouter
     */
    public static function instance()
    {
        if (!self::$_instance)
            self::$_instance = new self::$router_class(self::$default_date_field, self::$default_url_pattern);
        return self::$_instance;
    }

    /**
     * Registers a class beneath which all child pages will be date-mapped.
     * @param type $className Name of the class to register
     * @param callback|boolean $filter a boolean, callback, or other closure that can be passed instances of the
     * specified class to determine if it should be consitered when filtering
     */
    public static function register_class($className, $filter = true)
    {
        self::instance()->RegisterClass($className, $filter);
    }

    /**
     * Sets the field to extract the date from
     * @param string $field Name of the date field
     */
    public static function set_date_field($field)
    {
        self::instance()->setDateField($field);
    }
    
    /**
     * Gets the field to extract the date from
     * @return string Name of the date field
     */
    public static function get_date_field()
    {
        return self::instance()->getDateField();
    }

    /**
     * Sets the pattern to use when routing and generating links
     * @param string $pattern The pattern to use
     */
    public static function set_url_pattern($pattern)
    {
        self::instance()->setURLPattern($pattern);
    }

    /**
     * Gets the pattern to use when routing and generating links
     * @return string The pattern used
     */
    public static function get_url_pattern()
    {
        return self::instance()->getURLPattern();
    }

    /**
     * Instructs the module to refresh the routing XML cache file
     * This may not be called during manifest initialisation (_config.php) as database access is not available
     */
    public static function refresh_cache()
    {
        self::instance()->RefreshCache();
    }
}