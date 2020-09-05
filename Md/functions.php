<?php

// define constants
define( 'MD_CHILD_DIR', trailingslashit( get_stylesheet_directory() ) );
define( 'MD_CHILD_URL', trailingslashit( get_stylesheet_directory_uri() ) );

// include MD library and child theme files
require_once( get_template_directory() . '/lib/marketers-delight.php' );
require_once( 'loader.php' );
include( 'dropins/gallery-blocks/gallery-blocks.php' );
include( 'dropins/glossary/glossary.php' );
include( 'dropins/page-blocks/page-blocks.php' );
// include( 'dropins/beacon/beacon.php' );
include( 'dropins/page-leads/page-leads.php' );
// include( 'dropins/related-posts/related-posts.php' );
function content_bc() {    
    if (is_singular(array('post', 'snippet', 'stream'))){
		echo '<div class="content-inner tags" style="margin-bottom:30px">';
		the_tags( 'Tagged: ', ', ', '<br />' );
		echo '</div>';
	}
}
add_action('md_hook_content_item', 'content_bc', 41);
add_action(
	'enqueue_block_editor_assets',
	function () {
		$theme = wp_get_theme();
		wp_enqueue_style(
		'block-custom', '/wp-content/themes/Md/custom-editor.css', [],
			$theme-> get('Version')
		);
	}
);