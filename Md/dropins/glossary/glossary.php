<?php
/**
 * Dropin Name: Glossary
 * Dropin Author: Alex Mangini
 * Dropin Demo: https://marketersdelight.com/dropins/glossary/
 * Dropin Description: Creates a new section on your site that lists Glossary terms from A-Z. Creates associated settings page, registers post type, taxonomy, and loads custom templates.
 * Dropin Version: 1.2
 */

class md_glossary {

	/**
	 * Fire actions and start Glossary build.
	 *
	 * @since 1.0
	 */

	public function init() {
		$this->includes();
		add_action( 'init', array( $this, 'taxonomies' ), 0 );
		add_action( 'init', array( $this, 'post_type' ), 1 );
		add_filter( 'md_post_type_meta', array( $this, 'post_types_meta' ) );
		if ( md_setting( array( 'glossary', 'archives_layout', 'sidebar' ) ) )
			add_filter( 'md_filter_sidebars_post_types', array( $this, 'sidebars' ) );
		add_filter( 'md_dropins_css_templates', array( $this, 'css' ) );
	}

	/**
	 * Include additional files.
	 *
	 * @since 1.0
	 */

	public function includes() {
		include( 'settings.php' );
		new md_glossary_admin;
		include( 'templates.php' );
		new md_glossary_templates;
	}

	/**
	 * Load CSS template to style.css.
	 *
	 * @since 1.0
	 */

	public function css( $templates ) {
		$templates['glossary'] = trailingslashit( get_stylesheet_directory() ) . 'dropins/glossary/css.php';
		return $templates;
	}

	/**
	 * Pass data through register_taxonomy() to add custom
	 * post type to WordPress interface.
	 *
	 * @since 1.0
	 */

	public function taxonomies() {
		register_taxonomy( 'glossary_term', 'glossary', array(
			'hierarchical' => false,
			'show_ui' => true,
			'query_var' => true,
			'public' => false,
			'capabilities' => array( 'manage_categories' ),
			'show_in_rest' => true,
			'labels' => array(
				'name' => __( 'Glossary Terms', 'md' ),
				'singular_name' => __( 'Glossary Term', 'md' ),
				'search_items' => __( 'Search Glossary Terms', 'md' ),
				'all_items' => __( 'All Glossary Terms', 'md' ),
				'parent_item' => __( 'Parent Term', 'md' ),
				'parent_item_colon' => __( 'Parent Term:', 'md' ),
				'edit_item' => __( 'Edit Glossary Term', 'md' ),
				'update_item' => __( 'Update Glossary Term', 'md' ),
				'add_new_item' => __( 'Add New Glossary Term', 'md' ),
				'new_item_name' => __( 'New Glossary Term', 'md' ),
				'menu_name' => __( 'Terms', 'md' )
			)
		) );
	}

	/**
	 * Pass data through register_post_type() to add custom
	 * post type to WordPress interface.
	 *
	 * @since 1.0
	 */

	public function post_type() {
		$slug = md_setting( array( 'glossary', 'archives_slug' ) );
		register_post_type( 'glossary', array(
			'hierarchial' => true,
			'public' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'menu_icon' => 'dashicons-admin-site-alt3',
			'taxonomies' => array( 'glossary_term' ),
			'menu_position' => 20,
			'rewrite' => array(
				'slug' => ! empty( $slug ) ? $slug : 'glossary',
				'with_front' => true
			),
			'show_in_rest' => true,
			'labels' => array(
				'name' => __( 'Glossary', 'md' ),
				'singular_name' => __( 'Glossary', 'md' ),
				'menu_name' => __( 'Glossary', 'md' ),
				'name_admin_bar' => __( 'Glossary', 'md' ),
				'add_new_item' => __( 'Add New Entry', 'md' ),
				'edit_item' => __( 'Edit Entry', 'md' ),
				'new_item' => __( 'New Entry', 'md' ),
				'view_item' => __( 'View Entry', 'md' ),
				'view_items' => __( 'View Glossary', 'md' ),
				'search_items' => __( 'Search Glossary', 'md' ),
				'not_found' => __( 'No entries found', 'md' ),
				'not_found_in_trash' => __( 'No entries found in trash', 'md' ),
				'all_items' => __( 'Glossary', 'md' )
			)
		) );
	}

	/**
	 * Add MD meta options to Glossary custom post type.
	 *
	 * @since 1.0
	 */

	public function post_types_meta( $post_types ) {
		$post_types[] = 'glossary';
		return $post_types;
	}

	/**
	 * Add Glossary to custom Sidebars Manager.
	 *
	 * @since 1.0
	 */

	public function sidebars( $sidebars ) {
		$sidebars['glossary']['archive'] = true;
		return $sidebars;
	}

}

$md_glossary = new md_glossary;
$md_glossary->init();