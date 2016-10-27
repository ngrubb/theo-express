<?php
/**
 * Boostrap File
 * File is used only to load in the necessary files for the theme
 * There shouldn't be any functions added in here
 *
 * Also please keep in mind that only presentation functionality
 * should be added inside the theme. Any additional functionality
 * posttypes, taxonomies, etc should be added as plugins to allow
 * the theme to be changed without affecting content.
 */


// Remove unnecessary items from head
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );


// Grab path for includes
$theme_path = get_stylesheet_directory();


/**
 * Include the theme support file
 * Contains logic for setting up theme support items
 */

include_once $theme_path . '/inc/theme/support.php';


/**
 * Include the theme widgets file
 * Contains the custom widgets
 */

include_once $theme_path . '/inc/theme/widgets.php';


/**
 * Include the theme assets file
 * Contains logic for enqueueing styles and scripts
 */

include_once $theme_path . '/inc/theme/assets.php';


/**
 * Include any additional files.
 * The following folders are already setup:
 *  - classes - holds any files that is a class in itself
 *  - helpers - holds files that are grouped common functions
 */





