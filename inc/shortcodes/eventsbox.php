<?php
// [eventsbox]
if( !function_exists('thememount_sc_eventsbox') ){
function thememount_sc_eventsbox( $atts, $content=NULL ){
	extract( shortcode_atts( array(
		//'textposition' => 'left',
		'title'        => '',
		'subtitle'     => '',
		'align'        => 'left',
		'sortable'     => '',
		//'sepicon'      => 'NO_ICON',
		'btntext'      => '',
		'btnlink'      => '',
		'show'         => '',
		'column'       => '',
		'view'         => '',
		'pagination'   => 'no',
	), $atts ) );
	
	global $wp_query;
	$old_wp_query = $wp_query;
	
	// Box width
	$boxwidth       = ( $view == 'carousel' ) ? 'fix' : $column ;
	$headerCarslBtn = ( $view == 'carousel' ) ? 'carouselbtn="yes"' : '' ;
	$itemWrapper    = ( $view == 'carousel' ) ? 'thememount-carousel-items-wrapper' : '' ;
	$itemCol        = ( $view == 'carousel' ) ? 'thememount-carousel-col-'.$column : '' ;
	$rowFix         = ( $view == 'carousel' ) ? '' : 'multi-columns-row' ;
	
	$rand = mt_rand(1000, 9999);
	$rand .= mt_rand(1000, 9999);
	
	/*$carouselControls = '<div class="thememount-carousel-controls">
							<div class="thememount-carousel-controls-inner">
								<a class="thememount-carousel-prev"><span class="wpb_button"><i class="tmicon-fa-angle-left"></i></span></a>
								<a class="thememount-carousel-slideshow"><span class="wpb_button"><i class="tmicon-fa-pause"></i></span></a>
								<a title="Play Slideshow" class="thememount-carousel-next"><span class="wpb_button"><i class="tmicon-fa-angle-right"></i></span></a>
							</div>
						</div>';*/
	
	// Generating Button Code
	$btnCode = '';
	if( trim($btntext)!='' && trim($btnlink)!='' ){
		$btnCode = '<div class="thememount-pf-btn thememount-center">' . do_shortcode('[vc_button title="'.$btntext.'" target="_self" color="skincolor" size="wpb_regularsize" href="'.$btnlink.'" btn_effect="colortoborder" showicon="withouticon" iconposition="left"]') . '</div>';
	}
	
	
	$return = '<div class="row '.$rowFix.' thememount-portfolio-boxes-wrapper thememount-portfolio-view-'.$view.' thememount-effect-'.$view.' thememount-items-col-'.$column.' '.$itemCol.'" id="thememount-portfolio-id-'.$rand.'">';
		
		$portfolioWrapperStart = '<div class="thememount-portfolio-boxes col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		$portfolioWrapperEnd   = '</div>';
		$contentWrapperStart = '<div class="thememount-portfolio-text col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		$contentWrapperEnd   = '</div>';
		
		/*if( $textposition=='left' ){
			$portfolioWrapperStart = '<div class="thememount-portfolio-boxes col-xs-12 col-sm-9 col-md-9 col-lg-9">';
			$portfolioWrapperEnd   = '</div>';
			$contentWrapperStart = '<div class="thememount-portfolio-text col-xs-12 col-sm-12 col-md-3 col-lg-3">';
			$contentWrapperEnd   = '</div>';
		}*/
		
		$return .= $contentWrapperStart;
			if( trim($title)!='' ) {
				// Title and Subtitle
				$return .= do_shortcode('[heading text="'.$title.'" tag="h2" '.$headerCarslBtn.' style="linedot" align="'.$align.'" subtext="'.$subtitle.'"]');
			}
			
			// Carousel Buttons
			//if( $view == 'carousel' ){ $return .= $carouselControls; }
			
		$return .= $contentWrapperEnd;
		
		//Protect against arbitrary paged values
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		
		$args = array(
			'post_type'      => 'tribe_events',
			//'post_type'    => TribeEvents::POSTTYPE,
			'order'          => 'ASC',
			'meta_key'       => '_EventStartDate',
			'meta_type'      => 'DATE',
			'orderby'        => 'meta_value',
			'posts_per_page' => $show,
		);
		$wp_query = new WP_Query( $args );
		
		
		// The Loop
		if ( $wp_query->have_posts() ) {
		
			$return          .= $portfolioWrapperStart;
			
			$pagination_class = ( $pagination=='yes' ) ? ' thememount-with-pagination' : '' ; // Pagination
			$portfolioBoxes   = '<div class="thememount-items-wrapper '.$itemWrapper.' thememount-portfolio-boxes-inner portfolio-wrapper row'.$pagination_class.'">';
			
			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();
				$portfolioBoxes .= thememount_eventsbox( $boxwidth );
			} // while
			
			$portfolioBoxes .= '</div>';

			$return .= $portfolioBoxes;  // Portfolio Boxes
			if( $pagination=='yes' ){ $return .= howes_paging_nav(true); }  // Pagination
			$return .= $btnCode;  // Button
			
			$return .= $portfolioWrapperEnd;
		} // if
		
		/* Restore original Post Data */
		wp_reset_postdata();
		
		$wp_query = $old_wp_query;
		
	$return .= '</div>';
	
	return $return;
}
}
add_shortcode( 'eventsbox', 'thememount_sc_eventsbox' );