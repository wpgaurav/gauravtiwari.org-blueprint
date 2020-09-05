<?php
/**
 * Page Blocks
 * by Alex Mangini
 * Demo: https://marketersdelight.com/dropins/page-blocks/
 *
 * Adds a meta box to the post editor that allows you to create unlimited
 * sections with your own custom HTML.
 *
 * @since 1.1
 */

if ( ! class_exists( 'md_page_blocks' ) ) :

class md_page_blocks extends md_api {

	/**
	 * Run hooks and filters.
	 *
	 * @since 1.0
	 */

	public function actions() {
		add_shortcode( 'page_blocks', array( $this, 'shortcode' ) );
	}

	/**
	 * Register meta box and custom fields.
	 *
	 * @since 1.0
	 */

	public function register() {
		return array(
			'meta_box' => array(
				'name' => __( 'Page Blocks', 'md-child-theme' ),
				'post_type' => array( 'post', 'page' ),
				'fields' => array(
					'position' => array(
						'type' => 'select',
						'options' => array(
							'md_hook_before_html',
							'md_hook_after_header',
							'md_hook_before_content_box',
							'md_hook_content',
							'md_hook_before_footer',
							'md_hook_after_footer'
						)
					),
					'blocks' => array(
						'type' => 'group',
						'fields' => array(
							'id' => array( 'type' => 'hidden' ),
							'name'    => array( 'type' => 'text' ),
							'content' => array( 'type' => 'code' ),
							'css' => array( 'type' => 'code' ),
							'format' => array(
								'type'    => 'checkbox',
								'options' => array( 'enable' )
							),
							'bg_color' => array( 'type' => 'color' ),
							'color' => array( 'type' => 'color' ),
							'links' => array( 'type' => 'color' ),
							'margin_bottom' => array(
								'type' => 'select',
								'options' => array( 'mb-half', 'mb-single', 'md-mid', 'mb-double', 'mb-triple', 'mb-quad' )
							)
						)
					)
				)
			)
		);
	}

	/**
	 * Shortcode to pull boxes into your content.
	 *
	 * @since 1.0
	 */

	public function shortcode( $atts, $content = '' ) {
		ob_start();
		$this->template();
		return ob_get_clean();
	}

	/**
	 * Manipulate page template to position Alt Box template.
	 *
	 * @since 1.0
	 */

	public function template() {
		$blocks = md_post_meta( array( 'page_blocks', 'blocks' ), true );
		if ( ! empty( $blocks ) ) {
			$pos = md_post_meta( array( 'page_blocks', 'position' ) );
			$position = ! empty( $pos ) ? $pos : 'md_hook_before_content_box';
			add_action( 'wp_head', array( $this, 'head' ) );
			add_action( $position, array( $this, 'frontend_template' ) );
		}
	}

	/**
	 * Build admin meta box fields.
	 *
	 * @since 1.0
	 */

	public function meta_box() { ?>
		<div class="alignright">
			<?php $this->field( 'select', 'position', array(
				'' => __( 'Select position on page...', 'md-child-theme' ),
				'md_hook_before_html' => __( 'Before HTML', 'md-child-theme' ),
				'md_hook_after_header' => __( 'After Header', 'md-child-theme' ),
				'md_hook_before_content_box' => __( 'Before Content Box (default)', 'md-child-theme' ),
				'md_hook_content' => __( 'After Post', 'md-child-theme' ),
				'md_hook_before_footer' => __( 'Before Footer', 'md-child-theme' ),
				'md_hook_after_footer' => __( 'After Footer', 'md-child-theme' )
			) ); ?>
		</div>
		<?php $this->fields->field( 'blocks', array(
			'type' => 'group',
			'callback' => array( $this, 'page_blocks' ),
			'style' => 'boxes'
		) ); ?>
	<?php }

	/**
	 * Repeatable admin meta box field for Content Boxes.
	 *
	 * @since 1.0
	 */

	public function page_blocks( $group, $field ) {
		$page_blocks = md_post_meta( array( 'page_blocks', 'blocks' ), true );
		include( 'templates/admin.php' );
	}

	/**
	 * Add custom styles to wp_head.
	 *
	 * @since 1.0
	 */

	public function head() {
		$page_blocks = md_post_meta( array( 'page_blocks', 'blocks' ), true );
		include( 'templates/head.php' );
	}

	/**
	 * Build frontend HTML template.
	 *
	 * @since 1.0
	 */

	public function frontend_template() {
		$page_blocks = md_post_meta( array( 'page_blocks', 'blocks' ), true );
		include( 'templates/template.php' );
	}

}
new md_page_blocks;

endif;