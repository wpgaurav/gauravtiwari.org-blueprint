<?php
/**
 * Create admin settings page for Glossary.
 *
 * @since 1.0
 */

class md_glossary_admin extends md_api {

	/**
	 * Fire important class actions.
	 *
	 * @since 1.0
	 */

	public function actions() {
		$this->_id = 'md_glossary';
		add_action( 'admin_bar_menu', array( $this, 'admin_bar' ), 100 );
	}

	/**
	 * Register admin interface
	 *
	 * @since 1.0
	 */

	public function register() {
		return array(
			'admin_page' => array(
				'name' => __( 'Settings', 'md' ),
				'parent_slug' => 'edit.php?post_type=glossary',
				'panel_tab' => false,
				'fields' => $this->register_fields()
			)
		);
	}

	/**
	 * Add Glossary Archives link to Admin Bar.
	 *
	 * @since 1.0
	 */

	public function admin_bar( $admin_bar ) {
		if ( is_admin() ) {
			$screen = get_current_screen();
			if ( $screen->base == 'glossary_page_md_glossary' ) {
				$option_slug = md_setting( array( 'glossary', 'archives_slug' ) );
				$slug = ! empty( $option_slug ) ? $option_slug : 'glossary';
				$admin_bar->add_menu( array(
					'id' => "{$this->_prefix}-archives-link",
					'title' => __( 'View Glossary', 'md' ),
					'href' => esc_url( get_site_url() . '/' . $slug ),
					'meta' => array(
						'title' => __( 'View Glossary', 'md' ),
						'target' => '_blank'
					)
				) );
			}
		}
		elseif ( is_post_type_archive( 'glossary' ) )
			$admin_bar->add_menu( array(
				'id' => "{$this->_prefix}-archives-link",
				'title' => __( 'Edit Glossary', 'md' ),
				'href' => esc_url( admin_url( 'edit.php?post_type=glossary&page=md_glossary' ) ),
				'meta' => array(
					'title' => __( 'Edit Glossary', 'md' )
				)
			) );
	}

	/**
	 * Save and sanitize save data for fields above.
	 *
	 * @since 1.0
	 */

	public function register_fields() {
		// Popups data
		$popups = array();
		$popups_data = md_setting( array( 'popups', 'popups' ) );
		if ( ! empty( $popups_data ) )
			foreach ( $popups_data as $popup => $fields )
				if ( ! empty( $popup ) )
					$popups[] = $popup;

		// List of fields to save
		return array(
			'archives_slug' => array( 'type' => 'text' ),
			'archives_subtitle' => array( 'type' => 'text' ),
			'archives_title' => array( 'type' => 'text' ),
			'archives_search_text' => array( 'type' => 'text' ),
			'archives_text' => array( 'type' => 'textarea' ),
			'archives_layout' => array(
				'type' => 'checkbox',
				'options' => array( 'main_menu', 'sidebar' )
			),
			'single_prefix' => array( 'type' => 'text' ),
			'single_after_title' => array( 'type' => 'text' ),
			'single_after_text' => array( 'type' => 'textarea' ),
			'cta_subtitle' => array( 'type' => 'text' ),
			'cta_title' => array( 'type' => 'text' ),
			'cta_text' => array( 'type' => 'textarea' ),
			'cta_type' => array(
				'type' => 'select',
				'options' => array( 'button', 'email', 'popup' )
			),
			'cta_button_text' => array( 'type' => 'text' ),
			'cta_button_url' => array( 'type' => 'url' ),
			'cta_popup' => array(
				'type' => 'select',
				'options' => $popups
			),
			'cta_email' => array(
				'type' => 'select',
				'options' => md_email_data( array( 'show' => 'ids' ) )
			),
			'cta_email_thank_you' => array( 'type' => 'url' ),
			'cta_email_input' => array(
				'type' => 'checkbox',
				'options' => array( 'name' )
			),
			'cta_email_name_label' => array( 'type' => 'text' ),
			'cta_email_email_label' => array( 'type' => 'text' ),
			'cta_email_submit_text' => array( 'type' => 'text' )
		);
	}

	/**
	 * Create admin page for Glossary Settings.
	 *
	 * @since 1.0
	 */

	public function admin_page() {
		$layout = $popups = array();
		$data = md_setting( 'integrations' );
		// Layout data
		if ( md_has( 'main_menu' ) )
			$layout['main_menu'] = __( 'Remove <b>Main Menu</b>', 'md' );
		$layout['sidebar'] = __( 'Add <b>Sidebar</b>', 'md' );
		// Popups data
		$popups_data = md_setting( array( 'popups', 'popups' ) );
		if ( ! empty( $popups_data ) )
			foreach ( $popups_data as $popup => $fields )
				$popups[$popup] = $fields['name'];
		$popups = array_merge( array( '' => __( 'Select a popup&hellip;', 'md' ) ), $popups );
		// Fields display
		$ctas_display = md_setting( array( 'glossary', 'cta_type' ) ) !== '' ? 'block' : 'none';
		$button_display = in_array( md_setting( array( 'glossary', 'cta_type' ) ), array( 'button', 'popup' ) ) ? 'block' : 'none';
		$popup_display = md_setting( array( 'glossary', 'cta_type' ) ) == 'popup' ? 'block' : 'none';
		$email_display = md_setting( array( 'glossary', 'cta_type' ) ) == 'email' ? 'block' : 'none';
		$name_display = md_setting( array( 'glossary', 'cta_email_input', 'name' ) ) ? 'block' : 'none';
		// Template
		include( 'templates/settings-page.php' );
	}

	/**
	 * Load field toggle scripts.
	 *
	 * @since 1.0
	 */

	public function admin_scripts() { ?>
		<script>
			document.getElementById( '<?php echo $this->_option; ?>_glossary_cta_type' ).onchange = function() {
				var ctas = document.getElementById( 'glossary_ctas' ),
					button = document.getElementById( 'glossary_cta_button' ),
					popup = document.getElementById( 'glossary_cta_popup' ),
					email = document.getElementById( 'glossary_cta_email' );
				if ( this.value !== '' ) {
					ctas.style.display = 'block';
					if ( this.value == 'button' || this.value == 'popup' ) {
						email.style.display = 'none';
						button.style.display = 'block';
						popup.style.display = this.value == 'popup' ? 'block' : 'none';
					}
					else if ( this.value == 'email' ) {
						button.style.display = popup.style.display = 'none';
						email.style.display = 'block';
					}
				}
				else
					ctas.style.display = button.style.display = popup.style.display = email.style.display = 'none';
			}
			document.getElementById( '<?php echo $this->_option; ?>_glossary_cta_email_input_name' ).onchange = function() {
				document.getElementById( 'cta_name_label_field' ).style.display = this.checked ? 'block' : 'none';
			}
		</script>
	<?php }

}