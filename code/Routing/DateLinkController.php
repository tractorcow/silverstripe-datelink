<?php

/**
 * Handles urls that match dated link routes
 * 
 * @package datelink
 * @author Damian Mooyman
 * @see ModelAsController
 */
class DateLinkController extends ModelAsController {

	/**
	 * Finds the controller for this page under the given parent id
	 */
	public function getNestedController() {
		
		// Extract values stored in route
		$parentID = $this->request->param('ParentID');
		$URLSegment = $this->request->param('URLSegment');

		// get child page
		$sitetree = SiteTree::get()
			->filter(array(
				"URLSegment" => $URLSegment,
				"ParentID" => $parentID
			))->first();
		
		if( true !== $sitetree instanceof SiteTree ){
		    ErrorPage::response_for(404);
        	}

		return self::controller_for($sitetree, $this->request->param('Action'));
	}

}
