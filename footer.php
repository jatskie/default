<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Howes
 * @since Howes 1.0
 */
 global $howes;
 
$footerContainer = 'container';
if( $howes['layout']=='fullwide' ){
	if( isset($howes['full_wide_elements']['footer']) && $howes['full_wide_elements']['footer']=='1' )
	$footerContainer = 'container-full';
}
 
?>
<?php /*if( !is_page() ){
		echo '</div>';
	}*/ ?>
				
		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
        	<div class="footer footer-text-color-<?php echo sanitize_html_class($howes['footerwidget_color']); ?>">
			<?php /* ?>
			<div class="footersocialicon">
				<div class="container">
					<div class="row">
						<div class="col-xs-12"><?php echo thememount_get_social_links(); ?></div>
					</div>                
				</div>                
			</div>
			<?php */ ?>
				<div class="<?php echo $footerContainer; ?>">
					<div class="row">
						<?php get_sidebar( 'footer' ); ?>
					</div>
				</div>
            </div>
			<div class="site-info footer-info-text-color-<?php echo $howes['footertext_color']; ?>">
                <div class="container">
					<div class="row">
                      <div class="col-xs-12 thememount_footer_menu">
							<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'footer-nav-menu', 'container' => false ) ); ?>
					  </div><!--.footer menu -->
						<div class="col-xs-12 copyright">
							<span class="thememount_footer_text"><?php global $howes; echo do_shortcode($howes['copyrights']); ?></span> 
						</div><!--.copyright -->
                    </div><!--.row -->
				</div><!-- .site-info -->
			</div><!-- .container -->
		</footer><!-- #colophon -->
	</div><!-- #page -->
	
	</div><!-- .main-holder.animsition -->

    <a id="totop" href="#top" style="display: inline;"><i class="tmicon-fa-angle-up"></i></a>
    
	<?php
	if( isset($howes['custom_js_code']) && trim($howes['custom_js_code'])!='' ){
		echo '<script type="text/javascript"> /* Custom JS Code */ '.$howes['custom_js_code'].'</script>';
	}
	?>
	
	<?php
		$pagename = get_query_var('pagename');
		// change to proper permalinks
		if("profile" == trim($pagename) || "members-directory" == trim($pagename))
		{	
			include_once('satara/new-payin-modal.php');
			include_once('satara/new-claim-modal.php');
		}
	?>
	
	<?php wp_footer(); ?>
	
</body>
</html>
