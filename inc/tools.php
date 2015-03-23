<?php



/******************** YouTube embed code from URL ***********************/
//  Usage:
//  echo thememount_YoutubeEmbedCodeFromURL( 'http://www.youtube.com/watch?v=fHBFvlQ3JGY' );
if( !function_exists('thememount_YoutubeEmbedCodeFromURL') ){
function thememount_YoutubeEmbedCodeFromURL( $url ){
	//$url = 'http://www.youtube.com/watch?v=fHBFvlQ3JGY';
	preg_match(
			'/[\\?\\&]v=([^\\?\\&]+)/',
			$url,
			$matches
		);
	$id = $matches[1];
	 
	$width = '640';
	$height = '385';
	return '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>';
}
}


/********************** One Click Demo Content Install *************************/
include_once( dirname( __FILE__ ).'/one-click-demo/demo-content.php' );



/********************** Topbar *************************/
if( !function_exists('thememount_topbar') ){
function thememount_topbar(){
	

	global $howes;
	
	// Getting options
	$topbarhide              = $howes['topbarhide'];
	$topbarbgcolor           = $howes['topbarbgcolor'];
	$topbarhidesocial        = $howes['topbarhidesocial'];
	$topbar_show_team_search = $howes['topbar_show_team_search'];
	//$topbarsocialposition  = $howes['topbarsocialposition'];
	$topbartext              = $howes['topbartext'];
	$text_color              = $howes['topbar_text_color'];
	$topbarrighttext         = ( isset($howes['topbarrighttext']) && trim($howes['topbarrighttext'])!='' ) ? '<div class="tm-tb-right-content">'.do_shortcode(trim($howes['topbarrighttext'])).'</div>' : '' ;
	
	
	
	if( is_page() ){
		$p_topbarhide           = trim( get_post_meta( get_the_ID(), '_thememount_page_topbar_topbarhide', true ) );
		$p_topbarbgcolor        = trim( get_post_meta( get_the_ID(), '_thememount_page_topbar_topbarbgcolor', true ) );
		$p_topbarhidesocial     = trim( get_post_meta( get_the_ID(), '_thememount_page_topbar_topbarhidesocial', true ) );
		$p_topbarsocialposition = trim( get_post_meta( get_the_ID(), '_thememount_page_topbar_topbarsocialposition', true ) );
		$p_topbartext           = trim( get_post_meta( get_the_ID(), '_thememount_page_topbar_topbartext', true ) );
		
		$topbarhide           = ($p_topbarhide!='')       ? $p_topbarhide : $topbarhide ;
		$topbarbgcolor        = ($p_topbarbgcolor!='')    ? $p_topbarbgcolor : $topbarbgcolor ;
		$topbarhidesocial     = ($p_topbarhidesocial!='') ? $p_topbarhidesocial : $topbarhidesocial ;
		//$topbarsocialposition = ($p_topbarsocialposition!='') ? $p_topbarsocialposition : $topbarsocialposition ;
		$topbartext           = ($p_topbartext!='') ? $p_topbartext : $topbartext ;
	}
	
	
	if( $topbarhide!='1' ){
		global $howes;
		$return       = '';
		$leftContent  = do_shortcode($topbartext);
		if( $topbarhidesocial!='1' ){
			$rightContent = thememount_get_social_links(); // Right: Social Icons
		} else {
			$rightContent = ''; // Right: Social Icons
		}
		
		// Adding right content
		$rightContent = $rightContent.$topbarrighttext;
		
		// WPML language switcher
		/*if( function_exists('icl_get_languages') ){
			ob_start();
			do_action('icl_language_selector');
			$langDropdown = ob_get_clean();
			$rightContent .= '<span class="tm-wpml-lang-switcher">'.$langDropdown.'</span>';
		}*/
		
		
		if( trim($rightContent) == '' ){
			$return .= '<div class="thememount-tb-content thememount-center">'.$leftContent.'</div>';
		} else {
			$return .= '<div class="thememount-tb-content thememount-flexible-width-left">'.$leftContent.'</div>';
			$return .= '<div class="thememount-tb-social thememount-flexible-width-right">'.$rightContent.'</div>';
			
		}
		
		
		echo '
			<div class="thememount-topbar thememount-topbar-textcolor-'.$text_color.' ">
				<div class="container">
					<div class="table-row">
						'.$return.'
					</div>
				</div>
			</div>';
	}
}
}
/*****************************************************************/



/*
 *  Header dynamic class for different settings
 */
function thememount_headerclass(){
	global $howes;
	$headerClassList = array();
	
	// Main Menu active link color
	if( isset($howes['mainmenu_active_link_color']) && trim($howes['mainmenu_active_link_color'])!='' ){
		$headerClassList[] = 'tm-mmenu-active-color-'.trim($howes['mainmenu_active_link_color']);
	} else {
		$headerClassList[] = 'tm-mmenu-active-color-skin';
	}
	
	// Dropdown Menu active link color
	if( isset($howes['dropmenu_active_link_color']) && trim($howes['dropmenu_active_link_color'])!='' ){
		$headerClassList[] = 'tm-dmenu-active-color-'.trim($howes['dropmenu_active_link_color']);
	} else {
		$headerClassList[] = 'tm-dmenu-active-color-skin';
	}
	
	// Dropdown Menu separator
	if( isset($howes['dropdown_menu_separator']) && trim($howes['dropdown_menu_separator'])!='' ){
		$headerClassList[] = 'tm-dmenu-sep-'.trim($howes['dropdown_menu_separator']);
	} else {
		$headerClassList[] = 'tm-dmenu-sep-grey';
	}
	
	return implode(' ', $headerClassList);
}



// Team Member search box
if( !function_exists('thememount_floatingbar') ){
function thememount_floatingbar(){
	global $howes;
	$topbar_show_team_search = $howes['topbar_show_team_search'];
	$topbar_handler_icon = (isset($howes['topbar_handler_icon']) && trim($howes['topbar_handler_icon'])!='') ? trim($howes['topbar_handler_icon']) : 'fa-user-md' ;
	$topbar_handler_icon_close = (isset($howes['topbar_handler_icon_close']) && trim($howes['topbar_handler_icon_close'])!='') ? trim($howes['topbar_handler_icon_close']) : 'fa-times' ;
	
	$fbar_text_color = (isset($howes['fbar_text_color']) && trim($howes['fbar_text_color'])!='') ? trim($howes['fbar_text_color']) : 'white' ;
	$fbar_bg_color   = (isset($howes['fbar_bg_color']) && trim($howes['fbar_bg_color'])!='') ? trim($howes['fbar_bg_color']) : 'skin' ;
	
	
	$aboveContent = '';
	if( $topbar_show_team_search=='1' ){
		echo '<span class="thememount-fbar-btn"><a href="#" data-closeicon="'.$topbar_handler_icon_close.'" data-openicon="'.$topbar_handler_icon.'"><i class="tmicon-'.$topbar_handler_icon.'"></i> <span>' . __('Search', 'howes') . '</span></a></span>';
		?>
		
		<div class="thememount-fbar-box-w thememount-fbar-text-<?php echo $fbar_text_color; ?> thememount-fbar-bg-<?php echo $fbar_bg_color; ?>">
			<div class="container thememount-fbar-box" style="">
				<?php if( !dynamic_sidebar( 'floating-header-widgets' ) ){
					echo '<div class="thememount-no-widget-message">';
					_e('We don\'t find any widget to show. Please add some widgets by going to <strong>Admin > Appearance > Widgets</strong> and add widgets in <strong>"Floating Header Widgets "</strong> area.','apicona');
					echo '</div>';
				} ?>
			</div>
		</div>
		
		<?php
	}
	echo $aboveContent;
}
}




/********************** Team Search Form ************************/
if( !function_exists('thememount_team_search_form') ){
function thememount_team_search_form(){
	$return = '';
	
	// Team Group as Dropdown
	$dropDown     = '';
	$inputClass   = 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
	$termList     = get_terms( 'team_group', array('hide_empty'=>false) );
	//$termList   = '';
	$noGroupClass = '';
	if( is_array($termList) && count($termList)>0 ){
		$inputClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
		$dropDown .= '<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12"> <div class="search_field by_treatment"> <i class="tmicon-fa-tags"></i> <select name="team_group"> <option value="" class="select-empty">' . __('All Sections', 'howes') . '</option>';
		foreach( $termList as $term ){
			$selected = ( get_query_var('team_group') == $term->slug ) ? 'selected="selected"' : '' ;
			$dropDown .= '<option value="'.$term->slug.'" '.$selected.'>'.$term->name.'</option>'."\n";
		}
		$dropDown .= '</select></div></div>';
	} else {
		$noGroupClass = ' thememount-team-form-no-group';
		$inputClass   = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
	}
	
	$wpmlHdn = '';
	if (defined('ICL_LANGUAGE_CODE')){
		$wpmlHdn = '<input type="hidden" name="lang" value="'.ICL_LANGUAGE_CODE.'"/>';
	}
	
	// Form
	$return .= '<form role="search" method="get" class="team-search-form'.$noGroupClass.'" action="'.esc_url( home_url( '/' ) ).'">
					<input type="hidden" name="teamsearch" value="1">
					<input type="hidden" name="post_type" value="team_member" />
					'.$wpmlHdn.'
					<div class="row">
						
						<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12">
							<h2>'.__('Team Member Search:', 'howes').'</h2>
						</div>
						
						<div class="'.$inputClass.'">
							<div class="search_field by_name">
								<i class="tmicon-fa-user-md"></i>
								<input type="text" placeholder="'.__('Search by name','howes').'" name="s" value="'.get_search_query().'">
							</div>
						</div>
						
						'.$dropDown.'
						
						<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12">
							<div class="submit_field">
								<button type="submit">' . __('Search' , 'howes') . '</button>
							</div>
						</div>
						
					</div><!-- .row -->
					
				</form><!-- form end --> ';
				
	return $return;
}
}
/*****************************************************************/





/********************** Portfolio Details ************************/
if( !function_exists('thememount_favicon_code') ){
function thememount_favicon_code(){
	global $howes;
	$return = '';
	/*
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
	
	
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="160x160" href="/favicon-160x160.png">
	<link rel="icon" type="image/png" sizes="196x196" href="/favicon-196x196.png">
	
	<meta name="apple-mobile-web-app-title" content="ThemeMount Infotech">
	<meta name="application-name" content="ThemeMount Infotech">
	
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="/mstile-144x144.png">
	*/
	
	/*
	<meta name="application-name" content="ThemeMount Infotech"/>
	<meta name="msapplication-TileColor" content="#00ff00"/>
	
	<meta name="msapplication-square70x70logo" content="tiny.png"/>
	<meta name="msapplication-square150x150logo" content="square.png"/>
	<meta name="msapplication-wide310x150logo" content="wide.png"/>
	<meta name="msapplication-square310x310logo" content="large.png"/>
	*/
	
	$faviconarray = array(
		'favicon'     => 'rel="shortcut icon" type="image/x-icon"',
		'favicon_57'  => 'rel="apple-touch-icon" sizes="57x57"',
		'favicon_60'  => 'rel="apple-touch-icon" sizes="60x60"',
		'favicon_72'  => 'rel="apple-touch-icon" sizes="72x72"',
		'favicon_76'  => 'rel="apple-touch-icon" sizes="76x76"',
		'favicon_114' => 'rel="apple-touch-icon" sizes="114x114"',
		'favicon_120' => 'rel="apple-touch-icon" sizes="120x120"',
		'favicon_144' => 'rel="apple-touch-icon" sizes="144x144"',
		'favicon_152' => 'rel="apple-touch-icon" sizes="152x152"',
		'favicon_180' => 'rel="apple-touch-icon" sizes="180x180"',
		'favicon_16'  => 'rel="icon" type="image/png" sizes="16x16"',
		'favicon_32'  => 'rel="icon" type="image/png" sizes="32x32"',
		'favicon_96'  => 'rel="icon" type="image/png" sizes="96x96"',
		'favicon_160' => 'rel="icon" type="image/png" sizes="160x160"',
		'favicon_192' => 'rel="icon" type="image/png" sizes="192x192"',
	);
	$favicon_meta_array = array(
		'favicon_ms_144'      => 'name="msapplication-TileImage"',
		'favicon_ms_70'      => 'name="msapplication-square70x70logo"',
		'favicon_ms_150'     => 'name="msapplication-square150x150logo"',
		'favicon_ms_310_150' => 'name="msapplication-wide310x150logo"',
		'favicon_ms_310'     => 'name="msapplication-square310x310logo"',
	);
	
	// <link>
	foreach( $faviconarray as $id => $code ){
		if( !empty( $howes[$id]['url'] ) ){
			$return .= '<link '.$code.' href="'.$howes[$id]['url'].'">'."\n";
		}
	}
	
	// <meta>
	foreach( $favicon_meta_array as $id => $code ){
		if( !empty( $howes[$id]['url'] ) ){
			$return .= '<meta '.$code.' content="'.$howes[$id]['url'].'" />'."\n";
		}
	}
	
	
	$return .= '<meta name="apple-mobile-web-app-title" content="'.get_bloginfo( 'name' ).'">'."\n";
	$return .= '<meta name="application-name" content="'.get_bloginfo( 'name' ).'">'."\n";
	if( !empty($howes['favicon_ms_tile_color']) ){
		$return .= '<meta name="msapplication-TileColor" content="'.$howes['favicon_ms_tile_color'].'">'."\n";
	}
	
	echo $return;
}
}
// Adding Favicon icon code in head
add_action('wp_head','thememount_favicon_code');


/*****************************************************************/





/********************** Portfolio Details ************************/
if( !function_exists('thememount_portfolio_detailsbox') ){
function thememount_portfolio_detailsbox(){

	$clientName = trim( get_post_meta( get_the_ID(), '_thememount_portfolio_data_clientname', true ) );
	$clientLink = trim( get_post_meta( get_the_ID(), '_thememount_portfolio_data_clientlink', true ) );
	$skills     = trim( get_post_meta( get_the_ID(), '_thememount_portfolio_data_skills', true ) );
	$linkText   = trim( get_post_meta( get_the_ID(), '_thememount_portfolio_data_linktext', true ) );
	$linkUrl    = trim( get_post_meta( get_the_ID(), '_thememount_portfolio_data_linkurl', true ) );
	global $howes;
	
	echo '<div class="thememount-portfolio-details">';
	
	echo do_shortcode('[heading tag="h2" text="' . __($howes['portfolio_project_details'], 'howes') . '"]');
	
	echo '<ul class="thememount-portfolio-details-list">';
		
		// Date
		echo '<li class="thememount-portfolio-date"> <i class="tmicon-fa-calendar-o"></i> ' . get_the_date( 'd M Y' ) . '</li>';
		
		// Category
		$catList = wp_get_post_terms( get_the_ID(), 'portfolio_category' );
		if( is_array($catList) && count($catList)>0 ){
			echo '<li class="thememount-portfolio-cat"> <i class="tmicon-fa-folder-open-o"></i> ';
			$x = 0;
			foreach( $catList as $cat ){
				if( $x!=0 ){ echo ', '; }
				echo '<span>' . $cat->name . '</span>';
				$x++;
			}
			echo '</li>';
		}
		
		// Client Name w/o link
		if( $clientName!='' ){
			if( $clientLink!='' ){
				$client = '<a href="' . $clientLink . '" target="_blank">' . $clientName . '</a>';
			} else {
				$client = $clientName;
			}
			echo '<li class="thememount-portfolio-client"> <i class="tmicon-fa-user"></i> ' . $client . '</li>';
		}
		
		// Skills
		if( $skills!='' ){
			echo '<li class="thememount-portfolio-skills"> <i class="tmicon-fa-star-o"></i> ' . $skills . '</li>';
		}
		
		// Project Link
		if( $linkUrl!='' ){
			echo '<li class="thememount-portfolio-link"> <i class="tmicon-fa-link"></i> <a href="' . $linkUrl . '" target="_blank">' . $linkText . '</a></li>';
		}
		
	echo '</ul>';
	echo '</div> <!-- .portfolio-details --> ';
}	
}
/*****************************************************************/






if( !function_exists('thememount_get_social_links') ){
function thememount_get_social_links(){
	global $howes;
	$socialArray = array(
		'twitter'    => array( 'fa-twitter', 'Twitter' ),
		'youtube'    => array( 'fa-youtube', 'YouTube' ),
		'flickr'     => array( 'fa-flickr', 'Flickr' ),
		'facebook'   => array( 'fa-facebook', 'Facebook' ),
		'linkedin'   => array( 'fa-linkedin', 'LinkedIn' ),
		'googleplus' => array( 'fa-google-plus', 'Google+' ),
		'yelp'       => array( 'fa-yelp', 'Yelp' ),
		'dribbble'   => array( 'fa-dribbble', 'Dribbble' ),
		'pinterest'  => array( 'fa-pinterest', 'Pinterest' ),
		'podcast'    => array( 'fa-wifi', 'Podcast' ),
		'instagram'  => array( 'fa-instagram', 'Instagram' ),
		'xing'       => array( 'fa-xing', 'Xing' ),
		'vimeo'      => array( 'fa-vimeo-square', 'Vimeo' ),
		'vk'         => array( 'fa-vk', 'VK' ),
		'rss'        => array( 'fa-rss', 'RSS' ),
	);
	
	$return = '';
	foreach( $socialArray as $key=>$value ){
		
		if( $key == 'rss' ){
			if( isset($howes['rss']) && $howes['rss']=='1' ){
				$return .= '<li class="'.$key.'"><a target="_blank" href="'.get_bloginfo('rss2_url').'" title="'.$value[1].'" data-toggle="tooltip"><i class="tmicon-'.$value[0].'"></i></a></li>';
			}
		} else {
			if( isset($howes[$key]) && trim($howes[$key])!='' ){
				$return .= '<li class="'.$key.'"><a target="_blank" href="'.esc_url($howes[$key]).'" title="'.$value[1].'" data-toggle="tooltip"><i class="tmicon-'.$value[0].'"></i></a></li>';
			}
		}
	}
	
	if( $return!='' ){
		$return = '<ul class="social-icons">'.$return.'</ul>';
	}
	
	return $return;
}
}






/*************** Set primary Class for #primary ******************/
if( !function_exists('setPrimaryClass') ){
function setPrimaryClass($sidebar){
	$primaryclass = 'col-md-12 col-lg-12 col-sm-12 col-xs-12';
	switch($sidebar){
		case 'left':
		case 'right':
			$primaryclass = 'col-md-9 col-lg-9 col-xs-12';
			break;
		case 'both':
		case 'bothleft':
		case 'bothright':
			$primaryclass = 'col-md-6 col-lg-6 col-xs-12';
			break;
	}
	return $primaryclass;
}
}
/*****************************************************************/



/************************* Header Slider ************************/
if( !function_exists('thememount_header_slider') ){
function thememount_header_slider(){
	$sliderWrapperStart = '<div id="tm-header-slider" class="thememount-slider-wrapper">';
	$sliderWrapperEnd   = '</div>';
	if( is_page() ){
		// check if any slider setup on page
		$sliderType = get_post_meta(get_the_ID(), '_thememount_page_options_slidertype', true);
		if(isset($sliderType) && is_array($sliderType) ){ $sliderType = $sliderType[0]; }
		
		
		// If Boxed Slider set
		$sliderSize = get_post_meta(get_the_ID(), '_thememount_page_options_slidersize', true);
		if(isset($sliderSize) && is_array($sliderSize) ){ $sliderSize = $sliderSize[0]; }
		if( $sliderSize=='boxed' ){
			$sliderWrapperStart .= '<div class="container"><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			$sliderWrapperEnd   .= '</div></div></div>';
		}
		
		if( $sliderType!='' ){
			switch($sliderType){
				case 'revslider':
					// **** Slider Revolution **** //
					$revSliderAlias = trim(get_post_meta(get_the_ID(), '_thememount_page_options_revslider_slider', true));
					if( $revSliderAlias!='' ){
						echo $sliderWrapperStart;
						echo do_shortcode('[rev_slider '.$revSliderAlias.']');
						echo $sliderWrapperEnd;
					}
					break;
				
				
				case 'nivo':
				case 'flex':	
					
					$slidercat = get_post_meta( get_the_ID() ,'_thememount_page_options_slidercat', true );
					//var_dump($slidercat);
					
					$args = array(
						'post_type'      => 'slide',
						'posts_per_page' => 9999,
						'tax_query'      => array(
							array(
								'taxonomy' => 'slide_group',
								'field' => 'slug',
								'terms' => $slidercat
							),
						)
					);
					$loop = new WP_Query( $args );
					
					if( isset($loop->posts) && count($loop->posts)>0 ){
						echo $sliderWrapperStart;
						if( $sliderType=='flex' ){
							echo '<div class="flexslider"><ul class="slides">';
						} else {
							echo '<div class="thememount-slider thememount-'.$sliderType.'-slider-wrapper"> <div class="slider-wrapper theme-default"> <div id="slider" class="nivoSlider">';
						}
						
						$x = 1;
						$descText = '';
						while ( $loop->have_posts() ) : $loop->the_post();
							
							// Getting data
							$title   = esc_attr( trim(get_the_title()) );
							$desc    = esc_attr( trim(get_post_meta( get_the_ID(), '_thememount_slides_options_desc', true )) );
							$btntext = esc_attr( trim(get_post_meta( get_the_ID(), '_thememount_slides_options_btntext', true )) );
							$btnlink = esc_url( trim(get_post_meta( get_the_ID(), '_thememount_slides_options_btnlink', true )) );
							
							$desc    = ( $desc!='' ) ? '<div class="thememount-slider-desc">'.$desc.'</div>' : '' ;
							//$btntext = ( $btntext!='' ) ? '<div class="thememount-slider-btn"><a href="'.$btnlink.'">'.$btntext.'</a></div>' : '' ;
							
							$btntext = ( $btntext!='' ) ? do_shortcode('[vc_button title="'.$btntext.'" icon="right-open" color="white" size="big" href="'.$btnlink.'" el_class="" btn_effect="bordertocolor" iconposition="right" showicon="withicon"]') : '' ;
							
							
							if( has_post_thumbnail() ){
								$url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
							} else {
								$url = 'no-image.jpg';
							}
							
							
							if( $sliderType=='nivo' ){
								// **** Nivo Slider **** //
								echo '<img src="'.$url.'" alt="" title="#nivoslidetext'.$x.'" />';
								$descText .= '<div id="nivoslidetext'.$x.'" class="nivo-html-caption"><h2>'.$title.'</h2>'.$desc.$btntext.'</div>';
								
							} else {
								// **** Flex Slider **** //
								echo '<li><img src="'.$url.'" />';
								if( $title!='' ){ echo '<div class="flex-caption"><div class="flex-caption-inner"><h3 class="flex-caption-title">'.$title.'</h3><div class="flex-caption-desc">'.$desc.'</div><div class="flex-caption-btn">'.$btntext.'</div></div></div>'; }
								echo '</li>';
							}
							$x++;
						endwhile;
						
						if( $sliderType=='flex' ){
							echo '</ul><!-- .slides --> </div><!-- .flexslider -->';
						} else {
							echo '</div><!-- #slider.nivoSlider -->';
							// Echo Decription of each slide
							echo '<div id="htmlcaption" class="nivo-html-caption">'.$descText.'</div>';
							echo '</div><!-- .slider-wrapper --> </div><!-- .thememount-slider --> ';
						}
						
						echo $sliderWrapperEnd;
						
					}  // if( count($loop->posts)>0 )
					
					break;
			}
		}
	}
	
}
}
/*****************************************************************/


/************* Check if color is dark or light ****************/
if( !function_exists('get_brightness') ){
function get_brightness($hex) {
	// returns brightness value from 0 to 255

	// strip off any leading #
	$hex = str_replace('#', '', $hex);

	$c_r = hexdec(substr($hex, 0, 2));
	$c_g = hexdec(substr($hex, 2, 2));
	$c_b = hexdec(substr($hex, 4, 2));

	return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
}
}
/*****************************************************************/




/*
 *  Check if color is dark. This is new version. This will return TRUE if dark color.
 */
function tm_check_dark_color($hex){
	//$hex = "78ff2f"; //Bg color in hex, without any prefixing #!
	
	// strip off any leading #
	$hex = str_replace('#', '', $hex);

	//break up the color in its RGB components
	$r = hexdec(substr($hex,0,2));
	$g = hexdec(substr($hex,2,2));
	$b = hexdec(substr($hex,4,2));

	//do simple weighted avarage
	//
	//(This might be overly simplistic as different colors are perceived
	// differently. That is a green of 128 might be brighter than a red of 128.
	// But as long as it's just about picking a white or black text color...)
	if($r + $g + $b > 382){
		return false;
		//bright color, use dark font
	}else{
		return true;
		//dark color, use bright font
	}
}



/************* HEX to RGB converter for CSS color ****************/
if( !function_exists('hex2rgb') ){
function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	return implode(",", $rgb); // returns the rgb values separated by commas
	//return $rgb; // returns an array with the rgb values
}
}
/*****************************************************************/





/*********** Getting Featured Slider / Video or Image ***********/
if( !function_exists('thememount_get_featured_content') ){
function thememount_get_featured_content($postid, $size='blog-slider-small', $postBoxTitle='thememount_post_featured_area' , $noVideo=false , $showNoImage=false ){
	
	$featuredContent = '';
	$featuredtype    = get_post_meta($postid, '_'.$postBoxTitle.'_featuredtype', true);
	$featuredtype    = $featuredtype[0];
	$featuredtype    = ($size=='blog-slider-small') ? 'image' : $featuredtype ;
	$noWrapper       = false;
	
	
	if($noVideo){
		$featuredtype = ($featuredtype=='video' || $featuredtype=='audio') ? 'image' : $featuredtype;
	}
	
	
	switch($featuredtype){
		case 'video':
			$featuredContent = '<div class="fluid-video">'.get_post_meta($postid, '_'.$postBoxTitle.'_videocode', true).'</div>';
			break;
		case 'audio':
			$featuredContent = '';
			if( is_single() ){
				if( has_post_thumbnail($postid) ){
					$featuredContent = get_the_post_thumbnail( $postid, $size );
				}
			}
			$featuredContent .= '<div class="fluid-audio">'.get_post_meta($postid, '_'.$postBoxTitle.'_audiocode', true).'</div>';
			break;
		case 'slider':
			$slideImages = array();
			for($a=1; $a<=10; $a++){
				$slideImages[] = wp_get_attachment_image(get_post_meta($postid, '_'.$postBoxTitle.'_slideimage'.$a, true), $size);
			}
			$slideImages = array_filter($slideImages); // Removing empty array
			if( count($slideImages)>0 ){
				$featuredContent = '<div class="flexslider"><ul class="slides"><li>';
				$featuredContent .= implode('</li><li>',$slideImages);
				$featuredContent .= '</li></ul></div>';
			}
			break;
		default:
			if( has_post_thumbnail($postid) ){
				$featuredContent = get_the_post_thumbnail( $postid, $size );
			} else {
				if( !is_single() ){
					if($showNoImage==true){
						//if($noVideo==true){
						//	$featuredContent = '<i class="fa fa-picture thememount-proj-noimage-icon"></i>';
						//} else {
							$featuredContent = '<div class="thememount-proj-noimage"><i class="fa fa-picture"></i></div>';
						//}
					}
				} else {
					$featuredContent = '';
				}
				$noWrapper = true;
			}
			break;
	}
	if($featuredContent!=''){
		if( $noWrapper==true ){
			return $featuredContent;
		} else {
			return '<div class="featured-content-wrapper featured-type-'.$featuredtype.'">'.$featuredContent.'</div>';
		}
		
	} else {
		return '';
	}
	
}
}
/*******************************************************************/











/*********** Portfolio: Getting Featured Slider / Video or Image ***********/
if( !function_exists('thememount_get_portfolio_featured_content') ){
function thememount_get_portfolio_featured_content(){
	$featuredtype    = get_post_meta(get_the_ID(), '_thememount_portfolio_featured_featuredtype', true);
	$featuredtype    = $featuredtype[0];
	$startDiv = '<div>';
	$endDiv   = '</div>';
	
	switch($featuredtype){
		case 'image':
		default:
			if( has_post_thumbnail(get_the_ID()) ){
				echo $startDiv;
				the_post_thumbnail('full');
				echo $endDiv;
			} else {
				echo $startDiv;
				echo '<div class="thememount-no-image"><i class="tmicon-fa-image"></i></div>';
				echo $endDiv;
			}
			break;
			
		case 'video':
			echo $startDiv;
			echo '<div class="fluid-video">' . thememount_get_embed_code( get_post_meta( get_the_ID(), '_thememount_portfolio_featured_videourl', true) ) . '</div>';
			echo $endDiv;
			break;
			
		case 'audioembed':
			echo $startDiv;
			echo '<div class="fluid-audio">' . get_post_meta(get_the_ID(), '_thememount_portfolio_featured_audiocode', true).'</div>';
			echo $endDiv;
			break;
			
		case 'slider':
			echo $startDiv;
			echo thememount_featured_gallery_slider( 'portfolio' );
			echo $endDiv;
			
			
			break;
	}

}
}
/*******************************************************************/






/********************** Get YouTube/Vimeo embed code *************************/
if( !function_exists('thememount_get_embed_code') ){
	function thememount_get_embed_code($url){
		$width  = '853';
		$height = '480';
		$embed_code = wp_oembed_get($url);
		echo $embed_code;
		
		/*if (strpos($url, 'youtube') > 0) {
			preg_match(
					'/[\\?\\&]v=([^\\?\\&]+)/',
					$url,
					$matches
				);
			$id     = $matches[1];
			
			
			echo '<iframe width="' . $width . '" height="' . $height . '" src="//www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe>';
			
		} elseif (strpos($url, 'vimeo') > 0) {
		
			$id = (int) substr(parse_url($url, PHP_URL_PATH), 1);
			global $howes;
			echo '<iframe src="//player.vimeo.com/video/' . $id . '?title=0&amp;byline=0&amp;portrait=0&amp;color='.$howes['skincolor'].'" width="' . $width . '" height="' . $height . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}*/
	}
}
/*****************************************************************************/




/********************* Slider ***********************/
if( !function_exists('thememount_featured_gallery_slider') ){
function thememount_featured_gallery_slider( $postType='post' ){
	
	$wrapperClass = '';
	$metaPrefix   = '_thememount_post_gallery_';
	$wrapperClass = 'thememount-blog-media';
	
	if( 'portfolio' == $postType ){
		$metaPrefix   = '_thememount_portfolio_featured_';
		$wrapperClass = 'thememount-portfolio-media';
	} else if( 'post' == $postType ){
		$metaPrefix   = '_thememount_post_gallery_';
		$wrapperClass = 'thememount-blog-media';
	}
	$return = '';
	if( $metaPrefix!='' ){
		for($a=1; $a<=10; $a++){
			$slideImage = get_post_meta(get_the_ID(), $metaPrefix . 'slideimage'.$a, true);
			if( $slideImage!='' ){
				$return .= '<li>'.wp_get_attachment_image( $slideImage, 'full').'</li>';
			}
		}
		if( $return!='' ){
			$return = '<div class="'.$wrapperClass.' thememount-blog-media thememount-slider-wrapper"><div class="flexslider"><ul class="slides">' . $return . '</ul></div></div>';
		}
	}
	return $return;
}
}
/**************************************************/




/*********************** thememount_header_titlebar ****************************/
if( !function_exists('thememount_header_titlebar') ){
function thememount_header_titlebar(){
	global $howes;
	$hidetitlebar   = false;
	$hidebreadcrumb = false;
	//$icon           = 'arrow-right';
	$subtitle       = '';
	$titlebar_bg_image_type   = $howes['titlebar_bg_image_type'];
	$titlebar_bg_color        = $howes['titlebar_bg_color'];
	$titlebar_text_color      = $howes['titlebar_text_color'];
	$titlebar_bg_image        = $howes['titlebar_bg_image'];
	$titlebar_bg_custom_image = ( isset($howes['titlebar_bg_custom_image']['url']) ) ? $howes['titlebar_bg_custom_image']['url'] : '' ;
	
	
	
	if( is_page() ){ // Page
		$hidetitlebar   = get_post_meta( get_the_ID(), '_thememount_page_options_hidetitlebar', true );
		$title          = esc_attr( trim(get_post_meta( get_the_ID(), '_thememount_page_options_title', true)) );
		$subtitle       = esc_attr( trim(get_post_meta( get_the_ID(), '_thememount_page_options_subtitle', true)) );
		$hidebreadcrumb = trim(get_post_meta( get_the_ID(), '_thememount_page_options_hidebreadcrumb', true));
		//$icon           = trim(get_post_meta( get_the_ID(), '_thememount_page_options_icon', true));
		$title  = ( $title != '' ? $title : get_the_title( get_the_ID() ) );
		
		
		$page_titlebar_bg_image = trim(get_post_meta( get_the_ID(), '_thememount_page_options_titlebar_bg_image', true));
		$page_titlebar_bg_custom_image = wp_get_attachment_image_src(get_post_meta( get_the_ID(), '_thememount_page_options_titlebar_bg_image_custom', true) , 'full' );
		
		// Page option overriding global options : Predefined image
		if( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' && $page_titlebar_bg_image!='custom' ){
			$titlebar_bg_image_type = 'image';
			$titlebar_bg_image      = $page_titlebar_bg_image;
		}
		
		// Page option overriding global options : Custom image
		if( $page_titlebar_bg_image == 'custom' ){
			$titlebar_bg_image_type   = 'custom';
			$titlebar_bg_custom_image = @$page_titlebar_bg_custom_image[0];
		}
		
		
	} else if( function_exists('is_woocommerce')  && is_woocommerce() ){ // WooCommerce
		$hidetitlebar   = '';
		$title          = '';
		$subtitle       = '';
		$hidebreadcrumb = '';
		//$icon           = '';
		
		if ( is_search() ) {
			$title = sprintf( __( 'Search Results: &ldquo;%s&rdquo;', 'howes' ), get_search_query() );
			if ( get_query_var( 'paged' ) ){
				$title .= sprintf( __( '&nbsp;&ndash; Page %s', 'howes' ), get_query_var( 'paged' ) );
			}
		} elseif ( is_tax() ) {
			$title = single_term_title( "", false );
		} else {
			$shop_page_id = wc_get_page_id( 'shop' ); // Getting shop page ID
			
			$hidetitlebar   = get_post_meta( $shop_page_id, '_thememount_page_options_hidetitlebar', true );
			$title          = esc_attr( trim(get_post_meta( $shop_page_id, '_thememount_page_options_title', true)) );
			$subtitle       = esc_attr( trim(get_post_meta( $shop_page_id, '_thememount_page_options_subtitle', true)) );
			$hidebreadcrumb = trim(get_post_meta( $shop_page_id, '_thememount_page_options_hidebreadcrumb', true));
			//$icon           = trim(get_post_meta( $shop_page_id, '_thememount_page_options_icon', true));
			$title  = ( $title != '' ? $title : get_the_title( $shop_page_id ) );
			
			$page_titlebar_bg_image        = trim(get_post_meta( $shop_page_id, '_thememount_page_options_titlebar_bg_image', true));
			$page_titlebar_bg_custom_image = wp_get_attachment_image_src(get_post_meta( $shop_page_id, '_thememount_page_options_titlebar_bg_image_custom', true) , 'full' );
			//$titlebar_bg_image        = ( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' ) ? $page_titlebar_bg_image : $titlebar_bg_image;
			//$titlebar_bg_custom_image = ( $page_titlebar_bg_custom_image[0]!='' ) ? $page_titlebar_bg_custom_image[0] : $titlebar_bg_custom_image ;
			
			// Page option overriding global options : Predefined image
			if( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' && $page_titlebar_bg_image!='custom' ){
				$titlebar_bg_image_type = 'image';
				$titlebar_bg_image      = $page_titlebar_bg_image;
			}
			
			// Page option overriding global options : Custom image
			if( $page_titlebar_bg_image == 'custom' ){
				$titlebar_bg_image_type   = 'custom';
				$titlebar_bg_custom_image = @$page_titlebar_bg_custom_image[0];
			}
			
		}
		$woocommerce_Active = true;
		
	} else if( is_home() ){ // Blogroll
		if( get_option('page_for_posts') == 0 ){
			$hidetitlebar   = true;
		} else {
			$page_id        = get_option('page_for_posts');
			$hidetitlebar   = get_post_meta( $page_id, '_thememount_page_options_hidetitlebar', true );
			$title          = esc_attr( trim(get_post_meta( $page_id, '_thememount_page_options_title', true)) );
			$subtitle       = esc_attr( trim(get_post_meta( $page_id, '_thememount_page_options_subtitle', true)) );
			$hidebreadcrumb = get_post_meta( $page_id, '_thememount_page_options_hidebreadcrumb', true );
			//$icon           = trim(get_post_meta( $page_id, '_thememount_page_options_icon', true));
			$title          = ( $title != '' ? $title : get_the_title( $page_id ) );
			
			$page_titlebar_bg_image        = trim(get_post_meta( $page_id, '_thememount_page_options_titlebar_bg_image', true));
			$page_titlebar_bg_custom_image = wp_get_attachment_image_src(get_post_meta( $page_id, '_thememount_page_options_titlebar_bg_image_custom', true) , 'full' );
			
			//$titlebar_bg_image        = ( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' ) ? $page_titlebar_bg_image : $titlebar_bg_image ;
			//$titlebar_bg_custom_image = ( $page_titlebar_bg_image_custom[0]!='' ) ? $page_titlebar_bg_image_custom[0] : $titlebar_bg_custom_image ;
			
			// Page option overriding global options : Predefined image
			if( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' && $page_titlebar_bg_image!='custom' ){
				$titlebar_bg_image_type = 'image';
				$titlebar_bg_image      = $page_titlebar_bg_image;
			}
			
			// Page option overriding global options : Custom image
			if( $page_titlebar_bg_image == 'custom' ){
				$titlebar_bg_image_type   = 'custom';
				$titlebar_bg_custom_image = @$page_titlebar_bg_custom_image[0];
			}
			
		}
	} else if( is_single() ){ // Single Post
		$postType = get_post_type( get_the_ID() );
		switch($postType){
			case 'post':
				//$page_for_posts = get_option('page_for_posts');
				$hidetitlebar   = get_post_meta( get_the_ID(), '_thememount_post_options_hidetitlebar', true );
				$customtitle    = esc_attr( trim(get_post_meta( get_the_ID(), '_thememount_post_options_title', true)) );
				$rawtitle       = get_the_title( get_the_ID() );
				$title          = ($customtitle=='') ? $rawtitle : $customtitle ;
				$subtitle       = esc_attr( trim(get_post_meta( get_the_ID(), '_thememount_post_options_subtitle', true)) );
				$hidebreadcrumb = trim(get_post_meta( get_the_ID(), '_thememount_post_options_hidebreadcrumb', true));
				//$icon           = trim(get_post_meta( get_the_ID(), '_thememount_post_options_icon', true));
				$title          = ( $title != '' ? $title : get_the_title( get_the_ID() ) );
				
				/*
				$page_titlebar_bg_image        = trim(get_post_meta( get_the_ID(), '_thememount_post_options_titlebar_bg_image', true));
				$page_titlebar_bg_image_custom = wp_get_attachment_image_src(get_post_meta( get_the_ID(), '_thememount_post_options_titlebar_bg_image_custom', true) , 'full' );
				
				$titlebar_bg_image        = ( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' ) ? $page_titlebar_bg_image : $titlebar_bg_image ;
				$titlebar_bg_custom_image = ( $page_titlebar_bg_image_custom[0]!='' ) ? $page_titlebar_bg_image_custom[0] : $titlebar_bg_custom_image ;
				*/
				
				
				
				$post_titlebar_bg_image = trim(get_post_meta( get_the_ID(), '_thememount_post_options_titlebar_bg_image', true));
				$post_titlebar_bg_custom_image = wp_get_attachment_image_src(get_post_meta( get_the_ID(), '_thememount_post_options_titlebar_bg_image_custom', true) , 'full' );
				
				// Page option overriding global options : Predefined image
				if( $post_titlebar_bg_image!='' && $post_titlebar_bg_image!='global' && $post_titlebar_bg_image!='custom' ){
					$titlebar_bg_image_type = 'image';
					$titlebar_bg_image      = $post_titlebar_bg_image;
				}
				
				// Page option overriding global options : Custom image
				if( $post_titlebar_bg_image == 'custom' ){
						$titlebar_bg_image_type   = 'custom';
						$titlebar_bg_custom_image = @$post_titlebar_bg_custom_image[0];
				}
				
				
				
				
				break;

			case 'portfolio':
				$title          = get_the_title();
				$hidebreadcrumb = 'off';
				break;
				
			default:
				$title          = get_the_title();
				$hidebreadcrumb = 'off';
				break;
		}
		
	} else if( is_category() ){ // Category
		$adv_tbar_catarc = isset( $howes['adv_tbar_catarc'] ) ? $howes['adv_tbar_catarc'] : 'Category Archives: ' ;
		$title           = sprintf( __( $adv_tbar_catarc.' %s', 'howes' ), '<span>' . single_cat_title( '', false ) . '</span>' );
		$subtitle        = category_description();
		
	} else if( is_tag() ){ // Tag
		$adv_tbar_tagarc = isset( $howes['adv_tbar_tagarc'] ) ? $howes['adv_tbar_tagarc'] : 'Tag Archives: ' ;
		$title           = sprintf( __( $adv_tbar_tagarc.' %s', 'howes' ), '<span>' . single_tag_title( '', false ) . '</span>' );
		$subtitle        = tag_description();
		
	} else if( is_tax() ){ // Taxonomy
		global $wp_query;
		$adv_tbar_postclassified = isset( $howes['adv_tbar_postclassified'] ) ? $howes['adv_tbar_postclassified'] : 'Posts classified under: ' ;
		$tax                     = $wp_query->get_queried_object();
		if( is_tax('team_group') ){
			$title = sprintf( __( '%s', 'howes' ), '<span>' . $tax->name . '</span>' );
		} else {
			$title = sprintf( __( $adv_tbar_postclassified.' %s', 'howes' ), '<span>' . $tax->name . '</span>' );
		}
		
	} else if( is_author() ){ // Author
		if ( have_posts() ){
			the_post();
			$adv_tbar_authorarc = isset( $howes['adv_tbar_authorarc'] ) ? __($howes['adv_tbar_authorarc'],'howes') : __('Author Archives:','howes') ;
			$title              = sprintf( __( $adv_tbar_authorarc.' %s', 'howes' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
		}

	} else if( is_search()  ){ // Search Results
		$title    = sprintf( __( 'Search Results for <strong>%s</strong>', 'howes' ), '<span>' . get_search_query() . '</span>' );		
	
	} else if( is_404() ){ // 404
		if( function_exists('tribe_is_past') && function_exists('tribe_is_upcoming') && (tribe_is_past() || tribe_is_upcoming() || tribe_is_month() || tribe_is_day() && !is_tax()) ){
			$title = __( 'EVENTS', 'howes' );
			$hidebreadcrumb = 'on';
		} else {
			$hidetitlebar   = true;  // Hide Titlebox on 404 error page
		}
		
		
		//$title    = __( 'Page Not Found', 'howes' );
		//$hidebreadcrumb = 'on';
	
	} else if( is_archive() ){ // Archive
		
		if( is_post_type_archive() ){
			if( is_post_type_archive('team_member') ){
				$title = ( isset($howes['team_type_archive_title']) && trim($howes['team_type_archive_title'])!=''  ) ? $howes['team_type_archive_title'] : __('Team Members', 'howes') ;
			} else {
				$title = post_type_archive_title('', false);
			}
		} else if ( is_day() ){
			$title = sprintf( __( 'Daily Archives: %s', 'howes' ), '<span>' . get_the_date() . '</span>' );
		} elseif( is_month() ){
			$title = sprintf( __( 'Monthly Archives: %s', 'howes' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'howes' ) ) . '</span>' );
		} elseif( is_year() ){
			$title = sprintf( __( 'Yearly Archives: %s', 'howes' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'howes' ) ) . '</span>' );
		} else {
			if( function_exists('is_bbpress') && is_bbpress() ) {
				$title = __( 'Forum', 'howes' );
			} else {
				$title = __( 'Archives', 'howes' );
			}
		};
	
	
	} else if( function_exists('tribe_is_past') && function_exists('tribe_is_upcoming') && (tribe_is_past() || tribe_is_upcoming() || tribe_is_month() || tribe_is_day() && !is_tax()) ){
		$title = __( 'EVENTS', 'howes' );
		$hidebreadcrumb = 'on';
	
	} else {
		$title          = get_the_title();
		$hidebreadcrumb = 'on';
		
	}
	
	// Storing BG Image in another variable
	$bgimg = $titlebar_bg_image;
	
	//var_dump($titlebar_bg_image);
	
	
	// Theme Options : Hide Breadcrumb globally
	global $howes;
	//var_dump($howes['tbar_hide_bcrumb']);
	if( isset($howes['tbar_hide_bcrumb']) && $howes['tbar_hide_bcrumb']=='1' ){
		$hidebreadcrumb = 'on';
	}
	
	
	
	if( $hidetitlebar != 'on' ){
		$e_class  = ( $subtitle != '' ? 'thememount-with-subtitle' : 'thememount-without-subtitle' );
		$e_class .= ( $hidebreadcrumb == 'on' ? ' thememount-no-breadcrumb' : ' thememount-with-breadcrumb' );
		$e_class .= ( isset($titleNavigation) ? ' thememount-with-proj-navigation' : ' thememount-without-proj-navigation' );
		
		$subtitle = ($subtitle!='') ? '<br><span class="thememount-subtitle">'.do_shortcode(esc_attr($subtitle)).'</span>' : '' ;
		
			
		// Breadcrumb Class
		$e_class   .= ' thememount-header-without-breadcrumb';
		$h1Class    = 'headingblock';
		$bcClass    = 'breadcrumbblock';
		//$breadcrumb = true;  // Temporary patch
		if ( $hidebreadcrumb!='on' ) {
			$e_class .= ' thememount-header-with-breadcrumb';
			//$h1Class  = 'headingblock';
			//$bcClass  = 'breadcrumbblock';
		}
		
		// Custom Background Image
		$inlineCSS = '';
		if( $titlebar_bg_image_type=='custom' ){
			$inlineCSS = ( $titlebar_bg_custom_image!='' ) ? ' style="background-image:url(\''.$titlebar_bg_custom_image.'\');" ' : '' ;
		} else if( $titlebar_bg_image_type=='noimg' ){
			$bgimg = 'No';
		}

		$tbar_view = 'default';
		if( isset($howes['titlebar_view']) && trim($howes['titlebar_view'])!='' ){
			$tbar_view = trim($howes['titlebar_view']);
		}
		if( is_page() ){
			$tbar_view_page = trim(get_post_meta( $page_id, '_thememount_page_options_titlebar_view', true));
			if( $tbar_view_page!='' && $tbar_view_page!='global' ){
				$tbar_view = $tbar_view_page;
			}
		}
		
		
		
		?>
		

		<?php //var_dump($inlineCSS); ?>
		<div class="thememount-titlebar-wrapper entry-header <?php echo $e_class; ?> thememount-titlebar-bgimg-img<?php echo $bgimg; ?> thememount-titlebar-textcolor-<?php echo $titlebar_text_color; ?> tm-titlebar-view-<?php echo $tbar_view; ?>" <?php echo $inlineCSS; ?>>
			<div class="thememount-titlebar-inner-wrapper">
				<div class="thememount-titlebar-main">
					<div class="container">
						<div class="entry-title-wrapper <?php //echo $h1Class; ?>">
							<h1 class="entry-title"><?php echo do_shortcode($title); echo $subtitle; ?></h1>
						</div>
						<?php if($hidebreadcrumb!='on'){ ?>
							
							<?php
							
							echo '<div class="breadcrumb-wrapper">';
							
							if( 'portfolio' == get_post_type( get_the_ID() ) ){
								
								echo '<div class="thememount-pf-navbar-wrapper">';
								
								// Prev Link
								$prevPost = get_adjacent_post( false, '', true);
								if( $prevPost!=NULL && isset($prevPost) ){
									echo '<a href="'.get_permalink($prevPost->ID).'" title="'.esc_attr($prevPost->post_title).'"><i class="tmicon-fa-chevron-circle-left"></i></a>';
								} else {
									echo '<span class="thememount-dim"><i class="tmicon-angle-circled-left"></i></span>';
								}
								
								// Next Link
								$nextPost = get_adjacent_post( false, '', false);
								if( $nextPost!=NULL && isset($nextPost) ){
									echo '<a href="'.get_permalink($nextPost->ID).'" title="'.esc_attr($nextPost->post_title).'"><i class="tmicon-fa-chevron-circle-right"></i></a>';
								} else {
									echo '<span class="thememount-dim"><i class="tmicon-fa-chevron-circle-right"></i></span>';
								}
								
								echo '</div> <!-- .thememount-pf-navbar-wrapper -->';
								
							} else {
								
								if(function_exists('bcn_display')){
									echo '<!-- Breadcrumb NavXT output -->';
									bcn_display();
								} else if( function_exists('is_woocommerce') && is_woocommerce() ) {
									echo '<!-- woocommerce_breadcrumb -->';
									woocommerce_breadcrumb();
								} else {
									echo '<!-- thememount_get_breadcrumb_navigation -->';
									thememount_get_breadcrumb_navigation();
								}
							
							}
							
							echo '</div><!-- .breadcrumb-wrapper -->';
							
							?>
					
						<?php } // if($hidebreadcrumb!='on')  ?>
					</div><!-- .container -->
				</div><!-- .thememount-titlebar-main -->
			</div><!-- .thememount-titlebar-inner-wrapper -->
		</div><!-- .thememount-titlebar-wrapper -->

		
		<?php
	}
}
}
/***********************************************************************/










/********************  Darken/Lighten HEX color ***********************/
if( !function_exists('adjustBrightness') ){
function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}
}
/**********************************************************************/






/********************** Bootstrap 3 based columns *********************/
if( !function_exists('thememount_translateColumnWidthToSpan') ){
	function thememount_translateColumnWidthToSpan($width, $front = true) {
		switch ( $width ) {
			case "1/12" :
				$w = "col-xs-12 col-sm-1 col-md-1 col-lg-1";
				break;
			case "1/6" :
				$w = "col-xs-12 col-sm-2 col-md-2 col-lg-2";
				break;    
			case "1/4" :
				$w = "col-xs-12 col-sm-3 col-md-3 col-lg-3";
				break;
			case "1/3" :
				$w = "col-xs-12 col-sm-4 col-md-4 col-lg-4";
				break;
			case "5/12" :
				$w = "col-xs-12 col-sm-5 col-md-5 col-lg-5";
				break;
			case "1/2" :
				$w = "col-xs-12 col-sm-6 col-md-6 col-lg-6";
				break;
			case "7/12" :
				$w = "col-xs-12 col-sm-7 col-md-7 col-lg-7";
				break;
			case "2/3" :
				$w = "col-xs-12 col-sm-8 col-md-8 col-lg-8";
				break;    
			case "3/4" :
				$w = "col-xs-12 col-sm-9 col-md-9 col-lg-9";
				break;    
			case "5/6" :
				$w = "col-xs-12 col-sm-10 col-md-10 col-lg-10";
				break;
			case "11/12" :
				$w = "col-xs-12 col-sm-11 col-md-11 col-lg-11";
				break;
			case "1/1" :
				$w = "col-xs-12 col-sm-12 col-md-12 col-lg-12";
				break;
			default :
			$w = $width;
		}
		if( function_exists('get_custom_column_class') ){
			$custom = $front ? get_custom_column_class($w): false;
		} else {
			$custom = false;
		}
		return $custom ? $custom : $w;
	}
}
/**********************************************************************/






/************************ Breadcrumb Function **************************/
if( !function_exists('thememount_get_breadcrumb_navigation') ){
function thememount_get_breadcrumb_navigation() {

	/* === OPTIONS === */
	$text['home']     = 'Home'; // text for the 'Home' link
	$text['category'] = 'Archive by Category "%s"'; // text for a category page
	$text['search']   = 'Search Results for "%s" Query'; // text for a search results page
	$text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
	$text['author']   = 'Articles Posted by %s'; // text for an author page
	$text['404']      = 'Error 404'; // text for the 404 page

	$show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
	$show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
	$show_title     = 1; // 1 - show the title for the links, 0 - don't show
	$delimiter      = ' / '; // delimiter between crumbs
	$before         = '<span class="current">'; // tag before the current crumb
	$after          = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$home_link    = home_url('/');
	$link_before  = '<span typeof="v:Breadcrumb">';
	$link_after   = '</span>';
	$link_attr    = ' rel="v:url" property="v:title"';
	$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
	$parent_id = NULL;
	if( isset($post) ){
		$parent_id    = $parent_id_2 = $post->post_parent;
	}
	$frontpage_id = get_option('page_on_front');

	if (is_home() || is_front_page()) {

		if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

	} else {

		echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
		if ($show_home_link == 1) {
			echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
			if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
		}

		if ( is_category() ) {
			$this_cat = get_category(get_query_var('cat'), false);
			if ($this_cat->parent != 0) {
				$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
			}
			if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

		} elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;

		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
				if ($show_current == 1) echo $before . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($parent_id);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			//$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
			//$cats = str_replace('</a>', '</a>' . $link_after, $cats);
			//if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
			//echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_page() && !$parent_id ) {
			if ($show_current == 1) echo $before . get_the_title() . $after;

		} elseif ( is_page() && $parent_id ) {
			if ($parent_id != $frontpage_id) {
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					if ($parent_id != $frontpage_id) {
						$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					}
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
			}
			if ($show_current == 1) {
				if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
				echo $before . get_the_title() . $after;
			}

		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;

		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page', 'howes') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</div><!-- .breadcrumbs -->';

	}
} // end thememount_get_breadcrumb_navigation()
}
/***********************************************************************/









/*************************** Portfolio Box ****************************/
if( !function_exists('thememount_portfoliobox') ){
function thememount_portfoliobox( $column='' ){

	$return = '';
	
	// Getting all values
	$featuredtype = get_post_meta( get_the_ID(), '_thememount_portfolio_featured_featuredtype', true );
	$featuredtype = $featuredtype[0];

	// YouTube or Vimeo
	$videourl     = get_post_meta( get_the_ID(), '_thememount_portfolio_featured_videourl', true );

	// Video Player (HTML5)
	$videofile_mp4 =  get_post_meta( get_the_ID(), '_thememount_portfolio_featured_videofile_mp4', true );
	$videofile_webm = get_post_meta( get_the_ID(), '_thememount_portfolio_featured_videofile_webm', true );
	$videofile_ogv =  get_post_meta( get_the_ID(), '_thememount_portfolio_featured_videofile_ogv', true );

	// SoundCloud or other Audio embed code
	$audiocode = get_post_meta( get_the_ID(), '_thememount_portfolio_featured_audiocode', true );

	// Audio Player (HTML5)
	$audiofile_mp3 = get_post_meta( get_the_ID(), '_thememount_portfolio_featured_audiofile_mp3', true );
	$audiofile_wav = get_post_meta( get_the_ID(), '_thememount_portfolio_featured_audiofile_wav', true );
	$audiofile_oga = get_post_meta( get_the_ID(), '_thememount_portfolio_featured_audiofile_oga', true );

	$embedCodeDiv = '';

	
	switch($column){
		case 'two':
			$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
			break;
		case 'three':
			$boxClass = 'col-lg-4 col-sm-6 col-md-4 col-xs-12';
			break;
		case 'four':
		default:
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
		case 'mix':
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
		case 'fix':
			$boxClass = 'portfolio-slider-box-width';
			break;
	}

	



	$term_slugs = wp_get_post_terms( get_the_ID(), 'portfolio_category', array("fields" => "all") );
	$slugs = array();
	$terms = array();
	foreach( $term_slugs as $term ){
		$slugs[] = $term->slug;
		$terms[] = $term->name;
	}

	$likes = get_post_meta( get_the_ID(), 'thememount_likes', true );
	if( !$likes ){ $likes='0'; }

	$likeActiveClass = ( isset($_COOKIE["thememount_likes_".get_the_ID()]) ) ? 'like-active' : '' ;
	$likeIconClass   = ( isset($_COOKIE["thememount_likes_".get_the_ID()]) ) ? 'tmicon-fa-heart' : 'tmicon-fa-heart-o' ;

	$featuredLink = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
	$featuredImgURL = $featuredLink[0];

	// Featured type link
	switch($featuredtype){
		case 'image':
		default:
			$featuredLink = '<a href="' . $featuredImgURL . '" class="thememount_pf_featured" title="' . get_the_title() . '" data-rel="prettyPhoto"><i class="tmicon-fa-image"></i></a>';
			break;
		case 'video':
			$featuredLink = '<a href="' . $videourl . '" class="thememount_pf_featured" title="' . get_the_title() . '" data-rel="prettyPhoto"><i class="tmicon-fa-video-camera"></i></a>';
			break;
			
		/*case 'videoplayer':
			$embedCodeDiv = '';
			if($videofile_mp4!=''){  $embedCodeDiv .= '<source src="'.$videofile_mp4.'" type="video/mp4">'; }
			if($videofile_webm!=''){ $embedCodeDiv .= '<source src="'.$videofile_webm.'" type="video/webm">'; }
			if($videofile_ogv!=''){  $embedCodeDiv .= '<source src="'.$videofile_ogv.'" type="video/ogg">'; }
			
			if( $embedCodeDiv != '' ){
				$embedCodeDiv = '<div id="thememount-embed-code-'.get_the_ID().'" class="thememount-hide"><video width="320" height="240" controls>' . $embedCodeDiv . __('Your browser does not support the video tag.','howes').' </video></div>';
			} else {
				$embedCodeDiv = '<div id="thememount-embed-code-'.get_the_ID().'" class="thememount-hide">' . __('Please add video file in this portfolio.','howes').'</div>';
			}
			$featuredLink = '<a href="#" class="thememount_pf_featured" title="' . get_the_title() . '" data-rel="prettyPhoto"><i class="tmicon-videocam-2"></i></a>';
			break;*/
			
		case 'audioembed':
			$embedCodeDiv = '<div id="thememount-embed-code-'.get_the_ID().'" class="thememount-hide">'.$audiocode.'</div>';
			$featuredLink = '<a href="#thememount-embed-code-' . get_the_ID() . '" class="thememount_pf_featured" title="' . get_the_title() . '" data-rel="prettyPhoto"><i class="tmicon-fa-volume-down"></i></a>';
			break;
			
		/*case 'audioplayer':
			$featuredLink = '#thememount-embed-code-'.get_the_ID();
			
			$embedCodeDiv = '';
			if($audiofile_mp3!=''){ $embedCodeDiv .= '<source src="'.$videofile_mp3.'" type="video/mp3">'; }
			if($videofile_wav!=''){ $embedCodeDiv .= '<source src="'.$videofile_wav.'" type="video/wav">'; }
			if($videofile_oga!=''){ $embedCodeDiv .= '<source src="'.$videofile_oga.'" type="video/ogg">'; }
			
			if( $embedCodeDiv != '' ){
				$embedCodeDiv = '<div id="thememount-embed-code-'.get_the_ID().'" class="thememount-hide"><audio width="320" height="240" controls>' . $embedCodeDiv . __('Your browser does not support the audio element.','howes').' </audio></div>';
			} else {
				$embedCodeDiv = '<div id="thememount-embed-code-'.get_the_ID().'" class="thememount-hide">' . __('Please add video file in this portfolio.','howes') . '</div>';
			}
			
			$featuredIcon = 'music';  // icon
			break; */
			
		case 'slider':
			$embedCodeDiv = '<div id="#thememount-embed-code-' . get_the_ID() . '" class="thememount-hide">';
			$api_images = $api_titles = $api_desc = array();
			for($i=1; $i<=10; $i++){
				$img = get_post_meta( get_the_ID(), '_thememount_portfolio_featured_slideimage'.$i, true );
				if( $img != '' ){
					$imgdesc      = wp_get_attachment_image_src( $img, 'full' );
					$api_images[] = '"'.$imgdesc[0].'"';
					$api_titles[] = '"' . get_the_title() . '"';
					$api_desc[]   = '""';
				}
			}
			if( count($api_images)>0 ){
				$embedCodeDiv .= '<div class="thememount-hide thememount-pf-gallery-content"><script type="text/javascript">';
				//$api_images = implode(',',$api_images);
				$embedCodeDiv .= 'api_images_' . get_the_ID() . ' = [' . implode(',',$api_images) . '];';
				$embedCodeDiv .= 'api_titles_' . get_the_ID() . ' = [' . implode(',',$api_titles) . '];';
				$embedCodeDiv .= 'api_desc_' . get_the_ID() . '   = [' . implode(',',$api_desc) . '];';
				$embedCodeDiv .= '</script></div>';
			}
			$embedCodeDiv .= '</div>';

			$featuredLink = '<a href="#thememount-embed-code-' . get_the_ID() . '" class="thememount_pf_featured thememount-open-gallery" title="' . get_the_title() . '"><i class="tmicon-fa-image"></i></a>';

			break;
	}
	
	
	if( has_post_thumbnail() ){
		$featuredImg = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
	} else {
		$featuredImg = '<div class="thememount-proj-noimage"><i class="tmicon-fa-image"></i></div>';
	}
	
	$termList = ( is_array($terms) && count($terms)>0 ) ? '<p>'. implode(', ',$terms) .'</p>' : '' ;

	
	$return .= '
		<article class="portfolio-box ' . $boxClass . ' ' . implode(' ',$slugs) . ' thememount-box">
			<div class="item">
				<div class="item-thumbnail">
					' . $featuredImg . '
					<div class="overthumb"></div>
					<div class="icons">
						' . $featuredLink . '
						<a href="' . get_permalink() . '" class="thememount_pf_link"><i class="tmicon-fa-link"></i></a>
					</div>
				</div>
				<div class="item-content">					
					<!-- Like -->
					<div class="thememount-portfolio-likes-wrapper">
						<a class="thememount-portfolio-likes ' . $likeActiveClass . '" href="#" id="pid-' . get_the_ID() . '">
							<i class="'.$likeIconClass.'"></i> ' . $likes . '
						</a>
					</div>
					<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>
					' . $termList . '
				</div>
			</div>
			' . $embedCodeDiv . '
		</article>
	';
	
	return $return;
	
}// Function End
}
/**********************************************************************/




/*
 *  Events Box
 */
 if( !function_exists('thememount_eventsbox') ){
function thememount_eventsbox( $column='' ){
	$return = '';
	switch($column){
		case 'two':
			$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
			break;
		case 'three':
			$boxClass = 'col-lg-4 col-sm-6 col-md-4 col-xs-12';
			break;
		case 'four':
		default:
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
		case 'mix':
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
		case 'fix':
			$boxClass = 'portfolio-slider-box-width';
			break;
	}

	//  Featured Image
	if( has_post_thumbnail() ){
		$featuredImg = '<a href="' . get_permalink() . '">'.get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' ).'</a>';
	} else {
		$featuredImg = '<div class="thememount-proj-noimage"><i class="kwicon-fa-image"></i></div>';
	}
	
	$price = '';
	if( function_exists('tribe_get_formatted_cost') ){
		$cost = tribe_get_formatted_cost();
		if ( ! empty( $cost ) ){
			$price = '<div class="tribe-events-event-cost"> ' . esc_html( tribe_get_formatted_cost() ) . ' </div>';
		}
	}

	$return .= '
		<article class="events-box ' . $boxClass . ' thememount-box">
			<div class="item">
				<div class="item-thumbnail">
					' . $price . '
					' . $featuredImg . '
					<!--<div class="overthumb"></div>
					<div class="icons">
						<a href="' . get_permalink() . '" class="thememount_pf_link"><i class="kwicon-fa-link"></i></a>
					</div> -->
				</div>
				<div class="item-content">					
					<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>
				</div>
			</div>
		</article>
	';
	
	return $return;
	
}// Function End
}




/************************ Sortable List for IsoTOPE *****************************/
if( !function_exists('thememount_create_sortable_menu') ){
function thememount_create_sortable_menu( $list = array() ){
	if( is_array($list) && count($list)>0 ){
		
		$sortablelist = '<div class="container"><nav class="portfolio-sortable-list container"><ul class="col-xs-12">';
		$sortablelist .= '<li><a class="selected" href="#" data-filter="*">'._('All').'</a></li>';
		
		foreach($list as $slug=>$name){
			//var_dump($slug);
			$sortablelist .= '<li><a href="#" data-filter=".'.$slug.'">'.$name.'</a></li>';
		}
		
		$sortablelist .= '</ul></nav></div>';
		
		return $sortablelist;
		
	}
}
}
/********************************************************************************/










/************************ Testimonial Box *****************************/
if( !function_exists('thememount_testimonialbox') ){
function thememount_testimonialbox( $column='' ){
	$return      = '';
	$clienturl   = esc_url( trim(get_post_meta( get_the_id(), '_thememount_testimonials_details_clienturl', true )) );
	$designation = esc_attr( trim(get_post_meta( get_the_id(), '_thememount_testimonials_details_designation', true )) );
	
	$boxClass = '';
	
	switch($column){
		case 'one':
			$boxClass = 'col-lg-12 col-sm-12 col-md-12 col-xs-12';
			break;
		case 'two':
			$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
			break;
		case 'three':
			$boxClass = 'col-lg-4 col-sm-6 col-md-4 col-xs-12';
			break;
		case 'four':
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
	}
	
	$return .= "\n\t".'<div class="thememount-testimonial-box '.$boxClass.'">';
		
		$return .= '<div class="thememount-testimonial-data">';
		
		$iconCode = ( has_post_thumbnail() ) ? '<div class="thememount-testimonial-img">'.get_the_post_thumbnail( get_the_id(), 'thumbnail' ).'</div>'  :  '<span class="thememount-testimonial-icon"><i class="tmicon-fa-quote-left"></i></span>';
		
		$return .= '<blockquote class="thememount-testimonial-text">
				<div class="contarea">					
					<div class="thememount-tst-contarea-text">'.get_the_content('').'</div>
					
				</div>';
		$return .= '<footer>';
		
		$return .= ' '.$iconCode.' ';
		$return .= '<cite class="thememount-testimonial-title">';
		$return .= ( $clienturl!='' ) ? '<a href="' . $clienturl . '" target="_blank">' . get_the_title() . '</a>' : get_the_title() ;
		$return .= ( $designation!='' ) ? '<span class="thememount-testimonial-designation">'.$designation.'</span>' : '' ;
		$return .= '</cite></footer>';
		$return .= '</blockquote>';
		
		
		
		$return .= '</div>';
	$return .= "\n\t".'</div>';
	
	return $return;
}
}
/**********************************************************************/






/************************ Team Member Box *****************************/
if( !function_exists('thememount_teammemberbox') ){
function thememount_teammemberbox( $column='' ){
	global $post;
	$return   = '';
	$position = trim(get_post_meta( get_the_id(), '_thememount_team_member_details_position', true ));
	//$phone    = trim(get_post_meta( get_the_id(), '_thememount_team_member_details_phone', true ));
	$content  = trim($post->post_content);
	$excerpt  = trim($post->post_excerpt);
	
	/*if( $content!='' && $excerpt!='' ){
		$title = '<a href="'.get_permalink( get_the_ID() ).'">'.get_the_title().'</a>';
	} else {
		$title = get_the_title();
	}*/
	$title = '<a href="'.get_permalink( get_the_ID() ).'">'.get_the_title().'</a>';
	
	$boxClass = '';
	switch($column){
		case 'one':
			$boxClass = 'col-lg-12 col-sm-12 col-md-12 col-xs-12';
			break;
		case 'two':
			$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
			break;
		case 'three':
			$boxClass = 'col-lg-4 col-sm-6 col-md-4 col-xs-12';
			break;
		case 'four':
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
	}
	
	
	if( trim($position)!='' ){ $position = '<h4 class="thememount-team-position">'.__($position, 'apicona').'</h4>'; }
	//if( trim($phone)!='' ){ $phone = '<h6 class="thememount-team-phone">'.__($phone, 'apicona').'</h6>'; }
	//if( trim($email)   !='' ){ $email = '<span class="thememount-team-email"><a href="mailto:'.$email.'">'.$email.'</a></span>'; }
	//if( trim($email)   !='' ){ $email = '<div class="overthumb"></div><div class="thememount-team-icons"><a href="mailto:'.$email.'" class="thememount-team-email"><i class="tmicon-fa-envelope-o"></i></a></div>'; }
	
	// Team Group
	$categories_list = get_the_term_list( get_the_ID(), 'team_group', '', __( ' &nbsp; &middot; &nbsp; ', 'howes' ) );
	
	if( $categories_list!='' ){
		$categories_list = '<div class="thememount-team-cat-links">'.$categories_list.'</div>';
	}
	
	
	
	/*$facebook   = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_facebook', true ));
	$twitter    = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_twitter', true ));
	$linkedin   = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_linkedin', true ));
	$googleplus = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_googleplus', true ));
				
	$socialcode = '';
	if($facebook!=''){   $socialcode .= '<li class="thememount-social-facebook"><a href="'.$facebook.'"><i class="tmicon-fa-facebook"></i></a></li>'; }
	if($twitter!=''){    $socialcode .= '<li class="thememount-social-twitter"><a href="'.$twitter.'"><i class="tmicon-fa-twitter"></i></a></li>'; }
	if($linkedin!=''){   $socialcode .= '<li class="thememount-social-linkedin"><a href="'.$linkedin.'"><i class="tmicon-fa-linkedin"></i></a></li>'; }
	if($googleplus!=''){ $socialcode .= '<li class="thememount-social-gplus"><a href="'.$googleplus.'"><i class="tmicon-fa-google-plus"></i></a></li>'; }
	if($email!=''){      $socialcode .= '<li class="thememount-social-email"><a href="mailto:'.$email.'"><i class="tmicon-fa-envelope-o"></i></a></li>'; }
	if($socialcode!=''){ $socialcode = '<div class="thememount-team-social-links"><ul>'.$socialcode.'</ul></div>'; }*/
	
	$socialcode = thememount_team_social();

	$return .= "\n\t".'<div class="thememount-team-box '.$boxClass.'">';
		$return .= '<div class="thememount-team-img">';
			//$return .= $socialcode;
			if( has_post_thumbnail() ){ $return .= get_the_post_thumbnail( get_the_id(), 'full' ); }
		//$return .= '<div class="icons"><a href="#" class="thememount_pf_featured"><i class="tmicon-mail"></i></a></div></div><!-- .thememount-team-img -->';
		//$return .= $email;
		$return .= '<div class="overthumb"></div>';
		$return .= $socialcode;
		$return .= '</div><!-- .thememount-team-img -->';
		$return .= '<div class="thememount-team-data">';
			$return .= '<h3 class="thememount-team-title">'.$title.'</h3>';
			$return .= $position;
			//$return .= $phone;
			$return .= get_the_excerpt();
			$return .= $categories_list;
			
		$return .= '</div>';
	$return .= "\n\t".'</div>';
	return $return;
}
}

if( !function_exists('thememount_team_social') ){
function thememount_team_social( $column='' ){
	$facebook   = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_facebook', true ));
	$twitter    = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_twitter', true ));
	$linkedin   = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_linkedin', true ));
	$googleplus = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_googleplus', true ));
	$instagram  = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_instagram', true ));
	$email      = trim(get_post_meta( get_the_id(), '_thememount_team_member_details_email', true ));
	
	$socialcode = '';
	if($facebook!=''){   $socialcode .= '<li class="thememount-social-facebook"><a href="'.esc_url($facebook).'" title="Facebook" target="_blank"><i class="tmicon-fa-facebook"></i></a></li>'; }
	if($twitter!=''){    $socialcode .= '<li class="thememount-social-twitter"><a href="'.esc_url($twitter).'" title="Twitter" target="_blank"><i class="tmicon-fa-twitter"></i></a></li>'; }
	if($linkedin!=''){   $socialcode .= '<li class="thememount-social-linkedin"><a href="'.esc_url($linkedin).'" title="LinkedIn" target="_blank"><i class="tmicon-fa-linkedin"></i></a></li>'; }
	if($googleplus!=''){ $socialcode .= '<li class="thememount-social-gplus"><a href="'.esc_url($googleplus).'" title="Google+" target="_blank"><i class="tmicon-fa-google-plus"></i></a></li>'; }
	if($instagram!=''){ $socialcode .= '<li class="thememount-social-instagram"><a href="'.esc_url($instagram).'" title="Instagram" target="_blank"><i class="tmicon-fa-instagram"></i></a></li>'; }
	if($email!=''){      $socialcode .= '<li class="thememount-social-email"><a href="mailto:'.sanitize_email($email).'" title="Email" target="_blank"><i class="tmicon-fa-envelope-o"></i></a></li>'; }
	if($socialcode!=''){ $socialcode = '<div class="thememount-team-social-links"><ul>'.$socialcode.'</ul></div>'; }
	
	return $socialcode;
}
}
/**********************************************************************/



if( !function_exists('thememount_one_page_site') ){
function thememount_one_page_site(){
	global $howes;
	if( isset($howes['one_page_site']) && $howes['one_page_site']=='1' ){
	?>
	
	<script type="text/javascript">
		var x = 1;
		jQuery('.mega-menu a, .menu-main-menu-container a').each(function(){
			if( x != 1 ){
				jQuery(this).parent().removeClass('mega-current-menu-item mega-current_page_item current-menu-ancestor current-menu-item current_page_item');
			}
			x = 0;
		});
	</script>
	
	<?php
	}
}
}





/*************************** Blog Box ****************************/
if( !function_exists('thememount_blogbox') ){
function thememount_blogbox( $column='' ){
	global $howes;
	$return = '';
	
	// Getting Post Format
	$format = get_post_format();
	
	if( $format == false || $format == '' ){
		$format = 'standard';
	}
	
	// Date Box
	$title            = '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
	$date             = '<div class="thememount-postbox-small-date">'.thememount_entry_box_date(false).'</div>';
	$featuredLink     = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
	$featuredImgURL   = $featuredLink[0];
	$featuredLinkArea = '';
	$featuredContent  = '';
	
	if( has_post_thumbnail() ){
		$featuredContent = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
	} else {
		$featuredContent = '<div class="thememount-proj-noimage"><i class="tmicon-fa-image"></i></div>';
	}
	
	switch( $format ){
		case 'standard':
		default:
			if( has_post_thumbnail() ){
				$featuredContent = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
			} else {
				$featuredContent = '<div class="thememount-proj-noimage"><i class="tmicon-fa-image"></i></div>';
			}
			break;
		case 'quote':
			$title = '';
			if( !has_post_thumbnail() ){
				$featuredContent = '<div class="thememount-proj-noimage"><i class="tmicon-fa-quote-left"></i></div>';
			}
			break;
		case 'video':
			$videocode = trim( get_post_meta( get_the_ID(), '_format_video_embed', true) );
			if( $videocode!='' ){
				//$featuredContent = wp_oembed_get($videocode);
				if( strpos($videocode, 'http') === 0 ){
					$featuredContent = wp_oembed_get($videocode);
				} else {
					$featuredContent = $videocode;
				}
			}
			$featuredLinkArea = '';
			break;
			
		case 'audio':
			$audiocode = trim( get_post_meta( get_the_ID(), '_format_audio_embed', true) );
			if( $audiocode!='' ){
				$featuredContent = wp_oembed_get($audiocode);
				if( $featuredContent!=false ){
					$featuredContent = wp_oembed_get($audiocode);
				} else {
					$featuredContent = $audiocode;
				}
			}
			$featuredLinkArea = '';
			break;
			
		case 'gallery':
			$featuredContent = thememount_featured_gallery_slider('post');
			if( $featuredContent=='' ){
				if( has_post_thumbnail() ){
					$featuredContent = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
				} else {
					$featuredContent = '<div class="thememount-proj-noimage"><i class="tmicon-fa-image"></i></div>';
				}
			} else {
				$featuredLinkArea = '';
			}
			break;
	}
	
	
	switch($column){
		case 'one':
			$boxClass = 'col-lg-12 col-sm-12 col-md-12 col-xs-12';
			break;
		case 'two':
			$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
			break;
		case 'three':
			$boxClass = 'col-lg-4 col-sm-6 col-md-4 col-xs-12';
			break;
		case 'four':
		default:
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
		case 'mix':
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
		case 'fix':
			$boxClass = 'blog-slider-box-width';
			break;
	}
	
	// Adding Post format class to box
	$boxClass .= ' thememount-blogbox-format-'.$format;
	
	
	
	
	/***************************/
	
	if( has_post_thumbnail() ){
		$featuredImg = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
	} else {
		$featuredImg = '<div class="thememount-proj-noimage"><i class="tmicon-fa-image"></i></div>';
	}
	
	$slugs = wp_get_post_terms( get_the_ID(), 'category', array("fields" => "slug"));
	$slugs   = implode( ' ', $slugs );
	
	
	/* Short Description */
	$description = '';
	$readMore    = __('Read More', 'howes') . '<i class="tmicon-fa-angle-right"></i>';
	if( isset( $howes['blog_text_limit'] ) && $howes['blog_text_limit']>0 ){
		$description  = tm_get_short_desc();
		$description .= thememount_wrap_readmore('<a href="'.get_permalink().'">'.$readMore.'</a>');
	} else if( has_excerpt() ){
		$description  = get_the_excerpt();
		$description .= thememount_wrap_readmore('<a href="'.get_permalink().'">'.$readMore.'</a>');
	} else {
		//$description = thememount_string_shorten( get_the_content(), 130 );
		global $more;
		$more = 0;
		$description = get_the_content( $readMore );
		/*$description = apply_filters( 'the_content', get_the_content() );
		$description = str_replace( ']]>', ']]&gt;', $description );*/
	}
	
	$categories_list = get_the_category_list( __( ', ', 'howes' ) ); // Translators: used between list items, there is a space after the comma.
	$categories_list = ( $categories_list ) ? '<span class="categories-links"><i class="tmicon-fa-folder-open"></i> ' . $categories_list . '</span>' : '' ;
	
	$comments = wp_count_comments(); $comments = $comments->approved; //Get Total Comments
	$commentsCode = '';
	if( $comments > 0 ){
		$commentsCode  = '<span class="comments"><i class="tmicon-fa-comment"></i> '.get_comments_number( 'no comments', '1', '%' ).'</span>';
	}
	 
	 $metaDetails = '';
	 if( $column != 'one' && ($categories_list!='' || $comments!='') ){
		$metaDetails = '<div class="entry-meta thememount-blogbox-entry-meta"><div class="thememount-meta-details">' . $categories_list . '</div></div>';
	 }
	
	if( $featuredContent == '' ){
		$featuredContent = '<div class="thememount-proj-noimage"><i class="tmicon-fa-image"></i></div>';
	}
	
	$return .= '
		<article class="post-box ' . $boxClass . ' ' . $slugs . '">
			<div class="post-item">
				<div class="post-item-thumbnail">
					<div class="post-item-thumbnail-inner">
						'.$date.'
						' . $featuredContent . '
					</div>
					<div class="overthumb"></div>
					' . $featuredLinkArea . '
				</div>
				<div class="item-content">
					'.$title.'
					'.thememount_entry_meta(false).'
					<div class="thememount-blogbox-desc">' . $description . '</div>
				</div>
			</div>
		</article>
	';

	
	return $return;
	
}// Function End
}
/**********************************************************************/







/**********************  ************************/
if( !function_exists('thememount_string_shorten') ){
function thememount_string_shorten($text, $char) {
	$text = substr($text, 0, $char); //First chop the string to the given character length
	if(substr($text, 0, strrpos($text, ' '))!='') $text = substr($text, 0, strrpos($text, ' ')); //If there exists any space just before the end of the chopped string take upto that portion only.
	//In this way we remove any incomplete word from the paragraph
	$text = $text.'...'; //Add continuation ... sign
	return $text; //Return the value
}
}
/*****************************************************************/




if( !function_exists('thememount_addhttp') ){
	function thememount_addhttp($url){
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)){
			$url = "http://" . $url;
		}
		return $url;
	}
}





if( !function_exists('thememount_buildStyle') ){
function thememount_buildStyle($bg_image = '', $bg_color = '', $bg_image_repeat = '', $font_color = '', $padding_top = '', $padding_bottom = '', $margin_bottom = '', $margin_top = '') {
	$has_image = false;
	$style = '';
	if((int)$bg_image > 0 && ($image_url = wp_get_attachment_url( $bg_image, 'large' )) !== false) {
		$has_image = true;
		$style .= "background-image: url(".$image_url.");";
	}
	if(!empty($bg_color)) {
		$style .= 'background-color: '.$bg_color.';';
	}
	if(!empty($bg_image_repeat) && $has_image) {
		if($bg_image_repeat === 'cover') {
			$style .= "background-repeat:no-repeat;background-size: cover;";
		} elseif($bg_image_repeat === 'contain') {
			$style .= "background-repeat:no-repeat;background-size: contain;";
		} elseif($bg_image_repeat === 'no-repeat') {
			$style .= 'background-repeat: no-repeat;';
		}
	}
	if( !empty($font_color) ) {
		$style .= 'color: '.$font_color.';';
	}
	if( $padding_top != '' ) {
		$style .= 'padding-top: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_top) ? $padding_top : $padding_top.'px').';';
	}
	if( $padding_bottom != '' ) {
		$style .= 'padding-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_bottom) ? $padding_bottom : $padding_bottom.'px').';';
	}
	if( $margin_bottom != '' ) {
		$style .= 'margin-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $margin_bottom) ? $margin_bottom : $margin_bottom.'px').';';
	}
	if( $margin_top != '' ) {
		$style .= 'margin-top: '.(preg_match('/(px|em|\%|pt|cm)$/', $margin_top) ? $margin_top : $margin_top.'px').';';
	}
	return empty($style) ? $style : ' style="'.$style.'"';
}
}





function tm_get_short_desc(){
	global $howes;
	//$description = '';
	$content = '';
	if( isset( $howes['blog_text_limit'] ) && $howes['blog_text_limit']>0 ){
		/*$description = get_the_content();
		$description = preg_replace(" (\[.*?\])",'',$description);
		$description = strip_shortcodes($description);
		$description = strip_tags($description);
		$description = substr($description, 0, $howes['blog_text_limit']);
		$description = substr($description, 0, strripos($description, " "));
		$description = trim(preg_replace( '/\s+/', ' ', $description));
		$description = $description.'...';*/
		
		$content = get_the_content('',FALSE,'');
		//$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]>', $content);
		$content = substr($content,0, $howes['blog_text_limit'] );
		$content = trim(preg_replace( '/\s+/', ' ', $content));
		$content = $content.'...';
	}
	return $content;
}


/******************** CSS Parser *********************/

function thememountCheckBGImage($css){
	$return = false;
	
	if( trim($css)!='' ){
		
		// Check if background image exists
		$newCSS = str_replace( 'http://', 'http//', $css );

		// Removing breackets
		$newCSS = explode('{', $newCSS);
		$newCSS = explode('}', $newCSS[1]);
		$newCSS = $newCSS[0];

		// Filtering background properties
		$newCSS = explode(';', $newCSS);

		foreach( $newCSS as $css ){
			$x = '';
			$x = explode(':', $css);
			if( $x[0] == 'background' ){
				if (strpos($x[1] , 'url(') !== false) {
					$return = true;
				}
			} else if( $x[0] == 'background-image' ){
				$return = true;
			}
		}
	}
	
	return $return;
}

/******************************************************/
