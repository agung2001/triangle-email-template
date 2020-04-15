<?php
/*
* Plugin Name:       Triangle
* Plugin URI:        https://yourwebsitename.com
* Description:       Email Template, Newsletter, Campaign
* Version:           2.0
* Author:            Agung Sundoro
* Author URI:        https://agungsundoro.blogspot.com
* License:           GPL-3.0
* License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, write to the Free Software
Foundation, Inc. 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.

Copyright 2002-2015 Automattic, Inc.
*/

!defined( 'WPINC ' ) or die;

/**
 * Load Composer Vendor
 */
require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * Initiate Plugin
 */
function Triangle() {
    $plugins = new Triangle\Includes\Plugins(__FILE__);
    $plugins->setName('Triangle');
    $plugins->setVersion(2.0);
    $plugins->setStage(0);
    $plugins->load_api();
    $plugins->load_controller();
    $plugins->load_model();
}
add_action('init', 'Triangle');