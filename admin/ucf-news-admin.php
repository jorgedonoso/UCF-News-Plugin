<?php
/**
 * Handles admin actions
 **/
if ( ! class_exists( 'UCF_News_Admin' ) ) {
	class UCF_News_Admin {
		public static function enqueue_admin_scripts() {
			if ( is_admin() ) {
				wp_enqueue_script( 'suggest' );
				wp_enqueue_script( 'ucf-news-suggest', UCF_NEWS__PLUGIN_DIR . 'static/js/ucf-news.js', ['suggest'], null, true );
			}
		}
	}

	add_action( 'admin_enqueue_scripts', array( 'UCF_News_Admin', 'enqueue_admin_scripts' ) );

}
?>
