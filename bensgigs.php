<?php
/*
 Plugin Name: Ben's Gigs
 Plugin URI: http://www.benallfree.com/bensgigs
 Description: All the gigs worth having, delivered directly to your WordPress site.
 Author: Ben Allfree
 Version: 1.0.3
 Author URI: http://www.benallfree.com
 Text Domain: feeds
 License: GPL
 Copyright 2011  Launchpoint Software Inc., (email ben@launchpointsoftware.com)
 */
 
add_action('click', 'bensgigs_click');

function bensgigs_click()
{
  Click::register(dirname(__FILE__));
}
/*


$plugin_fpath = dirname(__FILE__);
$lib = 'clicklib/click.php';
if(file_exists($plugin_fpath."/$lib")) require($lib); else require($plugin_fpath."/../$lib");


$modules = array(
  'clicklib.activerecord',
  'clicklib.attachment',
  'clicklib.cron',
  'clicklib.haml',
  'clicklib.magick_images',
);
foreach($modules as $module_name)
{
  $start = microtime(true);
  Click::load($module_name);
  $end = microtime(true);
  $time = $end - $start;
}
*/