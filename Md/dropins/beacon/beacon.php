<?php
/**
 * The Beacon
 * by Alex Mangini
 * Demo: https://marketersdelight.com/dropins/beacon/
 *
 * Add a pulsating Beacon to your header to link to special
 * pages and indicate when you are for hire or not.
 *
 * @since 1.1
 */

class md_beacon extends md_api {

	/**
	 * Fire action hooks and load Beacon CSS to MD stylesheet.
	 *
	 * @since 1.0
	 */

	public function actions() {
		add_action( 'wp_dashboard_setup', array( $this, 'dashboard_register' ) );
		add_filter( 'md_dropins_css_templates', array( $this, 'css' ) );
		add_action( 'md_hook_header_aside', array( $this, 'beacon' ) );
		add_action( 'md_hook_header_triggers', array( $this, 'trigger' ) );
		add_action( 'wp_footer', array( $this, 'script' ) );
	}

	/**
	 * Add Beacon settings to Dashboard widgets.
	 *
	 * @since 1.0
	 */

	public function dashboard_register() {
		add_meta_box( 'md_beacon', __( 'Beacon', 'md' ), array( $this, 'dashboard_template' ), 'dashboard', 'side', 'high' );
	}

	/**
	 * Register admin fields for sanitization on save.
	 *
	 * @since 1.0
	 */

	public function register() {
		return array(
			'admin_page' => array(
				'name' => __( 'Beacon', 'md' ),
				'parent_slug' => false,
				'fields' => array(
					'status' => array(
						'type' => 'checkbox',
						'options' => array( 'off' )
					),
					'text' => array( 'type' => 'text' ),
					'button_text' => array( 'type' => 'text' ),
					'url' => array( 'type' => 'url' )
				)
			)
		);
	}

	/**
	 * Beacon admin fields.
	 *
	 * @since 1.0
	 */

	public function dashboard_template() { ?>
		<form id="md-form" class="md" method="post" action="options.php">
			<?php settings_fields( 'marketers_delight' ); ?>
			<?php $this->field( 'checkbox', 'status', array(
				'off' => __( 'Disable Beacon', 'md' )
			) ); ?>
			<p><?php $this->label( 'text', __( 'Text', 'md' ) ); ?></p>
			<?php $this->field( 'textarea', 'text', null, array( 'rows' => 4 ) ); ?>
			<div class="columns-2 columns-single">
				<div class="col md-sep-small">
					<p><?php $this->label( 'button_text', __( 'Button Text', 'md' ) ); ?></p>
					<?php $this->field( 'text', 'button_text', null, array(
						'atts' => array( 'placeholder' => 'Get access now' )
					) ); ?>
				</div>
				<div class="col md-sep-small">
					<p><?php $this->label( 'url', __( 'Button URL', 'md' ) ); ?></p>
					<?php $this->field( 'url', 'url', null, array(
						'atts' => array( 'placeholder' => 'https://' )
					) ); ?>
				</div>
			</div>
			<?php submit_button( __( 'Update Beacon', 'md' ) ); ?>
		</form>
	<?php }

	/**
	 * Add the Beacon stylesheet to the list of CSS files to be
	 * merged into the main MD style.css file on compile.
	 *
	 * @since 1.0
	 */

	public function css( $templates ) {
		$templates['beacon'] = trailingslashit( get_stylesheet_directory() ) . 'dropins/beacon/css.php';
		return $templates;
	}

	/**
	 * Get list of settings for use in template.
	 *
	 * @since 1.0
	 */

	public function settings() {
		return array(
			'status' => md_setting( array( 'beacon', 'status' ) ),
			'url' => md_setting( array( 'beacon', 'url' ) ),
			'text' => md_setting( array( 'beacon', 'text' ) ),
			'button_text' => md_setting( array( 'beacon', 'button_text' ) )
		);
	}

	/**
	 * Master template, call this method with arguments
	 * to customize display.
	 *
	 * @since 1.0
	 */

	public function beacon( $args = null ) {
		// set defaults
		$settings = $this->settings();
		$status = ! empty( $settings['status']['off'] ) ? 'off' : 'on';
		$url = ! empty( $settings['url'] ) ? $settings['url'] : '#';
		$text = ! empty( $settings['text'] ) ? $settings['text'] : __( 'Enter beacon text here.', 'md' );
		$button_text = ! empty( $settings['button_text'] ) ? $settings['button_text'] : __( 'Get access now', 'md' );
		// set classes
		$classes[] = 'beacon';
		$classes[] = $status;
		if ( isset( $args['trigger_only'] ) )
			$classes[] = 'beacon-trigger';
		else
			$classes[] = 'beacon-menu';
		$classes = join( ' ', $classes );
		// set ID's
		$menu_id = ! isset( $args['trigger_only'] ) ? ' id="beacon_menu"' : '';
		$trigger_id = isset( $args['trigger_only'] ) ? ' id="beacon_trigger"' : '';
		// load template
		include( 'template.php' );
	}

	/**
	 * Load template as menu trigger only.
	 *
	 * @since 1.0
	 */

	public function trigger() {
		$this->beacon( array( 'trigger_only' => true ) );
	}

	/**
	 * Load toggle script.
	 *
	 * @since 1.0
	 */

	public function script() { ?>
		<script>
			document.getElementById( 'beacon_trigger' ).onclick = function( e ) {
				e.preventDefault();
				MD.toggleClass( document.getElementById( 'beacon_menu' ), 'beacon-toggle' );
				MD.removeClass( document.getElementById( 'header' ), 'has-mobile-menu' );
			};
		</script>
	<?php }

}

new md_beacon;