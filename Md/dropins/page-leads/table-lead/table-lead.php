<?php
/**
 * Builds the Funnel Lead frontend, and adds settings
 * into the Page Leads interface.
 *
 * @since 4.0
 */

class table_lead extends md_api {

	/**
	 * Include files.
	 *
	 * @since 5.0
	 */

	public function includes() {
		require_once( 'functions/template-functions.php' );
		require_once( 'functions/js.php' );
	}

	/**
	 * Run hooks and filters.
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
		$this->name = __( 'Table Lead', 'md' );
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
	 * Load Table Lead to frontend when needed.
	 *
	 * @since 4.1
	 */

	public function template() {
		if ( has_table_lead() ) {
			$position = table_lead_field( 'position' );
			if ( $position == 'md_hook_after_header' )
				$position = 'md_hook_before_content_box';
			$order    = table_lead_field( 'order' );
			$priority = ! empty ( $order ) ? $order : 10;

			add_action( $position, array( $this, 'load_template' ), $priority );
			add_action( 'wp_footer', 'table_lead_js' );
		}
	}

	/**
	 * Loads the template where there's a Table Lead. Override this template in
	 * a child theme by creating /templates/table-lead.php and copying the
	 * original source from the plugin's template file into the new file.
	 *
	 * since 4.1
	 */

	public function load_template() {
		$template      = table_lead_field( 'template' );
		$template_name = ! empty( $template ) ? $template : 'featured';
		$path          = "templates/table-lead-$template_name.php";

		if ( $template = locate_template( $path ) )
			load_template( $template );
		else
			load_template( dirname( __FILE__ ) . "/$path" );
	}

	/**
	 * Registers fields to be saved.
	 *
	 * @since 4.0
	 */

	public function register_fields() {
		$columns = array();
		$button = new md_button( $this->_id );
		$page_leads = md_page_leads_data();

		foreach ( array( 1, 2, 3 ) as $c ) {
			$columns[] = array_merge( array(
				"col{$c}_listing" => array(
					'type'          => 'group',
					'fields' => array(
						'list_item' => array(
							'type'  => 'text'
						)
					)
				),
				"col{$c}_headline" => array(
					'type' => 'text'
				),
				"col{$c}_subtitle" => array(
					'type' => 'text'
				),
				"col{$c}_price" => array(
					'type' => 'text'
				),
				"col{$c}_price_term" => array(
					'type' => 'text'
				),
				"col{$c}_footnotes" => array(
					'type' => 'textarea'
				)
			), $button->register_fields( "col{$c}_" ) );
		}

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
			'template' => array(
				'type' => 'select',
				'options' => array(
					'pro',
					'featured'
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
			'headline' => array(
				'type' => 'text',
			),
			'desc' => array(
				'type' => 'textarea',
			),
			'notice_text' => array(
				'type' => 'textarea'
			),
			'show_payment' => array(
				'type'    => 'checkbox',
				'options' => array( 'cards' )
			),
		 ), call_user_func_array( 'array_merge', $columns ) );
	}

	public function admin_page() {
		$this->admin_template();
	}

	public function meta_box() {
		$this->module_template();
	}

	public function term() { ?>
		<div class="md-widget md-toggle md-sep-small">
			<h3 class="md-widget-title"><?php echo $this->name; ?></h3>
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
	 * Creates settings in admin tab and meta box.
	 *
	 * @since 4.0
	 */

	public function admin_template() {
		$screen = get_current_screen();
		$design = new md_design_options( $this->_id, '#FFFFFF' );
		$button = new md_button( $this->_id );
		$page_leads = md_page_leads_data();
		$_prefix = "{$this->_option}_{$this->_id}";
		$_get_option = get_md( $this->_id );
	?>
		<div class="md-content-wrap">
			<h3 class="md-meta-h3"><?php _e( 'Display Options', 'md' ); ?></h3>
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
			<?php $design->fields(); ?>
			<hr class="md-hr" />
			<h3 class="md-meta-h3"><?php _e( 'Lead Content', 'md' ); ?></h3>
			<table class="form-table md-sep">
				<tbody>
					<tr>
						<th scope="row">
							<?php $this->label( 'headline', __( 'Headline', 'md' ) ); ?>
						</th>
						<td>
							<?php $this->field( 'text', 'headline' ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<?php $this->label( 'desc', __( 'Description', 'md' ) ); ?>
						</th>
						<td>
							<?php $this->field( 'textarea', 'desc' ); ?>
						</td>
					</tr>
					<?php $columns = array(
						1 => __( 'Left Table', 'md' ),
						2 => __( 'Middle Table', 'md' ),
						3 => __( 'Right Table', 'md' )
					); ?>
					<?php foreach ( $columns as $c => $label ) : ?>
						<tr>
							<td colspan="2">
								<div class="md-widget md-toggle">
									<h3 class="md-widget-title"><?php _e( $label ); ?></h3>
									<div class="md-widget-item">
										<table class="form-table">
											<tbody>
												<tr>
													<th scope="row">
														<?php $this->label( "col{$c}_headline", __( 'Headline', 'md' ) ); ?>
													</th>

													<td>
														<?php $this->field( 'text', "col{$c}_headline" ); ?>
													</td>
												</tr>
												<tr>
													<th scope="row">
														<?php $this->label( "col{$c}_subtitle", __( 'Subtitle', 'md' ) ); ?>
													</th>

													<td>
														<?php $this->field( 'text', "col{$c}_subtitle" ); ?>
													</td>
												</tr>
												<tr>
													<th scope="row">
														<?php $this->label( "col{$c}_price", __( 'Price', 'md' ) ); ?>
													</th>
													<td>
														<?php $this->fields->field( "col{$c}_price", array(
															'type' => 'text',
															'placeholder' => __( '$20', 'md' ),
															'style'        => 'width: 70px'
														) ); ?>
														<?php $this->fields->field( "col{$c}_price_term", array(
															'type' => 'text',
															'placeholder' => __( '/month', 'md' ),
															'style'        => 'width: 70px'
														) ); ?>
													</td>
												</tr>
												<tr>
													<th scope="row">
														<?php _e( 'Table Listing', 'md' ); ?>
													</th>
													<td>
														<?php $this->fields->field( "col{$c}_listing", array(
															'type' => 'group',
															'callback' => array( $this, 'col_listing' )
														) ); ?>
													</td>
												</tr>
											</tbody>
										</table>
										<?php $button->fields( "col{$c}_" ); ?>
										<table class="form-table">
											<tbody>
												<tr>
													<th scope="row">
														<?php $this->label( "col{$c}_footnotes", __( 'Footnotes', 'md' ) ); ?>
													</th>
													<td>
														<?php $this->field( 'textarea', "col{$c}_footnotes" ); ?>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<th scope="row">
							<?php _e( 'Show payment methods', 'md' ); ?>
						</th>
						<td>
							<?php $this->field( 'checkbox', 'show_payment', array(
								'cards' => __( 'Show credit card / PayPal icons underneath table', 'md' )
							) ); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<?php $this->label( 'notice_text', __( 'Notice Text', 'md' ) ); ?>
						</th>
						<td>
							<?php $this->field( 'textarea', 'notice_text' ); ?>
							<?php $this->desc( __( 'Display a short message underneath the table. For example, a money-back guarantee or a short customer testimonial.', 'md'  ) ); ?>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Save -->
			<?php if ( $screen->base == 'marketers-delight_page_md_page_leads_settings' ) : ?>
				<?php $this->fields->save(); ?>
			<?php endif; ?>
		</div>
	<?php }

	public function add_to_design_options() {
		echo '<div class="md-spacer">';
		$this->label( 'template', __( 'Template', 'md' ) );
		$this->field( 'select', 'template', array(
			'featured' => __( 'Featured (default)', 'md' ),
			'pro'      => __( 'Professional', 'md' ),
		) );
		echo '</div>';
	}

	/**
	 * These settings are repeated and called in $this->fields().
	 *
	 * @since 4.0
	 */

	public function col_listing( $group, $field ) {
		$this->fields->field( array( $group, $field, 'list_item' ), array(
			'label' => __( 'List Item', 'md' ),
			'type' => 'text'
		) );
	}

}
new table_lead;