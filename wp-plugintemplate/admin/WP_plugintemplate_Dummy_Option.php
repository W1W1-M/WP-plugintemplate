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
class WP_plugintemplate_Dummy_Option implements WP_plugintemplate_Option
{

	/**
	 * @inheritDoc
	 */
	public function setup_setting(): void {
		$form_id_setting_args = array(
			'sanitize_callback' => array( &$this, 'sanitize_setting_input'),
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
			'setting_field_callback'
		),
			'wp-plugintemplate',
			'wp_plugintemplate_settings_section'
		);
	}

	/**
	 * @inheritDoc
	 */
	public function sanitize_setting_input($input): bool {
		if( $input == 'on' ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function setting_field_callback(): void {
		$html = '<p>';
		$html .= '<label for="wp_plugintemplate_dummy" hidden>wp_plugintemplate_dummy</label>';
		$html .= '<input type="checkbox" id="wp_plugintemplate_dummy" name="wp_plugintemplate_dummy"';
		if( WP_plugintemplate_Dummy_Option::get_option_value() ) {
			$html .= 'value="on" checked';
		}
		$html .= '/></p>';
		echo $html;
	}

	/**
	 * @inheritDoc
	 */
	public static function get_option_value(): mixed {
		return get_option( 'wp_plugintemplate_dummy' );
	}
}