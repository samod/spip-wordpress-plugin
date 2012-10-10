<?php
/*
Plugin Name: SPIP to Wordpress Migration Plugin
Plugin URI: http://samo.dekleva.net/projects/wordpress/plugins/spip-wordpress-plugin/
Description: SPIP to Wordpress Migration Plugin migrates a SPIP site to Wordpress.
Version: 0.1
Author: Samo Dekleva
Author URI: http://samo.dekleva.net/
License: GPL2
*/
/*  Copyright 2012  Samo Dekleva  (email : samo@dekleva.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// adding options to admin menu

if ( is_admin() ) {
    add_action( 'admin_menu', 'spip_wordpress_plugin_admin_menu' );
    add_action( 'admin_init', 'spip_wordpress_plugin_admin_init' );
} else {
  // non-admin enqueues, actions, and filters
}

function spip_wordpress_plugin_admin_menu() {
	add_options_page(
        __('SPIP Database Options','spip-wordpress-plugin').', '.__('SPIP to Wordpress Migration Plugin', 'spip-wordpress-plugin'), 
        __('SPIP to Wordpress Migration Plugin', 'spip-wordpress-plugin'), 
        'manage_options', 'spip-wordpress-plugin', 'spip_wordpress_plugin_options_page' );
    add_submenu_page( 'tools.php', __('SPIP to Wordpress Migration Plugin'), __('Import from SPIP'), 'ímport', 'import-from-spip', 'import_from_spip');
}

function import_from_spip () {
    echo '<div class="wrap">';
    echo '<div id="icon-tools" class="icon32"><br /></div><h2>'.__('Import from SPIP').'</h2>';
    echo '</div>';
}

function spip_wordpress_plugin_admin_init () {
    register_setting ('spip_wordpress_plugin_options', 'swp_options_group', 'spip_wordpress_plugin_options_validate');
    add_settings_section('swp_spip_section', __('SPIP Database Settings','spip-wordpress-plugin'), 'swp_spip_section_text', 'spip-options-page');
    add_settings_field('swp_spip_dbhostname', __('Hostname:', 'spip_wordpress-plugin'), 'swp_setting_dbhostname', 'spip-options-page', 'swp_spip_section');
    add_settings_field('swp_spip_dbusername', __('Username:', 'spip_wordpress-plugin'), 'swp_setting_dbusername', 'spip-options-page', 'swp_spip_section');
    add_settings_field('swp_spip_dbpassword', __('Password:', 'spip_wordpress-plugin'), 'swp_setting_dbpassword', 'spip-options-page', 'swp_spip_section');
    add_settings_field('swp_spip_dbname', __('Database:', 'spip_wordpress-plugin'), 'swp_setting_dbname', 'spip-options-page', 'swp_spip_section');

}

function swp_setting_dbhostname() {
    $options = get_option('swp_options_group');
    echo "<input id='swp_spip_dbhostname' name='swp_options_group[swp_spip_dbhostname]' size='40' type='text' value='{$options['swp_spip_dbhostname']}' />";
}

function swp_setting_dbusername() {
    $options = get_option('swp_options_group');
    echo "<input id='swp_spip_dbusername' name='swp_options_group[swp_spip_dbusername]' size='40' type='text' value='{$options['swp_spip_dbusername']}' />";
}

function swp_setting_dbpassword() {
    $options = get_option('swp_options_group');
    echo "<input id='swp_spip_dbpassword' name='swp_options_group[swp_spip_dbpassword]' size='40' type='text' value='{$options['swp_spip_dbpassword']}' />";
}

function swp_setting_dbname() {
    $options = get_option('swp_options_group');
    echo "<input id='swp_spip_dbname' name='swp_options_group[swp_spip_dbname]' size='40' type='text' value='{$options['swp_spip_dbname']}' />";
}


function swp_spip_section_text () {
    echo '<p>'.
        __('Please provide the host name, the database name and the database user credentials that could be used for connecting to your SPIP MySQL database.','spip-wordpress-plugin').'</p>';
}

function spip_wordpress_plugin_options_validate ($input) {
    return $input;
}

function spip_wordpress_plugin_options_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
    echo '<div id="icon-options-general" class="icon32"><br /></div>';
    echo '<h2>'.__('SPIP to Wordpress Migration Plugin','spip-wordpress-plugin').'</h2>';
    echo '<form action="options.php" method="post">';
    settings_fields('spip_wordpress_plugin_options');
    do_settings_sections('spip-options-page');
    echo '<br/><input name="Submit" type="submit" value="'.__('Save Changes').'" />';
    echo '</form>';
	echo '</div>';
}

?>