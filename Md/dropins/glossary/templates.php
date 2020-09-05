<?php
/**
 * Load Glossary templates to precise places around site.
 *
 * @since 1.0
 */

class md_glossary_templates {

	/**
	 * Load hooks on initialization.
	 *
	 * @since 1.0
	 */

	public function __construct() {
		add_action( 'template_redirect', array( $this, 'templates' ) );
	}

	/**
	 * Load various templates throughout interface.
	 *
	 * @since 1.0
	 */

	public function templates() {
		// Archive page
		if ( is_post_type_archive( 'glossary' ) ) {
			remove_action( 'md_hook_content', 'md_archives_title' );
			remove_action( 'md_hook_content', 'md_loop' );
			remove_action( 'md_hook_content', 'md_comments' );
			remove_action( 'md_hook_content', 'md_pagination' );
			add_action( 'md_hook_before_content_box', array( $this, 'hero' ) );
			add_action( 'md_hook_before_content_box', array( $this, 'letters_nav' ) );
			add_filter( 'md_filter_content_classes', array( $this, 'content_classes' ) );
			add_action( 'md_hook_content', array( $this, 'loop' ) );
			add_filter( 'md_filter_loop_type', array( $this, 'loop_type' ) );
			add_action( 'md_hook_content', array( $this, 'call_to_action' ) );
			if ( md_setting( array( 'glossary', 'archives_layout', 'main_menu' ) ) )
				add_filter( 'md_filter_has_main_menu', '__return_false' );
			if ( md_setting( array( 'glossary', 'archives_layout', 'sidebar' ) ) )
				add_filter( 'md_filter_has_sidebar', '__return_true' );
			else
				add_filter( 'md_filter_has_sidebar', '__return_false' );
		}

		// Single pages
		if ( is_singular( 'glossary' ) ) {
			add_action( 'md_hook_before_headline', array( $this, 'breadcrumbs' ) );
			add_action( 'md_hook_after_content', array( $this, 'after_post' ), 10 );
			add_filter( 'md_filter_headline', array( $this, 'title_prefix' ), 10, 2 );
			add_filter( 'md_filter_has_sidebar', '__return_false' );
			remove_action( 'md_hook_content', 'md_author' );
			remove_action( 'md_hook_content', 'md_post_nav' );
		}
	}

	/**
	 * Add page title and description to top of Archives page.
	 *
	 * @since 1.0
	 */

	public function hero() {
		$subtitle = md_setting( array( 'glossary', 'archives_subtitle' ) );
		$title = md_setting( array( 'glossary', 'archives_title' ) );
		$text = md_setting( array( 'glossary', 'archives_text' ) );
		$search_text = md_setting( array( 'glossary', 'archives_search_text' ) );
		include( 'templates/hero.php' );
	}

	/**
	 * Add Letters navigation.
	 *
	 * @since 1.0
	 */

	public function letters_nav() {
		$archive_link = get_post_type_archive_link( 'glossary' );
		$terms = get_terms( 'glossary_term' );
		if ( ! empty( $terms ) )
			include( 'templates/letters-nav.php' );
	}

	/**
	 * Apply custom classes to content box.
	 *
	 * @since 1.0
	 */

	public function content_classes( $classes ) {
		if ( ! md_has_sidebar() ) {
			$classes[] = 'content-width';
			$classes[] = 'auto';
		}
		return array_diff( $classes, array( 'shadow' ) );
	}

	/**
	 * Loop through each letter category and list associated
	 * posts to build main Glossary archive pages.
	 *
	 * @since 1.0
	 */

	public function loop() {
		$html = is_post_type_archive() ? 'article' : 'div';
		$terms = get_terms( 'glossary_term' );
		$page_id = get_the_ID();
		foreach ( $terms as $term ) {
			$posts = new WP_Query( array(
				'fields' => 'ids',
				'post_type' => 'glossary',
				'orderby' => 'title',
				'order' => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => 'glossary_term',
						'terms' => $term->term_id
					)
				)
			) );
			if ( $posts->have_posts() )
				include( 'templates/loop.php' );
			wp_reset_query();
		}
	}

	/**
	 * Change loop type.
	 *
	 * @since 1.1.2
	 */

	public function loop_type() {
		return 'glossary';
	}

	/**
	 * Create breadcrumbs template to place on top of single Terms.
	 *
	 * @since 1.0
	 */

	public function breadcrumbs() {
		$post_type = get_post_type_object( get_post_type() );
		$archive_link = get_post_type_archive_link( 'glossary' );
		$taxonomies = ! empty( $post_type->taxonomies[0] ) ? $post_type->taxonomies[0] : '';
		$terms = get_the_terms( get_the_ID(), $taxonomies );
		include( 'templates/breadcrumbs.php' );
	}

	/**
	 * Add Prefix to post title if enabled.
	 *
	 * @since 1.0
	 */

	public function title_prefix( $title ) {
		$prefix = md_setting( array( 'glossary', 'single_prefix' ) );
		if ( ! empty( $prefix ) )
			$title = "{$prefix} {$title}";
	    return $title;
	}

	/**
	 * After post showing random terms.
	 *
	 * @since 1.0
	 */

	public function after_post() {
		$title = md_setting( array( 'glossary', 'single_after_title' ) );
		$title = ! empty( $title ) ? $title : __( 'Learn More', 'md-child-theme' );
		$text = md_setting( array( 'glossary', 'single_after_text' ) );
		include( 'templates/after-post.php' );
	}

	/**
	 * Call to Action.
	 *
	 * @since 1.0
	 */

	public function call_to_action() {
		$type = md_setting( array( 'glossary', 'cta_type' ) );
		// Text
		$subtitle = md_setting( array( 'glossary', 'cta_subtitle' ) );
		$title = md_setting( array( 'glossary', 'cta_title' ) );
		$text = md_setting( array( 'glossary', 'cta_text' ) );
		// Button data
		$button_text = md_setting( array( 'glossary', 'cta_button_text' ) );
		$button_text = ! empty( $button_text ) ? $button_text : __( 'Get Access Now', 'md-child-theme' );
		$button_url = md_setting( array( 'glossary', 'cta_button_url' ) );
		// Popup data
		$popup = md_setting( array( 'glossary', 'cta_popup' ) );
		$has_popup = $type == 'popup' && ! empty( $popup ) ? true : false;
		$popup_classes = $has_popup ? ' md-popup-trigger' : '';
		$popup_data = $has_popup ? ' data-popup="md_popup_' . esc_attr( $popup ) . '"' : '';
		if ( $has_popup )
			do_shortcode( "[md_popup id={$popup}]" );
		// Email data
		$email = array();
		$email['email_list'] = md_setting( array( 'glossary', 'cta_email' ) );
		$email['email_input']['name'] = md_setting( array( 'glossary', 'cta_email_input', 'name' ) );
		$email['email_name_label'] = md_setting( array( 'glossary', 'cta_email_name_label' ) );
		$email['email_email_label'] = md_setting( array( 'glossary', 'cta_email_email_label' ) );
		$email['email_submit_text'] = md_setting( array( 'glossary', 'cta_email_submit_text' ) );
		$email['email_thank_you'] = md_setting( array( 'glossary', 'cta_email_thank_you' ) );
		// Load template
		if ( ! empty( $type ) )
			include( 'templates/call-to-action.php' );
	}

}