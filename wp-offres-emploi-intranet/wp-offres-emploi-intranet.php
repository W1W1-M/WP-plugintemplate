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



///////

function my_enqueue_scripts() {
	wp_enqueue_script( 'offre-emploi-script', plugins_url( '/offre-emploi.js', __FILE__ ), array(), '1.0', true );
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
	?><div id=""><?php
	foreach($data as $offre):
		$acf = acf_maj($offre);
		$intitule = $offre->$acf->identification->intitule;
		if($intitule == ""){
			$intitule = "Non renseigné";
		}
		$filiere = $offre->$acf->identification->filiere[0];
		if($filiere == ""){
			$filiere = "Non renseigné";
		}
		$residence = $offre->$acf->identification->residence;
		if($residence == ""){
			$residence = "Non renseigné";
		}
		$direction = $offre->$acf->identification->direction;
		if($direction == ""){
			$direction = "Non renseigné";
		}
		$type_recrutement = $offre->$acf->identification->type_recrutement;
		if($type_recrutement == ""){
			$type_recrutement = "Non renseigné";
		}
		$cadre = $offre->$acf->identification->cadre;
		if(empty($cadre)){
			$cadre = "Non renseigné";
		}
		$prise_fonction = $offre->$acf->identification->prise_fonction;
		if($prise_fonction == ""){
			$prise_fonction = "Non renseigné";
		}
		$remuneration = $offre->$acf->identification->remuneration;
		if($remuneration == ""){
			$remuneration = "Non renseigné";
		}
		$missions = $offre->$acf->missions;
		if($missions == ""){
			$missions = "Non renseigné";
		}
		$profil = $offre->$acf->profil;
		if($profil == ""){
			$profil = "Non renseigné";
		}
		$specificites = $offre->$acf->specificites;
		if($specificites == ""){
			$specificites = "Non renseigné";
		}
		$conditions = $offre->$acf->conditions;
		if($conditions == ""){
			$conditions = "Non renseigné";
		}
		?>
		<button class="test"
		        style="border: solid; text-align: center; position: relative;"
		        data-offre-id="<?php echo $offre->id; ?>"
		        data-intitule="<?php echo esc_html($intitule); ?>"
		        data-filiere="<?php echo esc_html($filiere); ?>"
		        data-lieu-travail="<?php echo esc_html($residence); ?>"
		        data-direction="<?php echo esc_html($direction); ?>"
		        data-type-recrutement="<?php echo esc_html($type_recrutement); ?>"
		        data-cadre="<?php echo esc_html($cadre); ?>"
		        data-date-prise-poste="<?php echo esc_html($prise_fonction); ?>"
		        data-remuneration="<?php echo esc_html($remuneration); ?>"
		        data-mission="<?php echo esc_html($missions); ?>"
		        data-profil="<?php echo esc_html($profil); ?>"
		        data-specificitees="<?php echo esc_html($specificites); ?>"
		        data-conditions="<?php echo esc_html($conditions); ?>"
		>
			<div class="intitule" style="display: inline-block; height: 50px;">
				<?php echo $intitule; ?>
			</div>
			<div class="date" style="position: absolute; bottom: 0; right: 0;">
				<?php
				$timestamp = strtotime($offre->date);
				$date = date("d/m/Y", $timestamp);
				echo $date;
				?>
			</div>
			<div class="filiere" style="position: absolute; bottom: 0;">
				<?php
				if($filiere == "prive"){
					?><label>Droit privé</label><?php
				}
				else{
					?><label>Droit public</label><?php
				}
				?>
			</div>
		</button>
	<?php
	endforeach;
	?>
	</div>
	<div id="offre-detail"></div>
	<?php
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