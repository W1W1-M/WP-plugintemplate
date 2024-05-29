<?php /** @noinspection PhpRedundantClosingTagInspection */
/**
 * WP-plugintemplate
 *
 * @package         WP-offres-emploi-intranet
 * @version         1.0.1
 * @author          Clément Schneider - Manche Numérique
 * @copyright       2023 Manche Numérique
 * @license         GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:          WP-offres-emploi-intranet
 * Plugin URI:           https://git.manche.io/wordpress/wp-offres-emploi-intranet
 * Description:          Plugin description
 * Version:              1.0.1
 * Requires at least:    6.0.5
 * Requires PHP:         8.2.4
 * Author:               Clément Schneider - Manche Numérique
 * Author URI:           https://www.manchenumerique.fr
 * License:              GNU GPLv3
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:          wp-offres-emploi-intranet
 * Domain Path:          /lang
 */

const WP_OFFRES_EMPLOI_INTRANET_PLUGIN_FILE_PATH = __FILE__;

/*if(){
    $acf = "ACF";
}*/

wp_offres_emploi_intranet_setup();

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

function my_enqueue_scripts() {
	wp_enqueue_script( 'offre-emploi-script', plugins_url( 'inc/offres-emploi.js', __FILE__ ), array(), '1.0', true );
}

add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );

function offres(){
	$url = get_option( 'wp_offres_emploi_intranet_url' );
	$request = wp_remote_get( $url );
	$body = wp_remote_retrieve_body( $request );
	$data = json_decode( $body );
	return $data;
}

function shortcode_toutes_les_offres() {
	$data = offres();
	$html = '<div id="offres">';
	foreach ($data as $offre) {
		$acf = acf_maj($offre);
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


function acf_maj($object) {
	$acf = "acf";
	if (property_exists($object, 'ACF')) {
		$acf = "ACF";
	}
	return $acf;
}

add_shortcode( 'offres', 'shortcode_toutes_les_offres' );
?>