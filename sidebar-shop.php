<?php
/**
 * The sidebar containing the sidebar 2.
 *
 */

global $wp_registered_sidebars;

global $howes;
$sidebar_woocommerce = 'right';
if( isset($howes['sidebar_woocommerce']) && trim($howes['sidebar_woocommerce'])!='' ){
	$sidebar_woocommerce = $howes['sidebar_woocommerce'];
}

$no_widget_title      = __('No Widget Found', 'howes');
$no_widget_desc_text  = __( 'We don\'t find any widget to show. Please add some widgets by going to <strong>Admin > Appearance > Widgets</strong> and add widgets in <strong>"%s"</strong> area.', 'howes' );

?>

<?php $no_widget_desc  = sprintf( $no_widget_desc_text, $wp_registered_sidebars['sidebar-woocommerce']['name'] ); ?>

<aside id="sidebar-<?php echo $sidebar_woocommerce; ?>" class="widget-area col-md-3 col-lg-3 col-sm-4 col-xs-12 sidebar" role="complementary">
	<?php if ( ! dynamic_sidebar( 'sidebar-woocommerce' ) ) : ?>

		<div class="thememount-centertext">
			<h3><?php echo $no_widget_title; ?></h3>
			<br />
			<p><?php echo $no_widget_desc; ?></p>
			
		</div>

	<?php endif; // end sidebar widget area ?>
	
</aside><!-- #sidebar-right -->
	
	
