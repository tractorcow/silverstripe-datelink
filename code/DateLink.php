<?php

/**
 * Configuration class for the datelink module 
 */
class DateLink
{
    public static $router_class = 'DateLinkRouter';

    public static $default_url_pattern = '$Month!/$URLSegment!/$Action/$ID/$OtherID';
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
            self::$_instance = new self::$router_class(self::$default_date_field);
        return self::$_instance;
    }

    /**
     * Registers pages within the route table using the class type as an identifier
     * @param type $classType 
     */
    public static function register_class($classType)
    {
        self::instance()->RegisterClass($classType);
    }

    public static function register_link($link)
    {
        self::instance()->RegisterLink($link);
    }

    public static function set_date_field($field)
    {
        self::instance()->setDateField($field);
    }

    public static function get_date_field()
    {
        return self::instance()->getDateField();
    }

    public static function refresh_cache()
    {
        self::instance()->RefreshCache();
    }
}