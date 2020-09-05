<?php
/**
 * Builds the Funnel Lead frontend, and adds settings
 * into the Page Leads interface.
 *
 * @since 4.0
 */

if ( ! class_exists( 'funnel_lead' ) ) :

class funnel_lead extends md_api {

	/**
	 * Include required files.
	 *
	 * @since 4.0
	 */

	public function includes() {
		require_once( 'template-functions.php' );
	}

	/**
	 * Register admin page, meta box, and terms.
	 *
	 * @since 5.0
	 */

	public function register() {
		$this->name = __( 'Funnel Lead', 'md' );
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
	 * Load Funnel Lead to frontend when needed.
	 *
	 * @since 4.1
	 */

	public function template() {
		if ( has_funnel_lead() ) {
			$position = funnel_lead_field( 'position' );
			if ( $position == 'md_hook_after_header' )
				$position = 'md_hook_before_content_box';
			$order    = funnel_lead_field( 'order' );
			$priority = ! empty ( $order ) ? $order : 10;

			add_action( $position, array( $this, 'load_template' ), $priority );
		}
	}


	/**
	 * Loads the template where there's a Funnel Lead. Override this template in
	 * a child theme by creating /templates/funnel-lead.php and copying the
	 * original source from the plugin's template file into the new file.
	 *
	 * @since 4.1
	 */

	public function load_template() {
		$path = 'templates/funnel-lead.php';

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
		$columns = array();
		$button = new md_button( $this->_id );
		$page_leads = md_page_leads_data();

		foreach ( array( 1, 2, 3 ) as $c ) {
			$columns[] = array_merge( array(
				"col{$c}_image" => array(
					'type' => 'upload',
					'upload_type' => 'media'
				),
				"col{$c}_headline" => array(
					'type' => 'text'
				),
				"col{$c}_desc" => array(
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
			'display' => array(
				'type'    => 'checkbox',
				'options' => array(
					'site',
					'blog',
					'posts',
					'pages'
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
			'headline' => array(
				'type' => 'text',
			),
			'subtitle' => array(
				'type' => 'text'
			),
			'desc' => array(
				'type' => 'textarea',
			)
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
	 * Creates admin settings.
	 *
	 * @since 4.0
	 */

	public function admin_template() {
		$screen = get_current_screen();
		$design = new md_design_options( $this->_id, '#DDDDDD' );
		$button = new md_button( $this->_id );
		$page_leads = md_page_leads_data();
		$_get_option = get_md( $this->_id );
		$_prefix = "{$this->_option}_{$this->_id}";
	?>

		<div class="md-content-wrap">

			<h3 class="md-meta-h3"><?php _e( 'Display Options', 'md' ); ?></h3>

			<table class="form-table">
				<tbody>

					<!-- Position + Order -->

					<tr>
						<th scope="row">
							<?php $this->label( 'position', __( 'Funnel Position', 'md' ) ); ?>
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

						<!-- Display Settings -->

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

			<!-- Design -->

			<?php $design->fields(); ?>

			<hr class="md-hr" />

			<h3 class="md-meta-h3"><?php _e( 'Funnel Content', 'md' ); ?></h3>

			<table class="form-table">
				<tbody>

					<!-- Headline -->

					<tr>

						<th scope="row">
							<?php $this->label( 'headline', __( 'Headline', 'md' ) ); ?>
						</th>

						<td>
							<?php $this->field( 'text', 'headline' ); ?>
						</td>

					</tr>

					<!-- Subtitle -->

					<tr>

						<th scope="row">
							<?php $this->label( 'subtitle', __( 'Subtitle', 'md' ) ); ?>
						</th>

						<td>
							<?php $this->field( 'text', 'subtitle' ); ?>
						</td>

					</tr>

					<!-- Description -->

					<tr>

						<th scope="row">
							<?php $this->label( 'desc', __( 'Description', 'md' ) ); ?>
						</th>

						<td>
							<?php $this->field( 'textarea', 'desc' ); ?>
						</td>

					</tr>

					<!-- Columns -->

					<?php $columns = array(
						1 => __( 'Left Column', 'md' ),
						2 => __( 'Middle Column', 'md' ),
						3 => __( 'Right Column', 'md' )
					); ?>

					<?php foreach ( $columns as $c => $label ) : ?>

						<tr>
							<td colspan="2">
								<div class="md-widget md-toggle">
									<h3 class="md-widget-title"><?php _e( $label ); ?></h3>
									<div class="md-widget-item">
										<table class="form-table">
											<tbody>

												<!-- Headline -->

												<tr>
													<th scope="row">
														<?php $this->label( "col{$c}_headline", __( 'Headline', 'md' ) ); ?>
													</th>

													<td>
														<?php $this->field( 'text', "col{$c}_headline" ); ?>
													</td>
												</tr>

												<!-- Description -->

												<tr>
													<th scope="row">
														<?php $this->label( "col{$c}_desc", __( 'Description', 'md' ) ); ?>
													</th>

													<td>
														<?php $this->field( 'textarea', "col{$c}_desc" ); ?>
													</td>
												</tr>

											</tbody>
										</table>

										<?php $button->fields( "col{$c}_" ); ?>

										<table class="form-table">
											<tbody>

												<!-- Image -->

												<tr valign="top">
													<th scope="row">
														<?php $this->label( "col{$c}_image", __( 'Upload an image', 'md' ) ); ?>
													</th>

													<td>
														<?php $this->field( 'upload', "col{$c}_image", null, array( 'upload_type' => 'media' ) ); ?>
														<?php $this->desc( __( 'Recommended image size: 400x200', 'md' ) ); ?>
													</td>
												</tr>

											</tbody>
										</table>
									</div>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>

				</tbody>
			</table>

			<!-- Save -->
			<?php if ( $screen->base == 'marketers-delight_page_md_page_leads_settings' ) : ?>
				<?php $this->fields->save(); ?>
			<?php endif; ?>

		</div>

	<?php }

}

endif;

$funnel_lead = new funnel_lead;