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
 * @author      Dovy Paukstys
 * @version     3.1.5
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_custom_field' ) ) {

    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_custom_field extends Redux_Field {
        
        public function set_defaults() {
            $defaults = array(
                'convert' => false,
                'eot'     => false,
                'svg'     => false,
                'ttf'     => false,
                'woff'    => true,
                'woff2'   => true,
            );

            $this->value = wp_parse_args( $this->value, $defaults );
        }

        public function render() {
            $can_convert = true;
            $nonce = wp_create_nonce( 'redux_custom_field' );

            
            $this->field['custom_field'] = apply_filters( "redux/{$this->parent->args['opt_name']}/field/custom_field", hitsxyz_get_theme_options($this->field['id']));

            $hide = $this->field['custom_field']['url'] ? '' : ' hide';

            echo '<input id="namefont" type="hidden" name="hitsxyz_theme_options[hits_custom_font_ttf][name]" value="'.esc_attr( $this->field['custom_field']['name'] ).'">';

            echo '<span class="spinner" style="float: left;top: 27px;position: relative;display:none; visibility: visible;"></span>';

            echo '<input placeholder="No media selected" type="text" class="upload large-text noPreview" name="hitsxyz_theme_options[hits_custom_font_ttf][url]" id="hitsxyz_theme_options[hits_custom_font_ttf][url]" value="'.esc_attr( $this->field['custom_field']['url'] ).'">';

            echo '<div class="upload_button_div">';
            echo '<span class="button media_add_font" id="'.esc_attr($this->field['id']).'-custom_field" data-nonce="'.esc_attr($nonce).'">Upload</span>';
            echo '<span class="button remove-image remove-font fontDelete'.esc_attr($hide).'" id="reset_'.esc_attr($this->field['id']).'" rel="'.esc_attr($this->field['id']).'">Remove</span>';

            echo '</div>';
            echo '</fieldset>';
            
        }
    
        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {
            wp_register_script('mangapress', $this->url .'/field_custom_field.js', array(), null, true);
            wp_enqueue_script( 'mangapress' );
        }   
        
    }
}
