<?php
/**
 * Template Name: Login
 *
 * This is the template that displays New Pay In form
 *
 * @package WordPress
 * @subpackage Howes
 * @since Howes 1.0
 */
get_header();

while (have_posts() ) : 
	the_post();
	the_content();
endwhile; 

get_footer();
?>