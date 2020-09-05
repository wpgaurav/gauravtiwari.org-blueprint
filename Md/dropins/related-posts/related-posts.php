<?php
/**
 * Dropin Name: Related Posts
 * Dropin Author: Alex Mangini
 * Dropin Demo: https://marketersdelight.net/dropins/related-posts/
 * Dropin Description: Show related posts by category at the end of each blog post.
 * Dropin Version: 1.0.1
 */

if ( ! class_exists( 'md_related_posts' ) ) :

class md_related_posts {

	/**
	 * Quick configuration options.
	 *
	 * @since 1.0
	 */

	public $settings = array(
		'title' => 'You may also like these',
		'post_count' => 6,
		'columns' => 3
	);

	/**
	 * Fire action hooks.
	 *
	 * @since 1.0
	 */

	public function __construct() {
		add_action( 'template_redirect', array( $this, 'templates' ) );
	}

	/**
	 * Control where the related posts Loop template is loaded.
	 *
	 * @since 1.0
	 */

	public function templates() {
		if ( is_singular( array('post', 'snippet', 'portfolio') ) )
			add_action( 'md_hook_content_item', array( $this, 'loop' ), 65 );
	}

	/**
	 * Create logic for related posts and include template.
	 *
	 * @since 1.0
	 */

	public function loop() {
		global $post;
		$settings = $this->settings;
		$categories = get_the_category( $post->ID );
		if ( $categories ) {
			$cat_ids = array();
			foreach ( $categories as $cat )
				$cat_ids[] = $cat->term_id;
			$related = new WP_Query( array(
				'category__in' => $cat_ids,
				'post__not_in' => array( $post->ID ),
				'posts_per_page' => $settings['post_count']
			) );
			if ( $related->have_posts() )
				include( 'template.php' );
		}
		wp_reset_query();
	}

}

new md_related_posts;

endif;