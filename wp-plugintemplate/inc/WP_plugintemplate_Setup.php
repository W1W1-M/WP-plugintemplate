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
 * @since 1.0.0
 */
class WP_plugintemplate_Setup {

	/**
	 * @since 1.0.0
	 */
	public function __construct() {

	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init(): void {
		try {
			$this->wordpress_absolute_path_available();
			register_activation_hook( WP_PLUGINTEMPLATE_PLUGIN_FILE_PATH, array( $this, 'plugin_activate' ) );
			register_deactivation_hook( WP_PLUGINTEMPLATE_PLUGIN_FILE_PATH, array( $this, 'plugin_deactivate' ) );
			$this->actions();
		} catch ( Exception $exception ) {
			exit( $exception->getMessage() );
		}
	}

	/**
	 * @since 1.0.0
	 *
	 * @throws Exception
	 *
	 * @return bool
	 */
	protected function wordpress_absolute_path_available(): bool {
		if( defined( 'ABSPATH' )) {
			return true;
		} else {
			$exception = new Exception( 'WordPress unavailable. Plugin not loaded.' );
			error_log( $exception->getMessage() );
			throw $exception;
		}
	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function plugin_activate(): void {

	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function plugin_deactivate(): void {

	}

	/**
	 * @since 1.0.0
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	protected function actions(): void {
		try {
			add_action( 'init', array( $this, 'load_textdomain' ), 10, 0 );
			add_action( 'add_option_wp_tarteaucitron_dummy', array( $this, 'option_changed' ) );
			add_action( 'update_option_wp_tarteaucitron_dummy', array( $this, 'option_changed' ) );
		} catch ( Exception $exception ) {
			error_log( 'WP-plugintemplate actions error' );
			throw $exception;
		}
	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_textdomain(): void {
		load_plugin_textdomain( 'wp-plugintemplate', false, dirname( plugin_basename( WP_PLUGINTEMPLATE_PLUGIN_FILE_PATH ) ) . '/lang/' );
	}

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function option_changed(): void {

	}

}

?>