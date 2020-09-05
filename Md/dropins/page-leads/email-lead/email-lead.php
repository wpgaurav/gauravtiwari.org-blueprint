<?php

/**
 * Builds the Email Lead frontend, and adds settings
 * into the Page Leads interface.
 *
 * @since 1.0
 */

class email_lead extends md_api {

	/**
	 * Include required files.
	 *
	 * @since 4.0
	 */

	public function includes() {
		require_once( 'template-functions.php' );
	}

	/**
	 * Fire hooks and filters.
	 *
	 * @since 4.0
	 */

	public function actions() {
		add_action( "{$this->_id}_design_options_top", array( $this, 'add_to_design_options' ) );
	}

	/**
	 * Register admin page, meta box, and terms.
	 *
	 * @since 5.0
	 */

	public function register() {
		$this->name = __( 'Email Lead', 'md' );
		return array(
			'admin_page' => array(
				'name' => $this->name,
				'parent' => 'md_page_leads_settings',
				'fields' => $this->register_fields()
			),
			'meta_box' => array(
				'name' => $this->name,
				'fields' => $this->register_fields()
			),
			'term' => array(
				'name' => $this->name,
				'fields' => $this->register_fields()
			)
		);
	}

	/**
	 * Load Email Lead to frontend when needed.
	 *
	 * @since 4.1
	 */

	public function template() {
		if ( has_email_lead() ) {
			$position = email_lead_field( 'position' );
			if ( $position == 'md_hook_after_header' )
				$position = 'md_hook_before_content_box';
			$order    = email_lead_field( 'order' );
			$priority = ! empty ( $order ) ? $order : 10;
			add_action( $position, array( $this, 'load_template' ), $priority );
		}
	}

	/**
	 * Loads the template where there's a Email Lead. Override this template in
	 * a child theme by creating /templates/email-lead.php and copying the
	 * original source from the plugin's template file into the new file.
	 *
	 * @since 4.1
	 */

	public function load_template() {
		$path = 'templates/email-lead.php';
		if ( $template = locate_template( $path ) )
			load_template( $template );
		else
			load_template( dirname( __FILE__ ) . "/$path" );
	}

	/**
	 * Register custom admin settings to be saved and sanitized.
	 *
	 * @since 4.0
	 */

	public function register_fields() {
		$page_leads = md_page_leads_data();
		$email = new md_email_fields( $this->_id );
		return array_merge( array(
			'activate' => array(
				'type' => 'checkbox',
				'options' => array( 'enable' )
			),
			'custom' => array(
				'type' => 'checkbox',
				'options' => array( 'enable' )
			),
			'position' => array(
				'type'    => 'select',
				'options' => $page_leads['hooks']
			),
			'order' => array(
				'type' => 'number'
			),
			'style' => array(
				'type' => 'checkbox',
				'options' => array( 'left-right' )
			),
			'display' => array(
				'type'    => 'checkbox',
				'options' => array(
					'site',
					'blog',
					'posts',
					'pages'
				)
			),
			'blog' => array(
				'type'    => 'checkbox',
				'options' => array(
					'enable'
				)
			),
			'bg_color' => array(
				'type' => 'color'
			),
			'bg_image' => array(
				'type' => 'upload',
				'upload_type' => 'media'
			),
			'text_color_scheme' => array(
				'type' => 'select',
				'options' => array(
					'dark',
					'white'
				)
			)
		), $email->register_fields() );
	}

	public function admin_page() {
		$this->admin_template();
	}

	public function meta_box() {
		$this->module_template();
	}

	public function term() { ?>
		<div class="md-widget md-toggle md-sep-small">
			<h3 class="md-widget-title"><?php echo __( 'Email Lead', 'md' ); ?></h3>
			<div class="md-widget-item">
				<?php $this->module_template(); ?>
			</div>
		</div>
	<?php }

	public function module_template() {
		$screen = get_current_screen();
		$enable_field = $this->fields->module( 'activate', 'enable' );
		$custom_field = $this->fields->module( 'custom', 'enable' );
		$enable = ! empty( $enable_field ) ? 'block' : 'none';
		$custom = ! empty( $custom_field ) ? 'block' : 'none';
	?>
		<div class="md-meta-box md">
			<?php $this->field( 'checkbox', 'activate', array(
				'enable' => sprintf( __( 'Enable <b>%s</b>', 'md' ), $this->name )
			) ); ?>
			<div id="<?php echo "{$this->_prefix}_module"; ?>" style="display: <?php echo $enable; ?>">
				<div id="<?php echo "{$this->_prefix}_custom"; ?>">
					<?php $this->field( 'checkbox', 'custom', array(
						'enable' => sprintf( __( 'Create Custom <b>%s</b>', 'md' ), str_replace( 'Custom ', '', $this->name ) )
					) ); ?>
				</div>
				<div id="<?php echo $this->_prefix; ?>_fields" style="display: <?php echo $custom; ?>">
					<hr />
					<?php $this->admin_template(); ?>
				</div>
			</div>
		</div>
		<script>
			( function() {
				document.getElementById( '<?php echo "{$this->_prefix}_activate_enable"; ?>' ).onchange = function( e ) {
					document.getElementById( '<?php echo "{$this->_prefix}_module"; ?>' ).style.display = this.checked ? 'block' : 'none';
				}
				document.getElementById( '<?php echo "{$this->_prefix}_custom_enable"; ?>' ).onchange = function( e ) {
					document.getElementById( '<?php echo "{$this->_prefix}_fields"; ?>' ).style.display = this.checked ? 'block' : 'none';
				}
			})();
		</script>
	<?php }

	/**
	 * Creates admin settings.
	 *
	 * @since 4.0
	 */

	public function admin_template() {
		$email  = new md_email_fields( $this->_id );
		$design = new md_design_options( $this->_id, '#DDDDDD' );
		$screen = get_current_screen();
		echo '<div class="md-content-wrap-wide">';
		$this->display();
		echo '<div class="md-sep-small">';
		$email->fields();
		echo '</div>';
		$design->fields();
		if ( $screen->base == 'marketers-delight_page_md_page_leads_settings' )
			$this->fields->save();
		echo '</div>';
	}

	/**
	 * Adds extra options into the design options box.
	 *
	 * @since 4.2.2
	 */

	public function add_to_design_options() { ?>
		<div class="md-sep">
			<p><?php $this->label( 'style', __( 'Layout', 'md' ) ); ?></p>
			<?php $this->field( 'checkbox', 'style', array(
				'left-right' => __( 'Show title + description on left, email form on right', 'md' )
			) ); ?>
		</div>
	<?php }

	/**
	 * Adds display options to the top of the Email Fields so
	 * options don't show until after Email List is selected.
	 *
	 * @since 4.0
	 */

	public function display() {
		$screen = get_current_screen();
		$page_leads = md_page_leads_data();
		$_prefix = "{$this->_option}_{$this->_id}";
		$_get_option  = get_md( $this->_id );
	?>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<?php $this->label( 'position', __( 'Position', 'md' ) ); ?>
					</th>
					<td>
						<?php $this->field( 'select', 'position', $page_leads['positions' ] ); ?>
						<?php $this->field( 'number', 'order', null, array(
							'atts' => array(
								'placeholder' => '10'
							)
						) ); ?>
						<?php $this->desc( __( 'Reorder any Page Leads you add to the same position above or below each other by setting higher/lower numbers.', 'md' ) ); ?>
					</td>
				</tr>
				<?php if ( $screen->base == 'marketers-delight_page_md_page_leads_settings' ) : ?>
					<tr>
						<th scope="row">
							<?php $this->label( 'display', __( 'Display', 'md' ) ); ?>
						</th>
						<td>
							<?php $this->field( 'checkbox', 'display', array(
								'site'  => __( 'Show sitewide', 'md' )
							) ); ?>
							<div id="<?php echo $_prefix; ?>_display_conditional" style="display: <?php echo empty( $_get_option['display']['site'] ) ? 'block' : 'none'; ?>">
								<?php $this->field( 'checkbox', 'display', array(
									'blog'  => __( 'Show on blog posts page', 'md' ),
									'posts' => __( 'Show on all posts', 'md' ),
									'pages' => __( 'Show on all pages', 'md' )
								) ); ?>
								<?php $this->desc( __( 'You can add custom Page Leads by editing any post, page, or category.', 'md' ) ); ?>
							</div>
							<script>
								( function() {
									document.getElementById( '<?php echo $_prefix; ?>_display_site' ).onchange = function() {
										document.getElementById( '<?php echo $_prefix; ?>_display_conditional' ).style.display = this.checked == '' ? 'block' : 'none';
									}
								})();
							</script>
						</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>

	<?php }

}

$email_lead = new email_lead;