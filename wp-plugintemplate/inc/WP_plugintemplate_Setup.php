<?php

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

}

?>