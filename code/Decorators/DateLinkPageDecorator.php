<?php

/**
 * Provides functionality required for date-linked pages to generate urls and to refresh the cache
 * @author Damian Mooyman
 */
class DateLinkPageDecorator extends SiteTreeDecorator
{

    public function onAfterWrite()
    {
        // Hook into page writes to refresh the cache
        DateLink::refresh_cache();
    }

    /**
     * Using the same rules that were used to generate the routing table, attempt to generate the original matching
     * url that corresponds to the current page
     * @param string|null $action The requested page action
     * @return string the relative page url
     */
    public function DatedRelativeLink($action = null)
    {
        // Fixes the "please use full link" hack that ContentController::link uses to request full parent controller links.
        if ($action === true)
            $action = null;

        $parentLink = $this->owner->Parent()->RelativeLink();
        $urlSegment = $this->owner->URLSegment;
        
        // Determine raw date
        $fieldName = DateLink::get_date_field();
        $dateValue = $this->owner->$fieldName;

        // Handles the outlying case where this page has no date set, in which case we revert to a quick 
        // implementation of the traditional RelativeLink function
        if (!$dateValue)
            return Controller::join_links($parentLink, $urlSegment, '/', $action);
        $date = new DateTime($dateValue);
        
        // Get pattern to use as a base for this link
        $pattern = DateLink::get_url_pattern();

        // Substitute parent link
        $parentLink = trim($parentLink, "/");
        $pattern = preg_replace('/\$ParentLink!?/i', $parentLink, $pattern);

        // Substitute parent segment
        $pattern = preg_replace('/\$URLSegment!?/i', $urlSegment, $pattern);
        
        // Mapping of wildcards to date formats (in order of replacement)
        $replacements = array(
            '#$Month' => 'm',
            '$MonthName' => 'F',
            '$Month' => 'n',
            '#$Date' => 'd',
            '$Date' => 'j',
            '$Year' => 'Y',
            '$Weekday' => 'l'
        );

        // Extract various date elements
        foreach ($replacements as $search => $dateFormat)
        {
            $dateText = $date->format($dateFormat);
            $quotedSearch = preg_quote($search);
            $pattern = preg_replace("/$quotedSearch!?/i", $dateText, $pattern);
        }
        
        // Replace everything after the // with /$action
        return preg_replace('/\/\/.*$/', "/$action", $pattern);
    }

}