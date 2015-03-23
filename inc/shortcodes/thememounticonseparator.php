<?php
// [thememounticonseparator icon="search-1" style="dashed" width="70" el_class="customclass"]
if( !function_exists('thememount_sc_thememounticonseparator') ){
function thememount_sc_thememounticonseparator( $atts, $content=NULL ){
	extract(shortcode_atts(array(
		'icon'  => '',
		'style' => '',
		'width' => '',
		'class' => '',
	), $atts));
	$class = "thememount_icon_separator";
	$class .= ($style!='') ? ' thememount-swi-style-'.$style : '';
	$class .= ($width!='') ? ' thememount-swi-width-'.$width : '';
	$class .= ($class!='') ? ' '.$class : '';
	
	$return = '<div class="thememount_swi_wrapper ' . esc_attr(trim($class)) . '">
		<span class="thememount_swi_holder thememount_swi_holder_l"><span class="vc_sep_line"></span></span>
		<i class="tmicon-' . $icon . '"></i>
		<span class="thememount_swi_holder thememount_swi_holder_r"><span class="vc_sep_line"></span></span>
	</div>';
	return $return;
}
}
add_shortcode( 'thememounticonseparator', 'thememount_sc_thememounticonseparator' );