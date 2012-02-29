<?php

/**
 * Interface for the date link route handler
 * @author Damian Mooyman
 */
interface IDateLinkRouter
{
        /**
     * Sets the field to extract the date from
     * @param string $field Name of the date field
     */
    public function setDateField($field);

    /**
     * Gets the field to extract the date from
     * @return string Name of the date field
     */
    public function getDateField();

    /**
     * Sets the pattern to use when routing and generating links
     * @param string $pattern The pattern to use
     */
    public function setURLPattern($pattern);

    /**
     * Gets the pattern to use when routing and generating links
     * @return string The pattern used
     */
    public function getURLPattern();

    /**
     * Registers a class beneath which all child pages will be date-mapped.
     * @param type $className Name of the class to register
     * @param callback|boolean $filter a boolean, callback, or other closure that can be passed instances of the
     * specified class to determine if it should be consitered when filtering
     */
    public function RegisterClass($className, $filter = true);
    
    /**
     * Instructs the module to refresh the routing XML cache file
     * This may not be called during manifest initialisation (_config.php) as database access is not available
     */
    public function RefreshCache();
}