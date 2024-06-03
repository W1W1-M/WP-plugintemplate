<?php /** @noinspection PhpRedundantClosingTagInspection */

wp_offres_emploi_intranet_uninstall();

/**
 * @since 1.0.1
 *
 * @return void
 */
function wp_offres_emploi_intranet_uninstall(): void {
    try {
        wordpress_plugin_uninstall_called();
        delete_options();
    } catch( Exception $exception ) {
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
function wordpress_plugin_uninstall_called(): bool {
    if ( defined( 'WP_UNINSTALL_PLUGIN' ) ) {
        return true;
    } else {
        $exception = new Exception( 'Improper plugin uninstall call' );
        error_log( $exception->getMessage() );
        throw $exception;
    }
}

/**
 * @since 1.0.0
 *
 * @throws Exception
 *
 * @return void
 */
function delete_options(): void {
	delete_option( 'wp_offres_emploi_intranet_url' );
}

?>