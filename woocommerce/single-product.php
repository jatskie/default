<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
<div class="container">
  <div class="row"><div id="primary" class="content-area col-md-9 col-lg-9 col-xs-12">
    
    <?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
    
    <?php while ( have_posts() ) : the_post(); ?>
    
    <?php wc_get_template_part( 'content', 'single-product' ); ?>
    
    <?php endwhile; // end of the loop. ?>
    
    <?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
    
    </div><!-- .col-md-9 col-lg-9 col-sm-8 col-xs-12 -->
    
    <?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>
    
  </div>
</div>
<!-- .row -->

<?php get_footer( 'shop' ); ?>