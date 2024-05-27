<?php

/**
 * @since 1.0.0
 */
class wp_offres_emploi_intranet_Options {

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
        add_action( 'admin_menu', array($this, 'setup_submenu_with_page' ) );
        add_action( 'admin_init', array(&$this, 'setup_settings' ) );
        add_filter( 'plugin_action_links_' . plugin_basename(WP_OFFRES_EMPLOI_INTRANET_PLUGIN_FILE_PATH), array( $this, 'plugin_settings_link') );
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function setup_submenu_with_page(): void {
        add_submenu_page(
            'options-general.php',
            'wp-offres-emploi-intranet',
            'wp-offres-emploi-intranet',
            'manage_options',
            'wp-offres-emploi-intranet',
            array( $this, 'setup_page' )
        );
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function setup_page(): void {
        if ( current_user_can( 'manage_options' ) ) {
            ?>
            <div class="wrap">
                <div class="">
                    <h1><?php echo esc_html( get_admin_page_title() ) ?></h1>
                    <?php $this->setup_settings_form() ?>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="wrap">
                <div class="">
                    <h1><?php echo esc_html( get_admin_page_title() ) ?></h1>
                    <h3><?php _e( 'You are not authorised to manage these settings. Please contact your WordPress administrator.', 'wpforms-cpt' ) ?></h3>
                </div>
            </div>
            <?php
        }
    }

    /**
     * @since 1.0.0
     *
     * @return void
     *
     * @noinspection HtmlUnknownTarget*
     */
    protected function setup_settings_form(): void {
        echo '<form action="options.php" method="post">';
        settings_fields('wp_offres_emploi_intranet_Options');
        do_settings_sections( 'wp-offres-emploi-intranet' );
        submit_button();
        echo '</form>';
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function setup_settings(): void {
        $this->setup_settings_section();
        $this->setup_wp_offres_emploi_intranet_url_setting();
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    protected function setup_settings_section(): void {
        add_settings_section(
            'wp_offres_emploi_intranet_settings_section',
            __( 'Settings', 'wp-offres-emploi-intranet' ), array( &$this, 'settings_section_callback' ),
            'wp-offres-emploi-intranet'
        );
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function settings_section_callback(): void {
        echo '<!-- Settings section -->';
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    protected function setup_wp_offres_emploi_intranet_url_setting(): void {
        register_setting(
            'wp_offres_emploi_intranet_Options',
            'wp_offres_emploi_intranet_url'
        );
        add_settings_field(
            'wp_offres_emploi_intranet_url',
            __( 'url setting', 'wp-offres-emploi-intranet' ), array( &$this,
            'use_wp_offres_emploi_intranet_url_field_callback'
        ),
            'wp-offres-emploi-intranet',
            'wp_offres_emploi_intranet_settings_section'
        );
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function use_wp_offres_emploi_intranet_url_field_callback(): void {
        $html = '<p>';
        $html .= '<label for="wp_tarteaucitron_privacy_policy_url" hidden>wp_tarteaucitron_privacy_policy_url</label>';
        $html .= '<p><input size="50" type="url" id="wp_offres_emploi_intranet_url" name="wp_offres_emploi_intranet_url" required';
        $html .= ' value="' . esc_attr( get_option( 'wp_offres_emploi_intranet_url' ) ) . '"';
        $html .= ' placeholder=" " pattern="https?://.+"';
        $html .= '/></p>';
	    wp_remote_get( 'http://intranet.manchenumerique.org/wp-json/wp/v2/offre' );
        echo $html;
    }

    /**
     * @since 1.0.0
     *
     * @param $links
     *
     * @return mixed
     */
    public function plugin_settings_link( $links ): mixed {
        $links[] = '<a href="' . admin_url( 'options-general.php?page=wp-offres-emploi-intranet' ) . '">' . __('Settings') . '</a>';
        return $links;
    }
}

?>