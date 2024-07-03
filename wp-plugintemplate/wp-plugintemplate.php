<?php
declare( strict_types=1 );

/*
 * This file is part of WP-tarteaucitron.
 *
 * WP-tarteaucitron is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * WP-tarteaucitron is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with Foobar. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * WP-plugintemplate
 *
 * @package         WP-plugintemplate
 * @version         1.0.0
 * @author          William Mead - Manche Numérique
 * @copyright       2023 Manche Numérique
 * @license         GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:          WP-plugintemplate
 * Plugin URI:           https://git.manche.io/wordpress/wpplugintemplate
 * Description:          Plugin description
 * Version:              1.0.0
 * Requires at least:    6.3.4
 * Requires PHP:         8.1.28
 * Author:               William Mead - Manche Numérique
 * Author URI:           https://www.manchenumerique.fr
 * License:              GNU GPLv3
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:          wp-plugintemplate
 * Domain Path:          /lang
 */

const WP_PLUGINTEMPLATE_PLUGIN_FILE_PATH = __FILE__;

wp_plugintemplate_setup();

/**
 * @since 1.0.0
 *
 * @return void
 */
function wp_plugintemplate_setup(): void {
	try {
		wp_plugintemplate_require_once();
		$wp_plugintemplate_setup = new WP_plugintemplate_Setup();
		$wp_plugintemplate_setup->init();
		$wp_plugintemplate_options = new WP_plugintemplate_Options();
		$wp_plugintemplate_options->init();
	} catch ( Exception $exception ) {
		exit( $exception->getMessage() );
	}
}

/**
 * @since 1.0.0
 *
 * @return void
 */
function wp_plugintemplate_require_once(): void {
	$plugin_dir_path = plugin_dir_path( WP_PLUGINTEMPLATE_PLUGIN_FILE_PATH );
	require_once $plugin_dir_path . 'inc/WP_plugintemplate_Setup.php';
	require_once $plugin_dir_path . 'admin/WP_plugintemplate_Options.php';
	require_once $plugin_dir_path . 'admin/WP_plugintemplate_Option.php';
	require_once $plugin_dir_path . 'admin/WP_plugintemplate_Dummy_Option.php';
}