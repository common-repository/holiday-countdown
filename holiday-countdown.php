<?php
/*
Plugin Name: Holiday Countdown
Description: Excited for an upcoming holiday? Use this plugin to create a widget on your WordPress site that displays a holiday countdown timer.
Version: 1.3.0
Author: Aaron Russell
Author URI: http://www.theaaronrussellblog.wordpress.com/
License GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: holiday-countdown
*/

// Make sure this file isn't called directly
if ( !function_exists( 'add_action' ) )
  die( 'Nothing to see here! Move along...' );

// Include the widget
require_once 'class.holiday-countdown-widget.php';

// Add front-end JavaScript stuff
add_action( 'wp_enqueue_scripts', function() {
  wp_enqueue_script( 'timer_manager', plugin_dir_url( __FILE__ ) . 'includes/timer_manager.js' );
} );

// Add back-end JavaScript stuff
add_action( 'admin_enqueue_scripts', function() {
  wp_enqueue_script( 'custom_holiday_form', plugin_dir_url( __FILE__ ) . 'includes/custom_holiday_form.js' );
} );

// Add documentation menu in back-end
add_action( 'admin_menu', function() {
  add_menu_page( 'Holiday Countdown Guide', 'Holiday Countdown Guide', 'read', 'holiday-countdown-guide', 'holiday_documentation_menu' );
} );

function holiday_documentation_menu() {
  require_once 'includes/guide.php';
}
?>
