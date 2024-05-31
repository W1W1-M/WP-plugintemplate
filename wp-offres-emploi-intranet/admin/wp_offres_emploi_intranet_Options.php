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


	public function script_js() {
		wp_enqueue_script( 'offre-emploi-script', plugins_url( '../inc/offres-emploi.js', __FILE__ ), array(), '1.0', true );
	}

    public function offres(){
		$url = get_option( 'wp_offres_emploi_intranet_url' );
		$request = wp_remote_get( $url );
		$body = wp_remote_retrieve_body( $request );
		$data = json_decode( $body );
		return $data;
	}

    public function shortcode_toutes_les_offres() {
		$data = array( &$this, 'offres');
		$html = '<div id="offres">';
		foreach ($data as $offre) {
			$acf = $this->acf_maj($offre);
			$intitule = !empty($offre->$acf->identification->intitule) ? $offre->$acf->identification->intitule : "Non renseigné";
			$filiere = !empty($offre->$acf->identification->filiere[0]) ? $offre->$acf->identification->filiere[0] : "Non renseigné";
			$residence = !empty($offre->$acf->identification->residence) ? $offre->$acf->identification->residence : "Non renseigné";
			$direction = !empty($offre->$acf->identification->direction) ? $offre->$acf->identification->direction : "Non renseigné";
			$type_recrutement = !empty($offre->$acf->identification->type_recrutement) ? $offre->$acf->identification->type_recrutement : "Non renseigné";
			$cadre = !empty($offre->$acf->identification->cadre) ? $offre->$acf->identification->cadre : "Non renseigné";
			$prise_fonction = !empty($offre->$acf->identification->prise_fonction) ? $offre->$acf->identification->prise_fonction : "Non renseigné";
			$remuneration = !empty($offre->$acf->identification->remuneration) ? $offre->$acf->identification->remuneration : "Non renseigné";
			$missions = !empty($offre->$acf->missions) ? $offre->$acf->missions : "Non renseigné";
			$profil = !empty($offre->$acf->profil) ? $offre->$acf->profil : "Non renseigné";
			$specificites = !empty($offre->$acf->specificites) ? $offre->$acf->specificites : "Non renseigné";
			$conditions = !empty($offre->$acf->conditions) ? $offre->$acf->conditions : "Non renseigné";

			$timestamp = strtotime($offre->date);
			$date = date("d/m/Y", $timestamp);
			$filiere_label = ($filiere == "prive") ? '<label>Droit privé</label>' : '<label>Droit public</label>';

			$html .= '
        <button class="offre"
                style="border: solid; text-align: center; position: relative;"
                data-offre-id="' . esc_html($offre->id) . '"
                data-intitule="' . esc_html($intitule) . '"
                data-filiere="' . esc_html($filiere) . '"
                data-lieu-travail="' . esc_html($residence) . '"
                data-direction="' . esc_html($direction) . '"
                data-type-recrutement="' . esc_html($type_recrutement) . '"
                data-cadre="' . esc_html($cadre) . '"
                data-date-prise-poste="' . esc_html($prise_fonction) . '"
                data-remuneration="' . esc_html($remuneration) . '"
                data-mission="' . esc_html($missions) . '"
                data-profil="' . esc_html($profil) . '"
                data-specificitees="' . esc_html($specificites) . '"
                data-conditions="' . esc_html($conditions) . '">
            <div class="intitule" style="display: inline-block; height: 50px;">
                ' . esc_html($intitule) . '
            </div>
            <div class="date" style="position: absolute; bottom: 0; right: 0;">
                ' . esc_html($date) . '
            </div>
            <div class="filiere" style="position: absolute; bottom: 0;">
                ' . $filiere_label . '
            </div>
        </button>';
		}
		$html .= '</div>
    <div id="offre-detail"></div>';

		return $html;
	}


	public function acf_maj($object) {
		$acf = "acf";
		if (property_exists($object, 'ACF')) {
			$acf = "ACF";
		}
		return $acf;
	}

}

?>