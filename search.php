<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Howes
 * @since Howes 1.0
 */

get_header();

global $howes;
$sidebar         = $howes['sidebar_search']; // Global settings

// Primary Content class
$primaryclass = setPrimaryClass($sidebar);

?>

<div class="container">
	<div class="row">

		<div id="primary" class="content-area <?php echo $primaryclass; ?>">
			<div id="content" class="site-content" role="main">
			
			<?php if( get_query_var('post_type')=='team_member' && trim(get_query_var('s'))!='' ): ?>
				<div class="thememount-content-team-search-box">
					<?php echo thememount_team_search_form(); ?>
				</div>
			<?php endif; ?>
			
			<?php if ( have_posts() ) : ?>

				<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php if(get_post_type() == 'team_member' ): ?>
						<?php get_template_part( 'content', 'teammember' ); ?>
					<?php else: ?>
						<?php
						if( isset($howes['blog_view']) && trim($howes['blog_view'])!='' && trim($howes['blog_view'])!='classic' ) {
							echo thememount_blogbox($howes['blog_view']);
						} else {
							get_template_part( 'content', get_post_format() );
						}
						?>
					<?php endif; ?>
				<?php endwhile; ?>

				<?php howes_paging_nav(); ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

		<?php
		// Sidebar 1 (Left Sidebar)
		if($sidebar=='left' || $sidebar=='both' || $sidebar=='bothleft' || $sidebar=='bothright' ){
			get_sidebar('left');
		}

		// Sidebar 2 (Right Sidebar)
		if($sidebar=='right' || $sidebar=='both' || $sidebar=='bothleft' || $sidebar=='bothright' ){
			get_sidebar('right');
		}
		?>
		
	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>