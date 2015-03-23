<?php
if( !function_exists('thememount_sc_contactbox') ){
function thememount_sc_contactbox( $atts, $content=NULL ){
	extract( shortcode_atts( array(
		//'title'   => '',
		'phone'   => '',
		'email'   => '',
		'website' => '',
		'address' => '',
		'time'    => '',
	), $atts ) );
	
	$return = '<ul class="thememount_vc_contact_wrapper">';
	
	/*if( trim($title)!='' ) {
		// Title and Subtitle
		$return .= do_shortcode('[heading text="'.$title.'" tag="h2" align="left"]');
	}*/
	
	if( trim($phone)!='' ) {
		$return .= '<li class="thememount-contact-phonenumber tmicon-fa-phone">'.trim($phone).'</li>';
	}
	
	if( trim($email)!='' ) {
		$return .= '<li class="thememount-contact-email tmicon-fa-envelope-o"><a href="mailto:'.trim($email).'">'.trim($email).'</a></li>';
	}
	
	if( trim($website)!='' ) {
		$return .= '<li class="thememount-contact-website tmicon-fa-globe"><a href="'.thememount_addhttp($website).'">'.trim($website).'</a></li>';
	}
	
	if( trim($address)!='' ) {
		$return .= '<li class="thememount-contact-address  tmicon-fa-map-marker">'.$address.'</li>';
	}
	
	if( trim($time)!='' ) {
		$return .= '<li class="thememount-contact-time tmicon-fa-clock-o">'.$time.'</li>';
	}
	
	$return .= '</ul>';
	
	return $return;
}
}
add_shortcode( 'contactbox', 'thememount_sc_contactbox' );