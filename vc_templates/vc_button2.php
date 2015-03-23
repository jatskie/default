<?php
extract( shortcode_atts( array(
	'link'     => '',
	'title'    => __( 'Text on the button', "js_composer" ),
	'color'    => '',
	'icon'     => '',
	'size'     => '',
	'style'    => '',
	'el_class' => '',
	'btniconposition' => '',
	'btnicon'         => '',
), $atts ) );

$class = 'vc_btn';
//parse link
$link          = ( $link == '||' ) ? '' : $link;
$link          = vc_build_link( $link );
$a_href        = (isset($link['url'])) ? $link['url'] : '' ;
$a_title       = (isset($link['title'])) ? $link['title'] : '' ;
$a_target      = (isset($link['target'])) ? trim($link['target']) : '';
$a_target_full = ( $a_target!='' ) ? ' target="' . $a_target . '" ' : '' ;


$class .= ( $color != '' ) ? ( ' vc_btn_' . $color . ' vc_btn-' . $color ) : '';
$class .= ( $size != '' ) ? ( ' vc_btn_' . $size . ' vc_btn-' . $size ) : '';
$class .= ( $style != '' ) ? ' vc_btn_' . $style : '';
$class .= ($btniconposition!='') ? ' thememount_btn_position_'.$btniconposition : '';

$leftIconCode = $rightIconCode = '';
if( trim($btnicon)!='' ){
	if( $btniconposition == 'left' ){
		$leftIconCode .= ( $btnicon!='' ) ? '<i class="tmicon-'.$btnicon.'"></i>' : '' ;
	} else if( $btniconposition == 'right' ){
		$rightIconCode .= ( $btnicon!='' ) ? '<i class="tmicon-'.$btnicon.'"></i>' : '' ;
	}
}


$el_class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . $class . $el_class, $this->settings['base'], $atts );
?>
<a class="<?php echo esc_attr( trim( $css_class ) ); ?>" href="<?php echo $a_href; ?>"
   title="<?php echo esc_attr( $a_title ); ?>" <?php echo $a_target_full; ?>>
	<?php echo $leftIconCode; ?>
    <?php echo $title; ?>
    <?php echo $rightIconCode; ?>
</a>
<?php echo $this->endBlockComment( 'vc_button' ) . "\n";