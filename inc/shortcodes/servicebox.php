<?php
// [servicebox]
function thememount_sc_servicebox( $atts, $content=NULL ) {
	extract( shortcode_atts( array(
		'boxtype'         => 'lefticon',
		'hover'           => 'none',
		'icon'            => '',
		'title'           => '',
		'titlelink'       => '',
		'subtitle'        => '',
		'contents'        => '',
		'buttontype'      => '',
		'buttonstyle'     => '',
		'buttontext'      => '',
		'buttoncolor'     => '',
		'buttonsize'      => '',
		'buttonicon'      => '',
		//'buttoneffect'  => '',
		'btniconposition' => 'left',
		'buttonlink'      => '',
		'css_animation'   => '',
		
	), $atts ) );
	
	$return = '';
	
	// Icon Align
	$iconAlign = ( $boxtype == 'centericon' ) ? 'center' : 'left' ;
	
	// preparing link
	$title_href   = '';
	$title_title  = '';
	$title_target = '';
	if( function_exists('vc_build_link') ){
		$titlelink    = vc_build_link( $titlelink );
		$title_href   = $titlelink['url'];
		$title_title  = $titlelink['title'];
		$title_target = $titlelink['target'];
	}
	
	// Button link
	$buttonlink2_href   = '';
	$buttonlink2_title  = '';
	$buttonlink2_target = '';
	if( function_exists('vc_build_link') ){
		$buttonlink2        = vc_build_link( $buttonlink );
		$buttonlink2_href   = $buttonlink2['url'];
		$buttonlink2_title  = $buttonlink2['title'];
		$buttonlink2_target = trim($buttonlink2['target']);
	}
	
	if( $buttonlink2_target=='_blank' ){
		$buttonlink2_target = ' target="_blank" ';
	}
	
	// Title with Link
	$title = ( trim($title_href)!='' ) ? '<a class="thememount-sb-title-link" href="' . $title_href . '"
   title="' . esc_attr( $title_title ) . '" target="' . $title_target . '">'.$title.'</a>' : $title ;
	
	// Animation Class
	$animationClass = ( $css_animation!='' ) ? 'wpb_animate_when_almost_visible wpb_'.$css_animation.' wpb_start_animation' : '' ;
	
	// Icon Position in Button
	$btnIconPosition = 'no';
	$btnIcon         = '';
	if( $buttontype=='iconbtn' ){
		$btnIconPosition = $btniconposition;
		$btnIcon         = $buttonicon;
	}
	
	$return .= '<section class="thememount-servicebox thememount-servicebox-'.$boxtype.' '.$animationClass.' '.$hover.'">';
	
		$return .= '<div class="thememount-servicebox-title-wrapper">';
			if( !empty($icon) ){
				$return .= do_shortcode('[icon type="'.$icon.'" size="large" align="'.$iconAlign.'" roundborder="no" bgcolor="skincolor"]');
			}
			$return .= '<h2 class="thememount-servicebox-title">'.$title.'</h2>';
			if( !empty($subtitle) ){ $return .= '<h4 class="thememount-servicebox-subtitle">'.$subtitle.'</h4>'; }

		
			
		$return .= '<div class="thememount-servicebox-content">';
			$return .= ( !empty($contents) ? '<p>'.do_shortcode($contents).'</p>' : '' );
			if($buttontype=='btn'){
				$return .= do_shortcode('[vc_button2 title="'.$buttontext.'" style="'.$buttonstyle.'" color="'.$buttoncolor.'" size="'.$buttonsize.'" btniconposition="no" btnicon="'.$btnIcon.'" link="'.$buttonlink.'"]');
				
			} else if($buttontype=='iconbtn'){
				$return .= do_shortcode('[vc_button2 title="'.$buttontext.'" style="'.$buttonstyle.'" color="'.$buttoncolor.'" size="'.$buttonsize.'" btniconposition="'.$btnIconPosition.'" btnicon="'.$btnIcon.'" link="'.$buttonlink.'"]');
				
			} else if($buttontype=='icontext'){
				$i_left  = '';
				$i_right = '';
				if( $btniconposition=='left' ){
					$i_left = '<i class="tmicon-'.$buttonicon.'"></i>&nbsp;';
				} else if( $btniconposition=='right' ){
					$i_right = '&nbsp;<i class="tmicon-'.$buttonicon.'"></i>';
				}
				
				$return .= '<div class="thememount-sb-main-link"><a href="'.$buttonlink2_href.'" title="'.$buttonlink2_title.'" '.$buttonlink2_target.'>'.$i_left.' '.$buttontext.' '.$i_right.'</a></div>';
				
			} else if($buttontype=='text'){
				$return .= '<div class="thememount-sb-main-link"><a href="'.$buttonlink2_href.'" title="'.$buttonlink2_title.'" '.$buttonlink2_target.'>'.$buttontext.'</a></div>';
				
			} else {
				// No Button
			}
			$return .= '</div>';
		$return .= '</div>';


	$return .= '</section>';
	
	
	return $return;
}
add_shortcode( 'servicebox', 'thememount_sc_servicebox' );

