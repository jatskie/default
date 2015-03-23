<?php

/* 
 * This icon list is created by ThemeMount Infotech
 * 
 */

$howes = get_option('howes');
$thememount_iconsArray = array();

// Load font icon library CSS files

// Adding FontAwesome List by default
include_once('icons-list-fontawesome.php');
$thememount_iconsArray = array_merge($thememount_iconsArray, $fontawesome_array );

if( isset($howes['fonticonlibrary']) && is_array($howes['fonticonlibrary']) && count($howes['fonticonlibrary'])>0 ){
	foreach( $howes['fonticonlibrary'] as $library=>$val ){
		if( $library!='fontawesome' ){
			if( $val == '1' ){
				include_once('icons-list-'.$library.'.php');
				$thememount_iconsArray = array_merge($thememount_iconsArray, ${$library.'_array'} );
			}
			
		}
	}
}
