<?php
/**
 * Handles plugin configuration
 */
class UCF_News_Config {
	 public static function ucf_news_add_customizer_sections( $wp_customize ) {
		$wp_customize->add_section(
			'ucf_news_plugin_settings',
			array(
				'title' => 'UCF News Plugin Settings'
			)
		);
	}

	public static function ucf_news_add_customizer_settings( $wp_customize ) {

		$wp_customize->add_setting(
			'ucf_news_feed_url'
		);
		$wp_customize->add_control(
			'ucf_news_feed_url',
			array(
				'type'        => 'text',
				'label'       => 'UCF News WP API Feed URL',
				'description' => 'The base url of the UCF News WP API Feed URL',
				'section'     => 'ucf_news_plugin_settings'
			)
		);

		$wp_customize->add_setting(
			'ucf_news_include_css'
		);
		$wp_customize->add_control(
			'ucf_news_include_css',
			array(
				'type'        => 'checkbox',
				'label'       => 'Include Default CSS',
				'description' => 'Include the default css stylesheet on the page.',
				'section'     => 'ucf_news_plugin_settings'
			)
		);
	}

	public static function get_layouts() {
		$layouts = array(
			'classic' => 'Classic Layout',
		);

		$layouts = apply_filters( 'ucf_news_get_layouts', $layouts );

		return $layouts;
	}
}

add_action( 'customize_register', array( 'UCF_News_Config', 'ucf_news_add_customizer_sections' ) );

add_action( 'customize_register', array( 'UCF_News_Config', 'ucf_news_add_customizer_settings' ) );

?>
