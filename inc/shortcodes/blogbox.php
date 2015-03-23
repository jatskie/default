<?php	
// [blogbox]
if( !function_exists('thememount_sc_blogbox') ){
function thememount_sc_blogbox( $atts, $content=NULL ){
	extract( shortcode_atts( array(
		//'showtext'     => '',
		//'textposition' => 'left',
		'title'        => '',
		'subtitle'     => '',
		'align'        => 'left',
		//'sepicon'      => 'NO_ICON',
		'btntext'      => '',
		'btnlink'      => '',
		'category'     => '',
		'show'         => '',
		'column'       => '',
		'view'         => '',
	), $atts ) );
	
	
	// Box width
	$boxwidth       = ( $view == 'carousel' ) ? 'fix' : $column ;
	$rowClass       = ( $view != 'carousel' ) ? 'row' : '' ;
	$headerCarslBtn = ( $view == 'carousel' ) ? 'carouselbtn="yes"' : '' ;
	$itemWrapper    = ( $view == 'carousel' ) ? 'thememount-carousel-items-wrapper' : '' ;
	$itemCol        = ( $view == 'carousel' ) ? 'thememount-carousel-col-'.$column : '' ;
	//$rowClass       = ( $view == 'carousel' ) ? $rowClass : $rowClass.' multi-columns-row' ;
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
		$btnCode = '<div class="thememount-blogbox-btn thememount-center">' . do_shortcode('[vc_button title="'.$btntext.'" target="_self" color="skincolor" size="wpb_regularsize" href="'.$btnlink.'" btn_effect="bordertocolor" showicon="withouticon" iconposition="left"]') . '</div>';
	}
	
	
	$return = '<div class="row thememount-blog-boxes-wrapper thememount-blog-view-'.$view.' thememount-effect-'.$view.' thememount-items-col-'.$column.' '.$itemCol.'" id="thememount-blog-id-'.$rand.'">';
		
		$blogWrapperStart = '<div class="thememount-blog-boxes col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		$blogWrapperEnd   = '</div>';
		$contentWrapperStart = '<div class="thememount-blog-text col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		$contentWrapperEnd   = '</div>';
		
		/*if( $textposition=='left' ){
			$blogWrapperStart = '<div class="thememount-blog-boxes col-xs-12 col-sm-9 col-md-9 col-lg-9">';
			$blogWrapperEnd   = '</div>';
			$contentWrapperStart = '<div class="thememount-blog-text col-xs-12 col-sm-12 col-md-3 col-lg-3">';
			$contentWrapperEnd   = '</div>';
		}*/
		
		$return .= $contentWrapperStart;
			if( trim($title)!='' ) {
				// Title and Subtitle
				$return .= do_shortcode('[heading text="'.$title.'" tag="h2" style="linedot" align="top" '.$headerCarslBtn.' subtext="'.$subtitle.'" align="'.$align.'"]');
			}
			
			// Carousel Buttons
			//if( $view == 'carousel' ){ $return .= $carouselControls; }
			
		$return .= $contentWrapperEnd;
		
		
		
		$args = array(
			'post_type'				=> 'post',
			'posts_per_page'		=> $show,
			'ignore_sticky_posts'	=> true,
		);
		
		// Category
		if( $category!='' ){
			$args['tax_query'] = array(
									array(
										'taxonomy' => 'category',
										'field' => 'slug',
										'terms' => $category
									),
								);
		}
		
		
		$posts = new WP_Query( $args );
		
		//var_dump($posts);

		// The Loop
		if ( $posts->have_posts() ) {
		
			//if( $view == 'carousel' ){ $return .= $carouselControls; }
			
			$return .= $blogWrapperStart;
			$return .= '<div class="thememount-blog-boxes-inner row '.$rowFix.' thememount-items-wrapper '.$itemWrapper.'">';
			while ( $posts->have_posts() ) {
				$posts->the_post();
				$return .= thememount_blogbox( $boxwidth );
			} // while
			
			$return .= '</div>';
			
			// Button
			$return .= $btnCode;
			
			$return .= $blogWrapperEnd;
			
			
			
		} // if
		
		
		/* Restore original Post Data */
		wp_reset_postdata();
	
	$return .= '</div>';
	
	return $return;
}
}
add_shortcode( 'blogbox', 'thememount_sc_blogbox' );
