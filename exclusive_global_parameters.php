<?php

/**
 * Plugin Name: Exclusive Parameters (Premium)
 * Plugin URI: https://woocommercechild.com/exclusive-global-parameters
 * Description: Helps to set up global parameters from your wordpress dashboard.
 * Version: 1.1.2
 * Update URI: https://api.freemius.com
 * Author: Exclusive Web Marketing
 * Author URI: https://exclusivemarketing.com/
 * Text Domain: exclusive-global-settings
 * Domain Path: /languages/
 * License: GPLv2 or any later version
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or later, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * [ewm_parameter type=image slug=featured default=https://atlantic-heatingcooling.com/wp-content/uploads/ATLA1-Deal-Hero-1.jpg ]
 * 
 * @package WPBDP
*/

if ( !function_exists( 'exc_eps_fs' ) ) {
    // Create a helper function for easy SDK access.
    function exc_eps_fs()
    {
        global  $exc_eps_fs ;
        
        if ( !isset( $exc_eps_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $exc_eps_fs = fs_dynamic_init( array(
                'id'              => '10597',
                'slug'            => 'exclusive_parameter_settings',
                'type'            => 'plugin',
                'public_key'      => 'pk_a300502ec9a305410e70473d19b08',
                'is_premium'      => true,
                'is_premium_only' => false,
                'has_addons'      => false,
                'has_paid_plans'  => true,
                'trial'           => array(
                'days'               => 14,
                'is_require_payment' => true,
            ),
                'menu'            => array(
                'slug'    => 'exclusive_parameter_settings',
                'support' => false,
            ),
                'is_live'         => true,
            ) );
        }
        
        return $exc_eps_fs;
    }
    
    // Init Freemius.
    exc_eps_fs();
    // Signal that SDK was initiated.
    do_action( 'exc_eps_fs_loaded' );
}

include dirname( __FILE__ ) . '/class_ewm_global_parameter.php';
function ewm_global_parameters( $args = array() )
{
    $ewm_global_parameters = '';
    
    if ( $args['type'] == 'image' ) {
        $ewm_global_parameters = ewm_global_parameter::process_image( $args );
    } elseif ( $args['type'] == 'text' ) {
        $ewm_global_parameters = ewm_global_parameter::process_text( $args );
    }
    
    return $ewm_global_parameters;
}

add_shortcode( 'ewm_parameter', 'ewm_global_parameters' );
// New company
function exclusive_parameter_settings_my_edit_admin_menu()
{
    add_menu_page(
        __( 'Parameter Settings', 'exclusive-parameter_settings' ),
        __( 'Parameter Settings', 'exclusive-parameter_settings' ),
        'manage_options',
        'exclusive_parameter_settings',
        'exclusive_parameter_settings_my_admin_page_new_contents',
        'dashicons-admin-network',
        3
    );
}

add_action( 'admin_menu', 'exclusive_parameter_settings_my_edit_admin_menu' );
function exclusive_parameter_settings_my_admin_page_new_contents()
{
    echo  '
    <style>
        
    #ewm_sv_setting_p{
        background-color: #fff;
        padding: 80px;
        border-radius: 30px;
        border: 1px #e2e2e2b3 solid;
        margin: 40px 30px;
        color: #333;
    }
    .ewm_shortcode_secs{
        font-size: 16px;
        font-wight:600;
    }
    </style>
    <div id="ewm_sv_setting_p"> 
    
        Please Use the Following Shortcode to Activate this Plugin 
        <br> <br> For Image : <span class="ewm_shortcode_secs">[ewm_parameter type="image" slug="featured" default="https://url-to-image.com/wp-content/uploads/image.jpg"] </span>
        <br><br> For Text: <span class="ewm_shortcode_secs">[ewm_parameter type="text" slug="deal_title"]</span>
    
    </div>' ;
}
