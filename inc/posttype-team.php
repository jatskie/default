<?php 
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');

/*
 * SLUG settings
 */
global $howes;
//var_dump($howes['team_type_slug']);
//var_dump($howes['team_group_slug']);

/******************************************/
/****** generating Custom Post Type *******/

// Team Member section
// Icon List for "menu_icon" : http://melchoyce.github.io/dashicons/

$tm_team_type_title = trim($howes['team_type_title']);

if( substr($tm_team_type_title , -1)=='s' ){
	// Team Members
	$team_type_title          = $tm_team_type_title;
	$team_type_title_singluar =  substr_replace( $tm_team_type_title , "", -1);
} else {
	// Team Member
	$team_type_title          = $tm_team_type_title.'s';
	$team_type_title_singluar =  $tm_team_type_title;
}

$team_type_slug = 'team-members';
if( isset($howes['team_type_slug']) && trim($howes['team_type_slug'])!='' ){
	$team_type_slug = trim($howes['team_type_slug']);
}



$team = new Cuztom_Post_Type( 'team_member',
	array(
		'has_archive'         => true,
		'exclude_from_search' => false, // Whether to exclude posts with this post type from front end search results.
		'publicly_queryable'  => true, // Whether queries can be performed on the front end as part of parse_request().
		'supports'            => array( 'title', 'thumbnail', 'editor', 'excerpt' ),
		/*'labels'              => array(
							'name'          => __( $team_type_title, 'howes'),
							'singular_name' => __( $team_type_title_singluar, 'howes')
		),*/
		'menu_icon'           => 'dashicons-groups',
		'rewrite'             => array( 'slug' => $team_type_slug ),
		'query_var'           => $team_type_slug,
	), array(
		'name'               => __($team_type_title,'howes'),
		'singular_name'      => __($team_type_title_singluar,'howes'),
		'add_new'            => __('Add New','howes'),
		'add_new_item'       => __('Add New '.$team_type_title_singluar,'howes'),
		'edit_item'          => __('Edit '.$team_type_title_singluar,'howes'),
		'new_item'           => __('New '.$team_type_title_singluar,'howes'),
		'all_items'          => __('All '.$team_type_title,'howes'),
		'view_item'          => __('View '.$team_type_title_singluar,'howes'),
		'search_items'       => __('Search '.$team_type_title,'howes'),
		'not_found'          => __('No '.$team_type_title.' found','howes'),
		'not_found_in_trash' => __('No '.$team_type_title.' found in Trash','howes'),
		'parent_item_colon'  => '',
		'menu_name'          => __($team_type_title ,'howes')
  )
	);
/*****************************************/



//'slug' =>



// Move Featured Image box from left to center only on CLIENTS custom_post_type
add_action('do_meta_boxes', 'team_featured_image_box');
function team_featured_image_box() {
	remove_meta_box( 'postimagediv', 'customposttype', 'side' );
	add_meta_box('postimagediv', __('Member\'s Image','howes'), 'post_thumbnail_meta_box', 'team_member', 'normal', 'high');
}


/*********** Post Meta Box **************/
$team->add_meta_box(
	'thememount_team_member_details',
	__('Team Member\'s Details', 'howes'),
	array(
		array(
			'name'          => 'position',
			'label'         => __( 'Position', 'howes'),
			'description'   => __( '(Optional) Add member\'s position. Example: <code>Project Manager</code>', 'howes'),
			'type'          => 'text'
		),
		array(
			'name'          => 'email',
			'label'         => __( 'Email', 'howes'),
			'description'   => __( '(Optional) Add member\'s email address. Example: <code>member@example.com</code>', 'howes'),
			'type'          => 'text'
		),
		array(
			'name'          => 'phone',
			'label'         => __( 'Phone', 'howes'),
			'description'   => __( '(Optional) Add member\'s phone number. Example: <code>+91-0123-456789</code>', 'howes'),
			'type'          => 'text'
		),
	)
);

$team->add_meta_box(
	'thememount_team_member_social_links',
	__('Member\'s Social Links', 'howes'),
	array(
		array(
			'name'          => 'facebook',
			'label'         => __( 'Facebook Link', 'howes'),
			'description'   => __( '(Optional) Please fill Facebook link', 'howes'),
			'type'          => 'text'
		),
		array(
			'name'          => 'twitter',
			'label'         => __( 'Twitter Link', 'howes'),
			'description'   => __( '(Optional) Please fill Twitter link', 'howes'),
			'type'          => 'text'
		),
		array(
			'name'          => 'linkedin',
			'label'         => __( 'LinkedIn Link', 'howes'),
			'description'   => __( '(Optional) Please fill LinkedIn link', 'howes'),
			'type'          => 'text'
		),
		array(
			'name'          => 'googleplus',
			'label'         => __( 'Google+ Link', 'howes'),
			'description'   => __( '(Optional) Please fill Google+ link', 'howes'),
			'type'          => 'text'
		),
		array(
			'name'          => 'instagram',
			'label'         => __( 'Instagram Link', 'howes'),
			'description'   => __( '(Optional) Please fill Instagram link', 'howes'),
			'type'          => 'text'
		),
	)
);
/**********************************************/



/* Team Group */
$team->add_taxonomy( 'team_group', array(
	'rewrite'             => array( 'slug' => $howes['team_group_slug'] ),
) );









/********** Adding featured image URL path ***********/



// A callback function to add a custom field to our "presenters" taxonomy
function thememount_team_group_taxonomy_custom_fields($tag) {
   // Check for existing taxonomy meta for the term you're editing
    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
?>

<tr class="form-field">
	<th scope="row" valign="top">
		<label for="thememount_img_url"><?php _e('Featured Image URL', 'howes'); ?></label>
	</th>
	<td>
		<input type="text" name="term_meta[thememount_img_url]" id="term_meta[thememount_img_url]" size="40" value="<?php echo $term_meta['thememount_img_url'] ? $term_meta['thememount_img_url'] : ''; ?>"><br />
		<span class="description"><?php _e('Paste featured image URL for this group. Please upload first in media section.' ,'howes'); ?></span>
	</td>
</tr>

<?php
}







// A callback function to save our extra taxonomy field(s)
function thememount_save_taxonomy_custom_fields( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_term_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
            foreach ( $cat_keys as $key ){
            if ( isset( $_POST['term_meta'][$key] ) ){
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array
        update_option( "taxonomy_term_$t_id", $term_meta );
    }
}






// Add the fields to the "presenters" taxonomy, using our callback function
add_action( 'team_group_edit_form_fields', 'thememount_team_group_taxonomy_custom_fields', 10, 2 );

// Save the changes made on the "presenters" taxonomy, using our callback function
add_action( 'edited_team_group', 'thememount_save_taxonomy_custom_fields', 10, 2 );
