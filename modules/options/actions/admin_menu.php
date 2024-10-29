<?
add_submenu_page('bensgigs', "Settings", "Settings", 'manage_options', 'bensgigs_settings', array(Click::$event_dispatcher, 'settings'));


