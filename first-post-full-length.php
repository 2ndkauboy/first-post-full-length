<?php
/*
 * Plugin Name: First Post Full Length
 * Description: Show the first post in full length if it has a more tag and the excerpt for the other posts
 * Version: 1.0.0
 * Author: Bernhard Kau
 * Author URI: http://kau-boys.de
 * Plugin URI: https://github.com/2ndkauboy/first-post-full-length
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
*/

add_action( 'loop_start', 'first_post_full_length_enable' );

/**
 * @param WP_Query $query
 */
function first_post_full_length_enable( $query ) {

	if ( ! is_admin() && $query->is_main_query() && ! $query->is_feed() ) {
		// set is_feed to true, so that the post content will be used in full length
		$query->is_feed = true;
		// add a filter that sets is_feed to false again, as soon as the content from the first post was set
		add_filter( 'the_post', 'first_post_full_length_disable' );
	}
}

function first_post_full_length_disable( $args = array() ) {
	global $wp_the_query;

	if ( ! is_admin() && $wp_the_query->is_main_query() ) {
		$wp_the_query->is_feed = false;
		remove_filter( 'the_post', 'first_post_full_length_disable' );
	}
}