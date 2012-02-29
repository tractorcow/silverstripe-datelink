<?php

/**
 * Decorates the holder page of any dated-linked page
 *
 * @author Damo
 */
class DateLinkHolderDecorator extends SiteTreeDecorator
{
    public function requireDefaultRecords()
    {
        // Hook into dev/build task here to refresh the xml routing cache
        DateLink::refresh_cache();
    }
}