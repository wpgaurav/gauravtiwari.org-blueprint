<?php

// Load required files

require_once( 'template-functions.php' );

if ( ! class_exists( 'video_lead' ) ) :

class video_lead extends md_api {

	/**
	 * Run actions and filters.
	 *
	 * @since 5.0
	 */

	public function actions() {
		if ( md_has( 'popups' ) )
			add_filter( 'md_button_actions', array( $this, 'video_button_action' ) );
	}

	/**
	 * Register admin page, meta box, and terms.
	 *
	 * @since 4.5
	 */

	public function register() {
		$this->name = __( 'Video Lead', 'md' );
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
	 * Load Video Lead to frontend when needed.
	 *
	 * @since 4.5
	 */

	public function template() {
		if ( has_video_lead() ) {
			$position = video_lead_field( 'position' );
			if ( $position == 'md_hook_after_header' )
				$position = 'md_hook_before_content_box';
			$order    = video_lead_field( 'order' );
			$priority = ! empty ( $order ) ? $order : 10;

			add_action( $position, array( $this, 'load_template' ), $priority );

			if ( md_has( 'md_popups' ) ) {
				add_action( 'md_api_button_popup_js', array( $this, 'play_button_js' ) );
				add_action( 'md_popups', array( $this, 'popup_template' ) );
			}
		}
	}

	/**
	 * Load popup template if play button is set.
	 *
	 * @since 4.5
	 */

	public function popup_template() {
		$service = video_lead_field( 'service' );
	?>
		<div id="md_popup_video_lead" class="md-popup video-lead-popup">
			<?php video_lead_video( $service ); ?>
			<div class="md-popup-close md-popup-close-corner">&times;</div>
		</div>
	<?php }

	/**
	 * Loads the template where there's a Video Lead. Override this template in
	 * a child theme by creating /templates/video-lead.php and copying the
	 * original source from the plugin's template file into the new file.
	 *
	 * @since 4.5
	 */

	public function load_template() {
		$path = 'templates/video-lead.php';

		if ( $template = locate_template( $path ) )
			load_template( $template );
		else
			load_template( dirname( __FILE__ ) . "/$path" );
	}

	/**
	 * Register custom admin settings to be saved and sanitized.
	 *
	 * @since 4.5
	 */

	public function register_fields() {
		$button = new md_button( $this->_id );
		$button_fields = $button->register_fields();
		$page_leads = md_page_leads_data();

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
			'layout' => array(
				'type' => 'select',
				'options' => array(
					'video-left',
					'video-right',
					'center'
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
			'subtitle' => array(
				'type' => 'text'
			),
			'headline' => array(
				'type' => 'text',
			),
			'desc' => array(
				'type' => 'textarea',
			),
			'service' => array(
				'type' => 'select',
				'options' => array(
					'youtube',
					'vimeo',
					'embed'
				)
			),
			'youtube' => array(
				'type' => 'url'
			),
			'vimeo' => array(
				'type' => 'url'
			),
			'embed' => array(
				'type' => 'code'
			),
			'embed_format' => array(
				'type'    => 'checkbox',
				'options' => array( 'enable' )
			)
		), $button_fields );
	}

	/**
	 * Add custom button actions to select field.
	 *
	 * @since 4.5
	 */

	public function video_button_action() {
		return array(
			'play' => __( 'Play button', 'md' )
		);
	}

	public function admin_page() {
		$this->admin_template();
	}

	public function admin_scripts() {
		$this->scripts();
	}

	public function meta_box() {
		$this->module_template();
	}

	public function meta_scripts() {
		$this->scripts();
	}

	public function term() { ?>
		<div class="md-widget md-toggle md-sep-small">
			<h3 class="md-widget-title"><?php echo $this->name; ?></h3>
			<div class="md-widget-item">
				<?php $this->module_template(); ?>
			</div>
		</div>
	<?php }

	public function term_scripts() {
		$this->scripts();
	}

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
	 * @since 4.5
	 */

	public function admin_template() {
		$screen  = get_current_screen();
		$button = new md_button( $this->_id );
		$design  = new md_design_options( $this->_id, '#DDDDDD' );
		$service = $this->fields->module( 'service' );
		$_prefix = "{$this->_option}_{$this->_id}";
		$_get_option = get_md( $this->_id );
		$page_leads = md_page_leads_data();
		$videos  = array(
			'youtube' => array(
				'label'       => __( 'YouTube URL', 'md' ),
				'placeholder' => 'https://www.youtube.com/embed/xxx'
			),
			'vimeo' => array(
				'label'       => __( 'Vimeo URL', 'md' ),
				'placeholder' => 'https://player.vimeo.com/video/xxx'
			)
		);
	?>

		<div class="md-content-wrap">

			<h3 class="md-meta-h3"><?php _e( 'Display Options', 'md' ); ?></h3>

			<table class="form-table">
				<tbody>

					<!-- Position + Order -->

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

							</td>

						</tr>

					<?php endif; ?>

					<!-- Layout -->

					<tr>
						<th scope="row">
							<?php $this->label( 'layout', __( 'Layout', 'md' ) ); ?>
						</th>

						<td>
							<?php $this->field( 'select', 'layout', array(
								'video-left'  => __( 'Content / Video (default)', 'md' ),
								'video-right' => __( 'Video / Content', 'md' ),
								'center'      => __( '1 column, center', 'md' )
							) ); ?>
						</td>
					</tr>

				</tbody>
			</table>

			<!-- Design -->

			<?php $design->fields(); ?>

			<h3 class="md-meta-h3"><?php _e( 'Content', 'md' ); ?></h3>

			<table class="form-table">
				<tbody>

					<!-- Subtitle -->

					<tr>

						<th scope="row">
							<?php $this->label( 'subtitle', __( 'Subtitle', 'md' ) ); ?>
						</th>

						<td>
							<?php $this->field( 'text', 'subtitle' ); ?>
						</td>

					</tr>

					<!-- Headline -->

					<tr>

						<th scope="row">
							<?php $this->label( 'headline', __( 'Headline', 'md' ) ); ?>
						</th>

						<td>
							<?php $this->field( 'text', 'headline' ); ?>
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

				</tbody>
			</table>

			<!-- Button -->

			<?php $button->fields(); ?>

			<h3 class="md-meta-h3"><?php _e( 'Video', 'md' ); ?></h3>

			<!-- Video -->

			<table class="form-table">
				<tbody>

					<tr>
						<th scope="row">
							<?php $this->label( 'service', __( 'Video Service', 'md' ) ); ?>
						</th>

						<td>
							<?php $this->field( 'select', 'service', array(
								''        => __( 'Select video service&hellip;', 'md' ),
								'youtube' => __( 'YouTube', 'md' ),
								'vimeo'   => __( 'Vimeo', 'md' ),
								'embed'   => __( 'Embed Code', 'md' )
							) ); ?>
						</td>
					</tr>

					<!-- Video URLs -->

					<?php foreach( $videos as $id => $fields ) : ?>

						<tr id="<?php echo "{$_prefix}_{$id}_row"; ?>" style="display: <?php echo $service == $id ? 'table-row' : 'none'; ?>">
							<th scope="row">
								<?php $this->label( $id, $fields['label'] ); ?>
							</th>

							<td>
								<?php $this->field( 'text', $id, null, array(
									'atts' => array(
										'placeholder' => $fields['placeholder']
									)
								) ); ?>
							</td>

						</tr>

					<?php endforeach; ?>

					<!-- Embed Code -->

					<tr id="<?php echo "{$_prefix}_embed_row"; ?>" style="display: <?php echo $service == 'embed' ? 'table-row' : 'none'; ?>">

						<th scope="row">
							<?php $this->label( 'embed', __( 'Video Embed Code', 'md' ) ); ?>
						</th>

						<td>

							<div class="md-spacer">
								<?php $this->field( 'code', 'embed' ); ?>
								<?php $this->desc( __( 'Paste your HTML video embed code here.', 'md' ) ); ?>
							</div>

							<?php $this->field( 'checkbox', 'embed_format', array(
								'enable' => __( 'Enable WordPress post filters (check if using shortcodes)', 'md' )
							) ); ?>

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


	/**
	 * Load Video Lead scripts to admin page footer.
	 *
	 * @since 4.5
	 */

	public function scripts() {
		$screen = get_current_screen();
		$_prefix = "{$this->_option}_{$this->_id}";
	?>

		<script>
			( function() {
				<?php if ( $screen->base == 'marketers-delight_page_md_page_leads_settings' ) : ?>
					// display
					document.getElementById( '<?php echo $_prefix; ?>_display_site' ).onchange = function() {
						document.getElementById( '<?php echo $_prefix; ?>_display_conditional' ).style.display = this.checked == '' ? 'block' : 'none';
					}
				<?php endif; ?>
				// videos
				document.getElementById( '<?php echo $_prefix; ?>_service' ).onchange = function() {
					document.getElementById( '<?php echo $_prefix; ?>_youtube_row' ).style.display   = this.value == 'youtube' ? 'table-row' : 'none';
					document.getElementById( '<?php echo $_prefix; ?>_vimeo_row' ).style.display     = this.value == 'vimeo' ? 'table-row' : 'none';
					document.getElementById( '<?php echo $_prefix; ?>_embed_row' ).style.display     = this.value == 'embed' ? 'table-row' : 'none';
				}
			})();
		</script>

	<?php }

}

endif;
new video_lead;