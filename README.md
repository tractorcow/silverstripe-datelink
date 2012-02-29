# datelink module for Silverstripe

This module allows you to create dated urls, that is, links that have the year and month preceeding the url segment.

This is useful if you want your blog posts, or other date-specific sections of the website, to indicate when they
were posted. This follows the same style as wordpress, and other blog applications.

For instance, if you had a blog with urls like

http://www.mysite.com/blog/heres-an-awesome-post

You could turn these links into:

http://www.mysite.com/blog/2012/01/heres-an-awesome-post

## Credits and Authors

 * Damian Mooyman - <https://github.com/tractorcow/silverstripe-datelink>

## Requirements

 * SilverStripe 2.4.7, may work on lower versions or 3.0
 * PHP 5.2

## Installation Instructions

 * Extract all files into the 'datelink' folder under your Silverstripe root.
 * Ensure that the assets folder is properly writable. This module will save an xml file under assets/_datelink and will need write permissions

### Settings in _config.php

 * Unless you wish items to be dated against the 'Created' database field you will need to explicitly define which property to use.
   For instance, to instruct the module to use the 'Date' field you would use the following:

    DateLink::set_date_field('Date');

 * To apply date url styles to any class you will need to register the class type of its parent. For instance, if you wish 
   to apply these links to the BlogPost class you will need to register the BlogHolder class.

    DateLink::register_class('BlogHolder');

 * Once you have setup your _config.php settings you should do a /dev/build. This will regenerate the Routing.xml cache file
   that is required for ongoing routing requests.
 ** The reason for using a cached XML file for storing routing patterns is that database access is not available before
    routes are initialised. All required parent pages and years are extracted during dev/build to create distinct patterns
    that silverstripe can use during routing, to prevent clashes between it and the default page routing. These routes are
    then simply read from the XML file and set in the routing table each page load.

### Code changes to Page.php

 * To tell pages to use the new date url scheme you will need to override the RelativeLink() function in your class

    public function RelativeLink($action = null)
    {
        return $this->DatedRelativeLink($action);
    }

 * If you are using a blog module and don't wish to edit the core blog files you can still do this via the Page class

    public function RelativeLink($action = null)
    {
        if ($this->ClassName == 'BlogEntry')
            return $this->DatedRelativeLink($action);
        
        return parent::RelativeLink($action);
    }