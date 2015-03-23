<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @subpackage  Field_Color
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @version     3.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')){
    exit;
}

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_thememount_pre_color_packages' ) ) {

    /**
     * Main ReduxFramework_thememount_skin_color class
     *
     * @since       1.0.0
     */
	//class ReduxFramework_thememount_skin_color extends ReduxFramework {
	class ReduxFramework_thememount_pre_color_packages{
	
		/**
		 * Field Constructor.
		 *
		 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
		 *
	 	 * @since 		1.0.0
	 	 * @access		public
	 	 * @return		void
		 */
		function __construct( $field = array(), $value ='', $parent ) {
        
			//parent::__construct( $parent->sections, $parent->args );
			$this->parent = $parent;
			$this->field = $field;
			$this->value = $value;
        
		}
	
		/**
		 * Field Render Function.
		 *
		 * Takes the vars and outputs the HTML for the field in the settings
	 	 *
	 	 * @since 		1.0.0
	 	 * @access		public
	 	 * @return		void
		 */
		function render() {
			
			$colorList = array(
				/* Color number => array( 
					'skincolor',
					'topbarbgcolor',
					'topbar_text_color',
					'headerbgcolor',
					'footerwidget_bgcolor',
					'footertext_bgcolor'
				) */
				'1' => array(
					'e85e16',
					'192133',
					'212c43',
					'212c43',
					'192133'
				),
				'2' => array(
					'dd4c42',
					'232527',
					'363b3f',
					'363b3f',
					'232527'
				),
			);
			
			
			echo '<div class="thememount-pre-color-packages-wrapper">';
			echo '<div class="thememount-pre-color-packages">';

			
			$colorlist = array( 'Default', 'Dark', 'Dark Cherry', 'Dark Chololate', 'White & Jeans-Blue', 'Color Package 6', 'Color Package 7', 'Color Package 8', 'Color Package 9', 'Color Package 10' );
			echo '<div class="thememount-pre-color-links-wrapper">';
				echo '<ul class="thememount-pre-color-package-list">';
				$i = 1;
				foreach( $colorlist as $color ){
					echo '<li class="thememount-pre-color-link-'. $i .'">
							<a data-num="'. $i .'" title="&lt;img src=&quot;' . get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/thememount_pre_color_packages/images/big_pre'. $i .'.png&quot;&gt;">
								<span class="thememount-pre-color-thumbwrapper">
									<img src="' . get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/thememount_pre_color_packages/images/pre'. $i .'.png" />
									<span class="tm-pc-over"><span>Apply Now</span></span>
								</span>
								'.$color.'
							</a>
						</li>';
					$i++;
				}
				echo '</ul> <!-- .thememount-pre-color-package-list --> ';
				echo '<div class="thememount-pre-color-changeskincolor">';
					echo '<input type="hidden" name="changeskincolor" id="changeskincolor" value="1" />';
					echo '<a id="changeskincolor-link" href="#">' . __('Also change skin color too', 'howes') . '</a>';
				echo '</div>';
			echo '</div> <!-- .thememount-pre-color-links-wrapper --> ';

			
			echo '<div id="thememount-pre-color-infobox" style="display:none;"> <div style="margin:10px 0 0 0;"  class="redux-warning redux-info-field redux-field-info"><p class="redux-info-desc">';
			_e('All required colors are changed. Please save the changes now.','howes');
			echo '</p></div></div>';
			
			echo '<div class="thememount-pre-color-package-note">';
			_e('<h4>Note:</h4> Please note that this will change these options: </h4>
			<ul class="smalllist">
				<li>Body background color and content background color</li>
				<li>General text color, widget text color and heading (H1, H2 ... H6) text color</li>
				<li>Topbar text color and background color</li>
				<li>Header text color and background color</li>
				<li>Titlebar text color and background color</li>
				<li>Mainmenu link color (normal, hover and active)</li>
				<li>Dropdown link color (normal, hover and active)</li>
				<li>Footer text color and background color</li>
			</ul>','howes');
			
			echo '<div id="thememount-pre-color-infobox" style="display:none;"> <div style="margin:10px 0 0 0;"  class="redux-warning redux-info-field redux-field-info"><p class="redux-info-desc">';
			_e('All required colors are changed. Please save the changes now.','howes');
			echo '</p></div></div>';
			
			echo '</div> <!-- .thememount-pre-color-package-note --> ';
			
			
			
			
			
			echo '</div> <!-- .thememount-pre-color-packages --> ';
			echo '</div> <!-- .thememount-pre-color-packages-wrapper --> ';

			/*$colorList = array(
				'Orange'         => '#e85e16',
				'Cyan'           => '#00abe4',
				'Emerald'        => '#4abe63',
				'Green'          => '#89c355',
				'Tan'            => '#00bdbd',
				'Yellow'         => '#ffbe00',
				'Mountainmeadow' => '#18c08f',
				'Brown'          => '#964b00',
				'Cinnabar'       => '#e64d3b',
				'Mongoose'       => '#b8a279',
			);
			echo '<div class="thememount-skin-color-list">';
			foreach( $colorList as $name=>$color ){ echo '<a href="#" style="background-color:'.$color.'">'.$name.'</a>'; }
			echo '<div class="clear"></div></div>';
			
			
			echo '<div class="thememount-or-text-wrapper"><span></span><div class="thememount-or-text">OR</div></div>';
		
		
			echo '<input data-id="'.$this->field['id'].'" name="' . $this->field['name'] . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-color" class="redux-color redux-color-init ' . $this->field['class'] . '"  type="text" value="' . $this->value . '"  data-default-color="' . ( isset($this->field['default']) ? $this->field['default'] : "" ) . '" />';

			if ( !isset( $this->field['transparent'] ) || $this->field['transparent'] !== false ) {
				$tChecked = "";
				if ( $this->value == "transparent" ) {
					$tChecked = ' checked="checked"';
				}
				

				
				echo '<label for="' . $this->field['id'] . '-transparency" class="color-transparency-check"><input type="checkbox" class="checkbox color-transparency ' . $this->field['class'] . '" id="' . $this->field['id'] . '-transparency" data-id="'.$this->field['id'] . '-color" value="1"'.$tChecked.'> '.__('Transparent', 'redux-framework').'</label>';				
			}*/

		}
	
		/**
		 * Enqueue Function.
		 *
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @since		1.0.0
		 * @access		public
		 * @return		void
		 */
		public function enqueue() {

			//wp_enqueue_style( 'wp-color-picker' );
			
			
			// We already inserted code in /inc/admin-custom.js and /inc/admin-style.css files.
			wp_enqueue_script(
				'field_thememount_pre_color_packages-js',
				get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/thememount_pre_color_packages/field_thememount_pre_color_packages.js', 
				array( 'jquery' ),
				time(),
				true
			);
			wp_enqueue_style(
				'field_thememount_pre_color_packages-css', 
				get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/thememount_pre_color_packages/field_thememount_pre_color_packages.css', 
				time(),
				true
			);
			
			// Tooltip
			wp_enqueue_script(
				'tooltipster',
				get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/thememount_pre_color_packages/tooltipster/jquery.tooltipster.min.js', 
				array( 'jquery' ),
				time(),
				true
			);
			wp_enqueue_style(
				'tooltipster',
				get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/thememount_pre_color_packages/tooltipster/tooltipster.css', 
				time(),
				true
			);
			
		
		}

		
		
		
		
		/*public function output() {

			$style = '';
			if ( !empty( $this->value ) ) {
				$mode = ( isset( $this->field['mode'] ) && !empty( $this->field['mode'] ) ? $this->field['mode'] : 'color' );

				$style .= $mode.':'.$this->value.';';

				if ( !empty( $this->field['output'] ) && is_array( $this->field['output'] ) ) {
					$keys = implode(",", $this->field['output']);
					$this->parent->outputCSS .= $keys . "{" . $style . '}';
				}

				if ( !empty( $this->field['compiler'] ) && is_array( $this->field['compiler'] ) ) {
					$keys = implode(",", $this->field['compiler']);
					$this->parent->compilerCSS .= $keys . "{" . $style . '}';  
				}
			}
		}*/
		
	
	}
}