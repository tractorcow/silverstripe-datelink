<?php

/**
 * Provides functionality required for date-linked pages to generate urls and to refresh the cache
 * 
 * @package datelink
 * @author Damian Mooyman
 */
class DateLinkExtension extends SiteTreeExtension {
	
	public function MetaTags(&$tags) {
		$tags .= $this->owner->renderWith('DateLinkExtension_MetaTags');
	}
	
	/**
	 * Determine if this page should have date links enabled
	 * 
	 * @return boolean
	 */
	protected function dateEnabled() {
		
		// Root pages can't be dated
		if(empty($this->owner->ParentID)) return false;
		
		// If class filter is given, then filter explicitly by this list.
		$childClasses = DateLink::config()->child_classes;
		if($childClasses) {
			foreach($childClasses as $class) {
				if($this->owner instanceof $class) return true;
			}
			return false;
		}
		
		// Ensure that the parent explicitly exists
		$parent = $this->owner->Parent();
		if(empty($parent) || !$parent->exists()) return false;
		
		// If there's no child class filter, revert to checking parent class filter.
		$parentClasses = DateLink::config()->holder_classes;
		if($parentClasses) foreach($parentClasses as $allowedClass) {
			if($parent instanceof $allowedClass) return true;
		}
		
		return false;
	}

	public function onAfterWrite() {
		if($this->dateEnabled()) {
			// Hook into page writes to refresh the cache
			DateLink::refresh_cache();
		}
	}
	
	/**
	 * Retrieves the date value to use for this page.
	 * Defaults to the value specified by the config DateLink.default_date_field
	 * 
	 * @return string Date in ISO 8601 format
	 */
	public function getRouteDate() {
		$field = DateLink::config()->default_date_field;
		return $this->owner->$field;
	}

	/**
	 * Using the same rules that were used to generate the routing table, attempt to generate the original matching
	 * url that corresponds to the current page
	 * 
	 * @param string &$base The URL of this page relative to siteroot, not including
	 * the action
	 * @param string|boolean &$action The action or subpage called on this page.
	 * (Legacy support) If this is true, then do not reduce the 'home' urlsegment
	 * to an empty link
	 */
	public function updateRelativeLink(&$base, &$action) {
		
		// Avoid rewriting urls for pages not to be rewritten
		if(!$this->dateEnabled()) return;

		// Determine raw date
		$dateValue = $this->owner->getRouteDate();
		if(empty($dateValue)) return;
		$date = new DateTime($dateValue);

		// Get pattern to use as a base for this link
		$pattern = DateLink::config()->url_pattern;

		// Substitute parent link
		$parentLink = trim($this->owner->Parent()->RelativeLink());
		$pattern = preg_replace('/\$ParentLink!?/i', trim($parentLink, '/'), $pattern);

		// Substitute parent segment
		$pattern = preg_replace('/\$URLSegment!?/i', $this->owner->URLSegment, $pattern);

		// Mapping of wildcards to date formats (in order of replacement)
		$dateReplacements = array(
			'#$Month' => 'm',
			'$MonthName' => 'F',
			'$Month' => 'n',
			'#$Date' => 'd',
			'$Date' => 'j',
			'$Year' => 'Y',
			'$Weekday' => 'l'
		);

		// Extract various date elements
		foreach ($dateReplacements as $search => $dateFormat) {
			$dateText = $date->format($dateFormat);
			$quotedSearch = preg_quote($search);
			$pattern = preg_replace("/$quotedSearch!?/i", $dateText, $pattern);
		}

		// Replace everything after the // with /$action
        if ($action === true)  $action = '';
		$base = preg_replace('/\/\/.*$/', "/$action", $pattern);
	}
	
	/**
	 * Record whether the cache has been regenerated this request
	 *
	 * @var boolean
	 */
	protected static $_cache_refreshed = false;

	public function requireDefaultRecords() {
		
		// Prevent this function being executed excessively each request
		if(self::$_cache_refreshed) return;
		self::$_cache_refreshed = true;
		
		// Hook into dev/build task here to refresh the xml routing cache
		DateLink::refresh_cache();
	}

}
