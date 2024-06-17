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
	    add_action( 'wp_enqueue_scripts', array( $this, 'script_js' ));
	    add_shortcode( 'wp_offres_emploi_intranet', array( $this, 'shortcode_toutes_les_offres' ));
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
		echo '<div class="wrap"><div class=""><h1>' . esc_html( get_admin_page_title() ) . '</h1>';
		if ( current_user_can( 'manage_options' ) ) {
			$this->setup_settings_form();
		} else {
			echo '<h3>' . _e( 'You are not authorised to manage these settings. Please contact your WordPress administrator.', 'wpforms-cpt' ) . '</h3>';
		}
		echo '</div></div>';
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
	    $html .= '<p>';
	    $html .= __("You have to enter the URL of the API providing the job offers.", "wp-offres-emploi-intranet");
	    $html .= '</p>';
	    $html .= '<p>';
	    $html .= __("'#affichage-offres-emploi-intranet': This div wraps around all displayed job offers.", "wp-offres-emploi-intranet");
	    $html .= '</p>';
	    $html .= '<p>';
	    $html .= __("'.offre-specifique-emploi-intranet': Each job offer is encapsulated in a button with the class '.offre-specifique-emploi-intranet'.", "wp-offres-emploi-intranet");
	    $html .= '</p>';
	    $html .= '<p>';
	    $html .= __("'.intitule-offre-emploi-intranet': The job offer's title.", "wp-offres-emploi-intranet");
	    $html .= '</p>';
	    $html .= '<p>';
	    $html .= __("'.date-offre-emploi-intranet': The publication date of the job offer.", "wp-offres-emploi-intranet");
	    $html .= '</p>';
	    $html .= '<p>';
	    $html .= __("'.filiere-offre-emploi-intranet': The type of job offer (e.g., public or private).", "wp-offres-emploi-intranet");
	    $html .= '</p>';
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

	/**
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function script_js(): void {
		wp_enqueue_script( 'offre-emploi-script', plugins_url( '../inc/offres-emploi.js', __FILE__ ), array(), '1.0', true );
	}

	/**
	 * @since 1.0.0
	 *
	 * @return mixed
	 */
	public function offres(): mixed {
		try{
			return json_decode( wp_remote_retrieve_body( wp_remote_get( get_option( 'wp_offres_emploi_intranet_url'))));
		}
		catch( Exception $e ){
			echo __("No offers available","wp-offres-emploi-intranet");
			return null;
		}
	}

	/**
	 * @since 1.0.0
	 *
	 * @return String
	 */
    public function shortcode_toutes_les_offres(): string {
		$data = $this->offres();
		$html = '<div id="affichage-offres-emploi-intranet">';
		foreach ($data as $offre) {
			$acf_label_case = $this->acf_maj($offre);
			$intitule = !empty($offre->$acf_label_case->identification->intitule) ? $offre->$acf_label_case->identification->intitule : __("not specified", "wp-offres-emploi-intranet");
			$filiere = !empty($offre->$acf_label_case->identification->filiere[0]) ? $offre->$acf_label_case->identification->filiere[0] : __("not specified", "wp-offres-emploi-intranet");
			$residence = !empty($offre->$acf_label_case->identification->residence) ? $offre->$acf_label_case->identification->residence : __("not specified", "wp-offres-emploi-intranet");
			$direction = !empty($offre->$acf_label_case->identification->direction) ? $offre->$acf_label_case->identification->direction : __("not specified", "wp-offres-emploi-intranet");
			$type_recrutement = !empty($offre->$acf_label_case->identification->type_recrutement) ? $offre->$acf_label_case->identification->type_recrutement : __("not specified", "wp-offres-emploi-intranet");
			$cadre = !empty($offre->$acf_label_case->identification->cadre) ? $offre->$acf_label_case->identification->cadre : __("not specified", "wp-offres-emploi-intranet");
			$prise_fonction = !empty($offre->$acf_label_case->identification->prise_fonction) ? $offre->$acf_label_case->identification->prise_fonction : __("not specified", "wp-offres-emploi-intranet");
			$remuneration = !empty($offre->$acf_label_case->identification->remuneration) ? $offre->$acf_label_case->identification->remuneration : __("not specified", "wp-offres-emploi-intranet");
			$missions = !empty($offre->$acf_label_case->missions) ? $offre->$acf_label_case->missions : __("not specified", "wp-offres-emploi-intranet");
			$profil = !empty($offre->$acf_label_case->profil) ? $offre->$acf_label_case->profil : __("not specified", "wp-offres-emploi-intranet");
			$specificites = !empty($offre->$acf_label_case->specificites) ? $offre->$acf_label_case->specificites : __("not specified", "wp-offres-emploi-intranet");
			$conditions = !empty($offre->$acf_label_case->conditions) ? $offre->$acf_label_case->conditions : __("not specified", "wp-offres-emploi-intranet");

			$timestamp = strtotime($offre->date);
			$date = date("d/m/Y", $timestamp);
			$filiere_label = ($filiere == "prive") ? '<label>' . __("private low", "wp-offres-emploi-intranet") . '</label>' : '<label>' . __("public low", "wp-offres-emploi-intranet") . '</label>';

			$html .= '
        <button class="offre-specifique-emploi-intranet"
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
            <div class="intitule-offre-emploi-intranet">
                ' . esc_html($intitule) . '
            </div>
            <div class="date-offre-emploi-intranet">
                ' . esc_html($date) . '
            </div>
            <div class="filiere-offre-emploi-intranet">
                ' . $filiere_label . '
            </div>
        </button>';
		}
		$html .= '</div>
    <div id="offre-detail"></div>';

		return $html;
	}


	/**
	 * @since 1.0.0
	 *
	 * @return String
	 */
	public function acf_maj($object) {
		return property_exists($object, 'ACF') ? "ACF" : "acf";
	}

}

?>