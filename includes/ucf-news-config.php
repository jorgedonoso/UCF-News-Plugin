<?php
/**
 * Handles plugin configuration
 */
if ( ! class_exists( 'UCF_News_Config' ) ) {
	class UCF_News_Config {
		public static
			$default_options = array(
				'title'    => 'News',
				'layout'   => 'classic',
				'sections' => '',
				'topics'   => '',
				'limit'    => 3
			);

		public static function get_layouts() {
			$layouts = array(
				'classic' => 'Classic Layout'
			);

			$layouts = apply_filters( 'ucf_news_get_layouts', $layouts );

			return $layouts;
		}

		public static function get_default_options() {
			$defaults = self::$default_options;

			return self::format_options( $defaults );
		}

		public static function apply_default_options( $list, $list_keys_only=false ) {
			$defaults = self::get_default_options();
			$options = array();

			if ( $list_keys_only ) {
				foreach( $list as $key => $val ) {
					$options[$key] = ! empty( $val ) ? $val : $defaults['key'];
				}
			} else {
				$options = array_merge( $defaults, $list );
			}

			$options = self::format_options( $options );

			return $options;
		}

		public static function format_options( $list ) {
			foreach( $list as $key => $val ) {
				switch( $key ) {
					case 'limit':
						$list[$key] = intval( $val );
						break;
					default:
						break;
				}
			}

			return $list;
		}

		public static function add_options_page() {
			add_options_page(
				'UCF News',
				'UCF News',
				'manage_options',
				'ucf_news_settings',
				array(
					'UCF_News_Config',
					'add_settings_page'
				)
			);

			add_action( 'admin_init', array( 'UCF_News_Config', 'register_settings' ) );
		}

		public static function register_settings() {
			register_setting( 'ucf-news-group', 'ucf_news_feed_url' );
			register_setting( 'ucf-news-group', 'ucf_news_include_css' );
			register_setting( 'ucf-news-group', 'ucf_news_fallback_image' );
		}

		public static function add_settings_page() {
			if ( function_exists( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			} else {
				wp_enqueue_style( 'thickbox' );
				wp_enqueue_script( 'media-upload' );
				wp_enqueue_script( 'thickbox' );
				wp_enqueue_media();
			}

			$defaults = self::get_default_options();
			$ucf_news_feed_url = get_option( 'ucf_news_feed_url', $defaults['ucf_news_feed_url'] );
			$ucf_news_include_css = get_option( 'ucf_news_include_css', $defaults['ucf_news_include_css'] );
			$ucf_news_fallback_image = get_option( 'ucf_news_fallback_image', $defaults['ucf_news_fallback_image'] );
			$ucf_news_fallback_image_src = $ucf_news_fallback_image ? UCF_News_Common::get_fallback_image( $ucf_news_fallback_image ) : '';

	?>
	<div class="wrap">
	<h1>UCF News Settings</h1>
	<form method="post" action="options.php">
		<?php settings_fields( 'ucf-news-group' ); ?>
		<?php do_settings_sections( 'ucf-news-groups' ); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">UCF News Feed URL</th>
				<td><input type="text" name="ucf_news_feed_url" value="<?php echo esc_attr( $ucf_news_feed_url ); ?>"></td>
			</tr>
			<tr valign="top">
				<th scope="row">Include CSS</th>
				<td><input type="checkbox" name="ucf_news_include_css" <?php echo ( $ucf_news_include_css === 'on' ) ? 'checked' : ''; ?>>
					Include Default CSS
				</input></td>
			</tr>
			<tr valign="top">
				<th scope="row">Fallback Image</th>
				<td>
					<img class="ucf_news_fallback_image_preview" src="<?php echo $ucf_news_fallback_image_src; ?>" height="100" width="100">
					<input class="ucf_news_fallback_image" type="hidden" name="ucf_news_fallback_image" value="<?php echo $ucf_news_fallback_image; ?>">
					<a href="#" class="ucf_news_fallback_image_upload">Upload</a>
				</td>
			</tr>
		<?php submit_button(); ?>
	</form>
	<?php
		}
	}
}
?>
