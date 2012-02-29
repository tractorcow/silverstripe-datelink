<?php

/**
 * Allows the date link cache to update during dev/build
 * @author Damian Mooyman
 */
class DateLinkHolderDecorator extends SiteTreeDecorator
{
    public function requireDefaultRecords()
    {
        // Hook into dev/build task here to refresh the xml routing cache
        DateLink::refresh_cache();
    }
}