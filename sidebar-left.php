<?php
/**
 * The sidebar containing the sidebar 1.
 *
 */

global $wp_registered_sidebars;
global $howes;

$no_widget_title      = __('No Widget Found', 'howes');
$no_widget_desc_text  = __( 'We don\'t find any widget to show. Please add some widgets by going to <strong>Admin > Appearance > Widgets</strong> and add widgets in <strong>"%s"</strong> area.', 'howes' );


?>

<?php
if( is_page() ){
	?>
	
	<?php
	$sidebar1      = 'sidebar-left-page';
	$sidebar1_page = get_post_meta($post->ID,'_thememount_page_options_leftsidebar',true);
	if( trim($sidebar1_page)!='' ){ $sidebar1 = trim($sidebar1_page); }
	
	// Language translation
	$no_widget_desc  = sprintf( $no_widget_desc_text, $wp_registered_sidebars[$sidebar1]['name'] );
	
	?>

	<aside id="sidebar-left" class="widget-area col-md-3 col-lg-3 col-xs-12 sidebar" role="complementary">
		<?php //dynamic_sidebar( $sidebar1 ); ?>
		<?php if ( ! dynamic_sidebar( $sidebar1 ) ) : ?>

			<div class="thememount-centertext">
				<h3><?php echo $no_widget_title; ?></h3>
				<br />
				<p><?php echo $no_widget_desc; ?></p>
				
			</div>

		<?php endif; // end sidebar widget area ?>
		
	</aside><!-- #sidebar-left -->
		
	<?php
} elseif( is_search() ) {
	$no_widget_desc  = sprintf( $no_widget_desc_text, $wp_registered_sidebars['sidebar-left-search']['name'] );
	
	?>
	<aside id="sidebar-left" class="widget-area col-md-3 col-lg-3 col-xs-12 sidebar" role="complementary">
		<?php if ( ! dynamic_sidebar( 'sidebar-left-search' ) ) : ?>

			<div class="thememount-centertext">
				<h3><?php echo $no_widget_title; ?></h3>
				<br />
				<p><?php echo $no_widget_desc; ?></p>

			</div>

		<?php endif; // end sidebar widget area ?>

	</aside><!-- #sidebar-left -->


	
	<?php
} elseif( function_exists('is_bbpress') && is_bbpress() ) {
	$bbpressSidebar = isset($howes['sidebar_bbpress']) ? $howes['sidebar_bbpress'] : 'right' ;
	?>
	
	<?php if( $bbpressSidebar=='left' ): ?>
	
		<aside id="sidebar-left" class="widget-area col-md-3 col-lg-3 col-xs-12 sidebar bbpress-sidebar" role="complementary">
			<?php if ( ! dynamic_sidebar( 'sidebar-bbpress' ) ) : ?>

				<div class="thememount-centertext">
					<h3><?php echo $no_widget_title; ?></h3>
					<br />
					<p><?php echo $no_widget_desc; ?></p>
					
				</div>

			<?php endif; // end sidebar widget area ?>
			
		</aside><!-- #sidebar-left -->
		
	<?php endif; ?>
	
	

	<?php
} else {
	$no_widget_desc  = sprintf( $no_widget_desc_text, $wp_registered_sidebars['sidebar-left-blog']['name'] );
	?>
	<aside id="sidebar-left" class="widget-area col-md-3 col-lg-3 col-xs-12 sidebar" role="complementary">
		<?php if ( ! dynamic_sidebar( 'sidebar-left-blog' ) ) : ?>

			<div class="thememount-centertext">
				<h3><?php echo $no_widget_title; ?></h3>
				<br />
				<p><?php echo $no_widget_desc; ?></p>
				
			</div>

		<?php endif; // end sidebar widget area ?>
		
	</aside><!-- #sidebar-left -->
	
	<?php
}
