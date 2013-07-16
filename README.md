# datelink module for Silverstripe

This module allows you to create dated urls, that is, links that have the year and month preceeding the url segment.

This is useful if you want your blog posts, or other date-specific sections of the website, to indicate when they
were posted. This follows the same style as wordpress, and other blog applications.

For instance, if you had a blog with urls like

http://www.mysite.com/blog/heres-an-awesome-post

You could turn these links into:

http://www.mysite.com/blog/2012/2/heres-an-awesome-post

Dated style urls can only be applied to subpages, grouped under common holder pages of a list of specified types.

## Credits and Authors

 * Damian Mooyman - <https://github.com/tractorcow/silverstripe-datelink>

## Requirements

 * SilverStripe 3.1

## Installation Instructions

 * Extract all files into the 'datelink' folder under your Silverstripe root, or install using composer

```bash
composer require "tractorcow/silverstripe-datelink": "3.1.*@dev"
```

 * Ensure that the assets folder is properly writable. This module will save an xml file under assets/_datelink and will
   need write permissions
 * Configure the page options. See the [Configuration](#configuration) section.
 * Run dev/build in order to generate and cache routes.

The reason for using a cached XML file for storing routing patterns is that database access is not available before
routes are initialised. All required parent pages and years are extracted during dev/build to create distinct patterns
that silverstripe can use during routing, to prevent clashes between it and the default page routing. These routes are
then simply read from the XML file and set in the routing table each page load.

### Configuration

See [DateLink.yml](_config/DateLink.yml) for the basic configuration options.

### Class Filter Configuration

To setup date customised links you should configure the class names of each child and parent relations. The only
mandatory property to set is the `DateLink.holder_classes` config property to specify the parent classes of all dated
urls.

```yaml
DateLink:
  holder_classes:
    - 'BlogHolder'
```

By default all children of the specified classes will have dated urls applied to them. In order to further filter out
these classes an additional filter may be applied, the `DateLink.child_classes` config property.

For example, to filter only 'BlogEntry' pages:

```yaml
DateLink:
  child_classes:
    - 'BlogEntry'
```

### URL Configuration

You can customise the URL layout using constants, year, month (name/number), day of the month, and even day of the
week using the configuration property `DateLink.url_pattern`

```yaml
DateLink:
  url_pattern: '$ParentLink!/$Year!/$Month!/$URLSegment!//$Action/$ID/$OtherID'
```

The following pattern placeholders can be used here:
 * $ParentLink! - The parent page URL (mandatory)
 * $URLSegment! - The URLSegment of the current page (mandatory)
 * $Year! - Year (mandatory)
 * $Month! - Month number
 * #$Month! - Month number (leading zeros)
 * $MonthName! - Month name (full name)
 * $Date! - Day of month
 * #$Date! - Day of month (leading zeros)
 * $Weekday! - Day of the week (full name)

All wildcards prior to the '//' must be qualified with a trailing '!'

### Date Configuration

The field which holds the date for each page can be customised by one of two ways:

 * The `DateLink.default_date_field` config option will set the default field. By default this is 'Created'
 * Override the `getRouteDate` function in your Page class to return the date value that should be used for that page.

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
