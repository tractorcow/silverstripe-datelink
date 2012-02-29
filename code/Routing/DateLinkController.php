<?php

/**
 * Handles urls that match dated link routes
 * @author Damian Mooyman
 * @see ModelAsController
 */
class DateLinkController extends ModelAsController
{
    /**
     * Finds the controller for this page under the given parent id
     */
    public function getNestedController()
    {
        // For some reason using the non-deprecated methods did not work.
        // @todo Once SS3.0 find working non-deprecated functionality to insert here
        $parentID = Director::urlParam('ParentID');
        $URLSegment = Director::urlParam('URLSegment');

        // get child page
        $sitetree = DataObject::get_one('Page',
                        sprintf(
                                "`SiteTree`.`URLSegment` = '%s' AND `SiteTree`.`ParentID` = %d",
                                Convert::raw2sql($URLSegment), $parentID
                        ));

        return self::controller_for($sitetree, $this->request->param('Action'));
    }

}