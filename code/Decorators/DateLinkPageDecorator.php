<?php

/**
 * Description of DateLinkPageDecorator
 *
 * @author Damo
 */
class DateLinkPageDecorator extends SiteTreeDecorator
{

    public function onAfterWrite()
    {
        // Hook into page writes to refresh the cache
        DateLink::refresh_cache();
    }

    public function DatedRelativeLink($action = null)
    {
        $parentLink = $this->owner->Parent()->RelativeLink();
        $URLSegment = $this->owner->URLSegment;
        $date = $this->owner->getField(DateLink::get_date_field());
        
        // Fixes the "please use full link" hack that ContentController::link uses to request full page links.
        if($action === true)
            $action = null;

        if (!$date)
            return Controller::join_links($parentLink, $URLSegment, '/',  $action);

        // Merge all elements together
        $parsedDate = date_parse($date);
        $year = $parsedDate['year'];
        $month = $parsedDate['month'];
        return Controller::join_links($parentLink, $year, $month, $URLSegment, '/', $action);
    }

}