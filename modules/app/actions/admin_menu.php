<?
add_menu_page("Ben's Gigs", "Ben's Gigs", 'manage_options', 'bensgigs', array(Click::$event_dispatcher, 'listing'));
add_submenu_page('bensgigs', "Ben's Gigs", "Gigs", 'manage_options', 'bensgigs', array(Click::$event_dispatcher, 'listing'));
add_submenu_page('bensgigs', "Ben's Gigs", "Followups", 'manage_options', 'followups', array(Click::$event_dispatcher, 'followup'));
add_submenu_page('bensgigs', "Day Pass", "Day Pass", 'manage_options', 'bensgigs_day_pass', array(Click::$event_dispatcher, 'day_pass'));
//  		add_action('bensgigs_change_key', 'bensgigs_change_key');

add_submenu_page('bensgigs', "Emailer", "Emailer", 'manage_options', 'bensgigs_emailer', array(Click::$event_dispatcher, 'email'));
add_submenu_page('bensgigs', "Skills", "Skills", 'manage_options', 'bensgigs_skills_to_skills', array(Click::$event_dispatcher, 'skills_to_skills'));
add_submenu_page('bensgigs', "Fetures", "Features", 'manage_options', 'bensgigs_features_to_skills', array(Click::$event_dispatcher, 'features_to_skills'));
add_submenu_page('bensgigs', "Samples", "Samples", 'manage_options', 'bensgigs_samples_to_skills', array(Click::$event_dispatcher, 'samples_to_skills'));
add_submenu_page('bensgigs', "Refresh", "Refresh", 'manage_options', 'bensgigs_refresh_posts', array(Click::$event_dispatcher, 'refresh'));
