<?php

/**
 * Date linking module for silverstripe
 * 
 * Allows you to turn child pages of any page type into "date" named urls.
 * Eg http://www.myblog.co.nz/blog/2010/02/my-blog-post
 * 
 * To use, you will need to add the following code to your _config.php
 * 
 * 
 * DateLink::set_date_field('Date');
 * DateLink::register_class('BlogHolder'); 
 * 
 * 
 * The first function call sets the field the module should use to retrieve the date. By default this will use the
 * 'Created' field name.
 * 
 * The second function specifies the class name of the PARENT page within which you wish to add dated pages. This is
 * to ensure that all child pages are handled consistently.
 * 
 * Finally, you MUST override the RelativeLink() function in the child page class. If you are adding this code to the blog
 * module then you can add some custom logic to your Page class that returns the correct link.
 * 
 * Sample RelativeLink() implementations are below:
 * 
 * 
 *   public function RelativeLink($action = null)
 *   {
 *       if($this->ClassName == 'BlogEntry')
 *           return $this->DatedRelativeLink($action);
 *       else
 *           return parent::RelativeLink($action);
 *   }
 * 
 * or
 * 
 *   public function RelativeLink($action = null)
 *   {
 *       return $this->DatedRelativeLink($action);
 *   }
 * 
 */