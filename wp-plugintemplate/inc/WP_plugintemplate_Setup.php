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

}

?>