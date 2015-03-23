<?php

// [team show="0"]
if( !function_exists('thememount_sc_team') ){
function thememount_sc_team($atts, $content=NULL ) {
	extract( shortcode_atts( array(
		'title'     => '',
		'subtitle'  => '',
		'align'     => 'left',
		'groupslug' => '',
		'show'      => '4',
		'column'    => 'four',
		'view'      => '',
		//'style'   => 'default'
	), $atts ) );
	
	
	// Box width
	$boxwidth       = ( $view == 'carousel' ) ? 'fix' : $column ;
	$rowClass       = ( $view != 'carousel' ) ? 'row' : '' ;
	$headerCarslBtn = ( $view == 'carousel' ) ? 'carouselbtn="yes"' : '' ;
	$itemWrapper    = ( $view == 'carousel' ) ? 'thememount-carousel-items-wrapper' : '' ;
	$itemCol        = ( $view == 'carousel' ) ? 'thememount-carousel-col-'.$column : '' ;
	$rowClass       = ( $view == 'carousel' ) ? $rowClass : $rowClass.' multi-columns-row' ;
	
	
	$return = '';
	$width  = thememount_translateColumnWidthToSpan($column);
	
	$args = array(
		'post_type'      => 'team_member',
		'posts_per_page' => $show,
	);
	
	if( $groupslug != '' ){
		$args['team_group'] = $groupslug;
	}
	$results = new WP_Query( $args );
	
	// The Loop
	if ( $results->have_posts() ) {
		$return .= "\n\t".'<div class="thememount-team-wrapper thememount-effect-'.$view.' thememount-items-col-'.$column.' '.$itemCol.'">';
		if( trim($title)!='' ){
			$return .= "\n\t" . do_shortcode('[heading text="'.$title.'" subtext="'.do_shortcode($subtitle).'" tag="h2" '.$headerCarslBtn.' style="linedot" align="'.$align.'"]');
		}
		$return .= '<div class="'.$rowClass.' thememount-items-wrapper '.$itemWrapper.'">';
		
		while ( $results->have_posts() ) {
			$results->the_post();
			
			$return .= thememount_teammemberbox( $boxwidth );
			
		}
		$return .= "\n\t".'</div></div>';
	} else {
		// no posts found
	}
	
	
	
	/*
	$results = new WP_Query( $args );
	
	// The Loop
	
	$return .= '<div class="'.$rowClass.' thememount-items-wrapper '.$itemWrapper.'">';
	
	if ( $results->have_posts() ) {
		$return .= "\n\t".'<div class="thememount-team-wrapper container">';
		//$return .= ($style=='default') ? '<ul class="row">' : '<ul class="tm-grid">' ;
		$return .= '<ul class="row">';
		
		while ( $results->have_posts() ) {
			$results->the_post();
			global $post;
			
			$position = trim(get_post_meta( get_the_id(), '_thememount_team_member_details_position', true ));
			$email    = trim(get_post_meta( get_the_id(), '_thememount_team_member_details_email', true ));
			$content  = trim($post->post_content);
			$excerpt  = trim($post->post_excerpt);
			
			if( $content!='' && $excerpt!='' ){
				$title = '<a href="'.get_permalink( get_the_ID() ).'">'.get_the_title().'</a>';
			} else {
				$title = get_the_title();
			}
			
			if( trim($position)!='' ){ $position = '<h4 class="thememount-team-position">'.$position.'</h4>'; }
			//if( trim($email)   !='' ){ $email = '<span class="thememount-team-email"><a href="mailto:'.$email.'">'.$email.'</a></span>'; }
			//if( trim($email)   !='' ){ $email = '<div class="overthumb"></div><div class="thememount-team-icons"><a href="mailto:'.$email.'" class="thememount-team-email"><i class="tmicon-fa-envelope-o"></i></a></div>'; }
			
			
			$facebook   = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_facebook', true ));
			$twitter    = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_twitter', true ));
			$linkedin   = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_linkedin', true ));
			$googleplus = trim(get_post_meta( get_the_id(), '_thememount_team_member_social_links_googleplus', true ));
						
			$socialcode = '';
			if($facebook!=''){   $socialcode .= '<li class="thememount-social-facebook"><a href="'.$facebook.'"><i class="tmicon-fa-facebook"></i></a></li>'; }
			if($twitter!=''){    $socialcode .= '<li class="thememount-social-twitter"><a href="'.$twitter.'"><i class="tmicon-fa-twitter"></i></a></li>'; }
			if($linkedin!=''){   $socialcode .= '<li class="thememount-social-linkedin"><a href="'.$linkedin.'"><i class="tmicon-fa-linkedin"></i></a></li>'; }
			if($googleplus!=''){ $socialcode .= '<li class="thememount-social-gplus"><a href="'.$googleplus.'"><i class="tmicon-fa-google-plus"></i></a></li>'; }
			if($email!=''){      $socialcode .= '<li class="thememount-social-email"><a href="mailto:'.$email.'"><i class="tmicon-fa-envelope-o"></i></a></li>'; }
			if($socialcode!=''){ $socialcode = '<div class="thememount-team-social-links"><ul>'.$socialcode.'</ul></div>'; }
			
		
			$return .= "\n\t".'<li class="thememount-team-box '.$width.'">';
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
					$return .= get_the_excerpt();
					
				$return .= '</div>';
			$return .= "\n\t".'</li>';

			
		}
		$return .= "\n\t".'</ul></div>';
	} else {
		// no posts found
	}
	
	$return .= '</div>';
	
	*/
	
	
	
	/* Restore original Post Data */
	wp_reset_postdata();
	
	return $return;
}
}
add_shortcode( 'team', 'thememount_sc_team' );