<?php

/**
 * @since 1.0.0
 */
class WP_plugintemplate_Options {

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
        add_filter( 'plugin_action_links_' . plugin_basename(WP_PLUGINTEMPLATE_PLUGIN_FILE_PATH), array( $this, 'plugin_settings_link') );
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function setup_submenu_with_page(): void {
        add_submenu_page(
            'options-general.php',
            'WP-plugintemplate',
            'WP-plugintemplate',
            'manage_options',
            'wp-plugintemplate',
            array( $this, 'setup_page' )
        );
    }

    /**
     * @return string
     *@since 1.0.0
     *
     */
    public function setup_page(): string {
	    $html = '<div class="wrap"><div class="">';
	    $html .= '<h1>' . esc_html( get_admin_page_title() ) . '</h1>';
        if ( current_user_can( 'manage_options' ) ) {
            $this->setup_settings_form();
        } else {
            $html .= '<h3>' . _e( 'You are not authorised to manage these settings. Please contact your WordPress administrator.', 'wpforms-cpt' ) . '</h3>';
        }
        $html .= '</div></div>';
        return $html;
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
        settings_fields( 'wp_plugintemplate_options' );
        do_settings_sections( 'wp-plugintemplate' );
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
        $this->setup_plugintemplate_dummy_setting();
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    protected function setup_settings_section(): void {
        add_settings_section(
            'wp_plugintemplate_settings_section',
            __( 'Settings', 'wp-plugintemplate' ), array( &$this, 'settings_section_callback' ),
            'wp-plugintemplate'
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
    protected function setup_plugintemplate_dummy_setting(): void {
        $form_id_setting_args = array(
            'sanitize_callback' => array( &$this, 'sanitize_plugintemplate_dummy_setting_input'),
            'default' => 'false'
        );
        register_setting(
            'wp_plugintemplate_options',
            'wp_plugintemplate_dummy',
            $form_id_setting_args
        );
        add_settings_field(
            'wp_plugintemplate_dummy_field',
            __( 'Dummy setting', 'wp-plugintemplate' ), array( &$this,
            'use_plugintemplate_dummy_field_callback'
        ),
            'wp-plugintemplate',
            'wp_plugintemplate_settings_section'
        );
    }

    /**
     * @since 1.0.0
     *
     * @param $input
     *
     * @return bool
     */
    public function sanitize_plugintemplate_dummy_setting_input($input ): bool {
        if( $input == 'on' ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function use_plugintemplate_dummy_field_callback(): void {
        $html = '<p>';
        $html .= '<label for="wp_plugintemplate_dummy" hidden>wp_plugintemplate_dummy</label>';
        $html .= '<input type="checkbox" id="wp_plugintemplate_dummy" name="wp_plugintemplate_dummy"';
        if( $this->get_option_wp_plugintemplate_dummy() ) {
            $html .= 'value="on" checked';
        }
        $html .= '/></p>';
        echo $html;
    }

    /**
     * @since 1.0.0
     *
     * @return bool
     */
    protected function get_option_wp_plugintemplate_dummy(): bool {
        return get_option( 'wp_plugintemplate_dummy' );
    }

    /**
     * @since 1.0.0
     *
     * @param $links
     *
     * @return mixed
     */
    public function plugin_settings_link( $links ): mixed {
        $links[] = '<a href="' . admin_url( 'options-general.php?page=wp-plugintemplate' ) . '">' . __('Settings') . '</a>';
        return $links;
    }
}

?>