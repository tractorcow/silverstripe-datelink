# datelink module for Silverstripe

This module allows you to create dated urls, that is, links that have the year and month preceeding the url segment.

This is useful if you want your blog posts, or other date-specific sections of the website, to indicate when they
were posted. This follows the same style as wordpress, and other blog applications.

For instance, if you had a blog with urls like

http://www.mysite.com/blog/heres-an-awesome-post

You could turn these links into:

http://www.mysite.com/blog/2012/2/heres-an-awesome-post

## Credits and Authors

 * Damian Mooyman - <https://github.com/tractorcow/silverstripe-datelink>

## Requirements

 * SilverStripe 2.4.7, may work on lower versions
 * PHP 5.2

## Installation Instructions

 * Extract all files into the 'datelink' folder under your Silverstripe root.
 * Ensure that the assets folder is properly writable. This module will save an xml file under assets/_datelink and will need write permissions

### Settings in _config.php

 * Unless you wish items to be dated against the 'Created' database field you will need to explicitly define which property to use.
   For instance, to instruct the module to use the 'Date' field you would use the following:

```php
DateLink::set_date_field('Date');
```

 * To apply date url styles to any class you will need to register the class type of its parent. For instance, if you wish 
   to apply these links to the BlogPost class you will need to register the BlogHolder class.

```php
DateLink::register_class('BlogHolder');
```

 * Once you have setup your _config.php settings you should do a /dev/build. This will regenerate the Routing.xml cache file
   that is required for ongoing routing requests.

The reason for using a cached XML file for storing routing patterns is that database access is not available before
routes are initialised. All required parent pages and years are extracted during dev/build to create distinct patterns
that silverstripe can use during routing, to prevent clashes between it and the default page routing. These routes are
then simply read from the XML file and set in the routing table each page load.

### Code changes to Page.php

 * To tell pages to use the new date url scheme you will need to override the RelativeLink() function in your Page class

```php
public function RelativeLink($action = null)
{
    return $this->DatedRelativeLink($action);
}
```

 * If you are using a blog module and don't wish to edit the core blog files you can still do this via the Page class

```php
public function RelativeLink($action = null)
{
    if ($this->ClassName == 'BlogEntry')
        return $this->DatedRelativeLink($action);

    return parent::RelativeLink($action);
}
```

### Customising the URL structure

You can customise the URL layout using constants, year, month (name/number), day of the month, and even day of the
week using DateLink::set_url_pattern('pattern');

Please check the in-code documentation at /code/DateLink.php#L17 for the actual pattern syntax.

## License

Copyright (c) 2013, Damian Mooyman
All rights reserved.

All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

 * Redistributions of source code must retain the above copyright
   notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright
   notice, this list of conditions and the following disclaimer in the
   documentation and/or other materials provided with the distribution.
 * The name of Damian Mooyman may not be used to endorse or promote products
   derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
