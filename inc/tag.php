<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Patricia
 * @since Patricia 1.0
 */

get_header();

// Checking if Blog page
$primaryclass = 'col-md-12 col-lg-12 col-sm-12 col-xs-12';
global $patricia;
//$patricia = get_option('patricia');
$sidebar = $patricia['sidebar_blog']; // Global settings

// Page settings
if( isset($sidebarposition) && trim($sidebarposition) != '' ){
	$sidebar = $sidebarposition;
}

// Primary Content class
$primaryclass = setPrimaryClass($sidebar);

?>


<div class="row">		
		
	<?php
	// Sidebar 1 (Left Sidebar)
	if($sidebar=='left' || $sidebar=='both' || $sidebar=='bothleft' ){
		get_sidebar('left');
	}
	if($sidebar=='bothleft'){
		get_sidebar('right');
	}
	?>

	<div id="primary" class="content-area <?php echo $primaryclass; ?>">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>
			
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php patricia_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->


	<?php
	// Sidebar 2 (Right Sidebar)
	if($sidebar=='bothright' ){
		get_sidebar('left');
	}
	if($sidebar=='right' || $sidebar=='both' || $sidebar=='bothright' ){
		get_sidebar('right');
	}
	?>
	
</div><!-- .row -->
<?php get_footer(); ?>