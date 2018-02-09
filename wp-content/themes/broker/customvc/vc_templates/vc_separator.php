<?php

$output = '';
extract( shortcode_atts( array(
	'el_class'	 => '',
	'type'		 => '',
	'position'	 => '',
	'color'		 => '',
	'up'		 => '',
	'down'		 => '',
	'thickness'	 => '',
), $atts ) );

$cg_css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'separator ', $this->settings['base'] );

$cg_separator_classes = "";

$cg_separator_classes .= $cg_css_class . " ";
$cg_separator_classes .= $type . " ";
$cg_separator_classes .= $position . " ";
$cg_margin_top = '';
$cg_margin_bottom = '';
$cg_background_color = '';
$cg_height = '';

if ( $up != "" ) {
	$cg_margin_top = 'margin-top:' . $up . 'px; ';
}

if ( $down != "" ) {
	$cg_margin_bottom = 'margin-bottom:' . $down . 'px; ';
}

if ( $color != "" ) {
	$cg_background_color = 'background-color:' . $color . ';';
}

if ( $thickness != "" ) {
	$cg_height .= 'height:' . $thickness . 'px;';
}

?>

<div class="<?php echo esc_attr( $cg_separator_classes ); ?>" style="<?php echo esc_attr( $cg_margin_top) . esc_attr( $cg_margin_bottom ) . esc_attr( $cg_background_color ) . esc_attr( $cg_height ); ?>">
</div>
<?php echo esc_attr( $this->endBlockComment( 'separator' ) ); ?>
