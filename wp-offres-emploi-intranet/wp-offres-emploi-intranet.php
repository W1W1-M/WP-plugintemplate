<?php /** @noinspection PhpRedundantClosingTagInspection */
/**
 * WP-plugintemplate
 *
 * @package         WP-offres-emploi-intranet
 * @version         1.0.0
 * @author          Clément Schneider - Manche Numérique
 * @copyright       2023 Manche Numérique
 * @license         GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:          WP-offres-emploi-intranet
 * Plugin URI:           https://git.manche.io/wordpress/wp-offres-emploi-intranet
 * Description:          Plugin description
 * Version:              1.1.1
 * Requires at least:    6.0.5
 * Requires PHP:         8.0
 * Author:               Clément Schneider - Manche Numérique
 * Author URI:           https://www.manchenumerique.fr
 * License:              GNU GPLv3
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:          wp-offres-emploi-intranet
 * Domain Path:          /lang
 */

const WP_OFFRES_EMPLOI_INTRANET_PLUGIN_FILE_PATH = __FILE__;

wp_offres_emploi_intranet_setup();
add_action('plugins_loaded', 'my_plugin_load_textdomain');

/**
 * @since 1.0.0
 *
 * @return void
 */
function wp_offres_emploi_intranet_setup(): void {
	try {
		wp_offres_emploi_intranet_require_once();
		$wp_offres_emploi_intranet_setup = new wp_offres_emploi_intranet_Setup();
		$wp_offres_emploi_intranet_setup->init();
		$wp_offres_emploi_intranet_options = new wp_offres_emploi_intranet_Options();
		$wp_offres_emploi_intranet_options->init();
	} catch ( Exception $exception ) {
		exit( $exception->getMessage() );
	}
}

/**
 * @since 1.0.0
 *
 * @return void
 */
function wp_offres_emploi_intranet_require_once(): void {
	$plugin_dir_path = plugin_dir_path( WP_OFFRES_EMPLOI_INTRANET_PLUGIN_FILE_PATH );
	require_once $plugin_dir_path . 'inc/wp_offres_emploi_intranet_Setup.php';
	require_once $plugin_dir_path . 'admin/wp_offres_emploi_intranet_Options.php';
}

/**
 * @since 1.0.1
 *
 * @return void
 */
function my_plugin_load_textdomain() {
	load_plugin_textdomain('wp-offres-emploi-intranet', false, dirname(plugin_basename(__FILE__)) . '/lang');
}
?>