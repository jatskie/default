<?php
// [heading tag="h1" text="This is heading text"]
if( !function_exists('thememount_sc_heading') ){
function thememount_sc_heading( $atts, $content=NULL ){
	extract( shortcode_atts( array(
		'tag'         => 'h1',
		'text'        => 'Welcome to our site',
		//'sepicon'   => 'NO_ICON',
		'subtext'     => '',
		'carouselbtn' => "",
		'align'      => 'left',
	), $atts ) );
	$centerCarouselbtnCode = '';
	$carouselbtnCode       = ( $carouselbtn == 'yes' ) ? '<div class="thememount-carousel-controls-inner"><a href="javascript:void(0)" class="thememount-carousel-prev"><span class="wpb_button"><i class="tmicon-fa-angle-left"></i></span></a><a href="javascript:void(0)" class="thememount-carousel-next"><span class="wpb_button"><i class="tmicon-fa-angle-right"></i></span></a></div>' : '' ;
	
	if( $align=='center' ){
		$centerCarouselbtnCode = $carouselbtnCode;
		$carouselbtnCode       = '';
	}
	
	
	
	$heading = '<'.$tag.' class="thememount-heading-align-'.$align.'"><span>'.do_shortcode($text).'</span></'.$tag.'>';
	//$sep     = ( trim($sepicon)!='NO_ICON' ) ? '<span class="thememount-heading-sepicon"><i class="tmicon-'.$sepicon.'"></i></span>' : '' ;
	$subtext = ( trim($subtext)!='' ) ? '<p class="thememount-subheading">'.do_shortcode(trim($subtext)).'</p>' : '' ;
	
	$topWrapper    = '<header class="thememount-heading-wrapper thememount-heading-wrapper-align-'.$align.'">';
	$subWrapperStart = '<div class="thememount-heading-wrapper-inner">';
	$subWrapperEnd   = '</div>';
	$bottomWrapper = '</header>';
	
	$return = $topWrapper.$subWrapperStart.$heading.$carouselbtnCode.$subWrapperEnd.$subtext.$centerCarouselbtnCode.$bottomWrapper;
	
	return $return;
}
}
add_shortcode( 'heading', 'thememount_sc_heading' );