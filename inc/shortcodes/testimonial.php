<?php
// [testimonial]
if( !function_exists('thememount_sc_testimonial') ){
function thememount_sc_testimonial($atts, $content=NULL ) {
	extract( shortcode_atts( array(
		'title'    => '',
		'subtitle' => '',
		'align'    => 'left',
		'show'     => '3',
		'column'   => 'three',
		'view'     => '',
		'group'    => '',
	), $atts ) );
	
	// Box width
	$boxwidth       = ( $view == 'carousel' ) ? 'fix' : $column ;
	$rowClass       = ( $view != 'carousel' ) ? 'row' : '' ;
	$headerCarslBtn = ( $view == 'carousel' ) ? 'carouselbtn="yes"' : '' ;
	$itemWrapper    = ( $view == 'carousel' ) ? 'thememount-carousel-items-wrapper' : '' ;
	$itemCol        = ( $view == 'carousel' ) ? 'thememount-carousel-col-'.$column : '' ;
	$rowClass       = ( $view == 'carousel' ) ? $rowClass : $rowClass.' multi-columns-row' ;
	
	
	$carouselControls = '<div class="thememount-carousel-controls">
							<div class="thememount-carousel-controls-inner">
								<a href="javascript:void(0)" class="thememount-carousel-prev"><span class="wpb_button"><i class="tmicon-fa-angle-left"></i></span></a>
								<a href="javascript:void(0)" class="thememount-carousel-next"><span class="wpb_button"><i class="tmicon-fa-angle-right"></i></span></a>
							</div>
						</div>';
	
	
	
	$return = '';
	//$width  = thememount_translateColumnWidthToSpan($column);
	
	$args = array(
		'post_type'      => 'testimonial',
		'posts_per_page' => $show,
	);
	
		// Group
	if( $group!='' ){
		$args['tax_query'] = array(
								array(
									'taxonomy' => 'testimonial_group',
									'field' => 'slug',
									'terms' => $group
								),
							);
	}
	
	
	$results = new WP_Query( $args );
	
	// The Loop
	if ( $results->have_posts() ) {
		$return .= "\n\t".'<div class="thememount-testimonial-wrapper thememount-effect-'.$view.' thememount-items-col-'.$column.' '.$itemCol.'">';
		if( trim($title)!='' ){
			$return .= "\n\t" . do_shortcode('[heading text="'.esc_attr($title).'" subtext="'.esc_attr(do_shortcode($subtitle)).'" tag="h2" '.$headerCarslBtn.' style="linedot" align="'.$align.'"]');
		}
		
		// Carousel Buttons
		//if( $view == 'carousel' ){ $return .= $carouselControls; }
		
		
		$return .= '<div class="'.$rowClass.' thememount-items-wrapper '.$itemWrapper.'">';
		
		while ( $results->have_posts() ) {
			$results->the_post();
			
			$return .= thememount_testimonialbox( $boxwidth );
			
		}
		$return .= "\n\t".'</div></div>';
	} else {
		// no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata();
	
	return $return;
}
}
add_shortcode( 'testimonial', 'thememount_sc_testimonial' );