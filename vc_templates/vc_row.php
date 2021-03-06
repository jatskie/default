<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = '';
extract(shortcode_atts(array(
	'el_class'        => '',
	'bg_image'        => '',
	'bg_color'        => '',
	'bg_image_repeat' => '',
	'font_color'      => '',
	'padding'         => '',
	'margin_bottom'   => '',
	'css' => '',
    
	'anchor'            => '',
	'fullwidth'         => '',
	'textcolor'         => '',
	'bgtype'            => '',
	'parallax'          => '',
	//'bgprecolor'        => '',
	//'coloroverlay'      => '',
	'bg_video_src_mp4'  => '', // MP4 Video
	'bg_video_src_ogg'  => '', // OGG Video
	'bg_video_src_webm' => '', // WEBM Video
), $atts));

wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');



/******** ThemeMount Changes ********/

// Anchor
$id = ( trim($anchor)!='' ) ? ' id="'.trim($anchor).'"' : '' ; // Anchor

// Extra Class in Row
$thememount_class = '';

// Full Width
if( $fullwidth!='' ){
	$thememount_class .= ' thememount-row-fullwidth-'.$fullwidth;
}

// Text Color
if( $textcolor!='default' ){
	$thememount_class .= ' thememount-row-textcolor-'.$textcolor;
}

// Background Color
if( $bgtype!='default' && $bgtype!='' ){
	$thememount_class .= ' thememount-row-bgprecolor-'.$bgtype;
}

// Check if background image set
$bgimage = thememountCheckBGImage($css);

// Video
$videocode = '';
if( trim($bg_video_src_mp4)!='' || trim($bg_video_src_webm)!='' || trim($bg_video_src_ogg)!='' ){
	$videocode .= ( trim($bg_video_src_mp4)!='' ) ? '<source src="'.trim($bg_video_src_mp4).'" type="video/mp4" />' : '' ;
	$videocode .= ( trim($bg_video_src_webm)!='' ) ? '<source src="'.trim($bg_video_src_webm).'" type="video/webm" />' : '' ;
	$videocode .= ( trim($bg_video_src_ogg)!='' ) ? '<source src="'.trim($bg_video_src_ogg).'" type="video/ogg" />' : '' ;
	if( $videocode!='' ){
		$videocode = '<div class="thememount-row-bg-video-wrapper"><video class="thememount-row-bg-video" loop autoplay preload="auto">'.$videocode.'</video></div>';
	}
}

// Overlay
if( $bgimage==true || $videocode!='' ){
	$thememount_class .= ' thememount-bg-overlay';
}

// Parallax
if( $parallax!='' ){
	$thememount_class .= ' thememount-row-parallax';
}

/**********************************/

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row'.$thememount_class.' ' . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
$output .= '<div'.$id.' class="'.$css_class.'"'.$style.'>';
$output .= '<div class="section clearfix grid_section">'; // Added by ThemeMount
$output .= $videocode; // thememount: Adding video code
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>'; // Added by ThemeMount
$output .= '</div>'.$this->endBlockComment('row');


/*$el_class       = $this->getExtraClass($el_class);
$bg_image_class = (strpos($css,'background-image') !== false) ? ' thememount-row-with-bgimage ' : '' ; // BG Imge Class
$prebgcolor     = ( $bgtype=='colors' || $bgtype=='video' ) ? 'thememount-row-bgprecolor-'.$bgprecolor : '' ;


$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row thememount-row-bgtype-'.$bgtype.$bg_image_class.' thememount-row-fullwidth-'.$fullwidth.' thememount-row-parallax-'.$parallax.' thememount-row-textcolor-'.$textcolor.'  '.$prebgcolor.'  thememount-row-coloroverlay-'.$coloroverlay.' ' . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$id = ( trim($anchor)!='' ) ? ' id="'.trim($anchor).'" ' : '' ; // Anchor

// Video
$videocode = '';
if( $bgtype=='video' ){
	$videocode .= ( trim($bg_video_src_mp4)!='' ) ? '<source src="'.trim($bg_video_src_mp4).'" type="video/mp4" />' : '' ;
	$videocode .= ( trim($bg_video_src_webm)!='' ) ? '<source src="'.trim($bg_video_src_webm).'" type="video/webm" />' : '' ;
	$videocode .= ( trim($bg_video_src_ogg)!='' ) ? '<source src="'.trim($bg_video_src_ogg).'" type="video/ogg" />' : '' ;
	
	if( $videocode!='' ){
		$videocode = '<div class="thememount-row-bg-video-wrapper"><video class="thememount-row-bg-video" loop autoplay preload="auto" poster="'.$bg_image.'">'.$videocode.'</video></div>';
	}
	
}

$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);

$output .= '<div '.$id.' class=" '.$css_class.'"'.$style.'>'.$videocode.'<div class="section clearfix grid_section">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div></div>'.$this->endBlockComment('row');
*/

echo $output;
