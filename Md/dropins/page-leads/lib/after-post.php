<?php
/**
 * Builds After Post meta box options and displays HTML
 * by firing to the md_hook_content hook. This needs to
 * be reworked.
 *
 * @since 4.0
 * @deprecated 5.0
 */

class md_after_post extends md_api {

	/**
	 * Pseudo constructor creates meta box and fires hooks.
	 *
	 * @since 4.0
	 */

	public function construct() {
		$this->meta_box = array( 'name' => __( 'After Post', 'md' ) );
		add_action( $this->_id . '_email_fields_bottom', array( $this, 'add_design_options' ) );
	}

	/**
	 * Load templates.
	 *
	 * @since 4.9
	 */

	public function template() {
		$select = md_get_meta( $this->_clean_id, 'select' );
		if ( ( is_singular() && $select != 'empty' ) )
			add_action( 'md_hook_content', array( $this, 'display' ), 11 );
	}

	/**
	 * Outputs After Post HTML to be fired to MD hook.
	 *
	 * @since 4.0
	 */

	public function display() {
		$select = md_get_meta( $this->_clean_id, 'select' );
		$block = md_design_block( 'md_hook_content' );
		$display_posts = get_md( 'email', 'email_after_post', 'display_posts' );
		if ( $select == 'email' || ( is_singular( 'post' ) && $display_posts ) ) {
			$fields = ! empty( $select ) ? $this->email_data() : null;
			md_email_form( $fields, array(
				'classes' => 'after-post inner text-center',
				'block_classes' => $block
			) );
		}
		elseif ( $select == 'action' )
			$this->action_box();
	}

	/**
	 * Creates the Action Box HTML output.
	 *
	 * @since 4.0
	 */

	function action_box() {
		$title = md_get_meta( $this->_clean_id, 'action_title' );
		$desc = md_get_meta( $this->_clean_id, 'action_desc' );
		$classes = md_get_meta( $this->_clean_id, 'action_classes' );
		$classes = ! empty( $classes ) ? " $classes" : '';
		$button_link = md_get_meta( $this->_clean_id, 'action_button_link' );
		$html = ! empty( $button_link ) ? 'a href="' . esc_url( $button_link ) . '"' : 'span';
		$c_html = ! empty( $button_link ) ? 'a' : 'span';
	?>
		<div class="action-box after-post content-item text-center<?php echo esc_attr( $classes ); ?>">
			<div class="inner <?php echo md_design_block( 'md_hook_content' ); ?>">
				<?php do_action( 'md_hook_action_box_top' ); ?>
				<?php if ( ! empty( $title ) ) : ?>
					<p class="large-title"><?php echo $title; ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $desc ) ) : ?>
					<?php echo wpautop( $desc ); ?>
				<?php endif; ?>
				<?php md_button( array(
					'action'  => md_get_meta( $this->_clean_id, 'button_action' ),
					'link'    => $button_link,
					'text'    => md_get_meta( $this->_clean_id, 'action_button_text' ),
					'edd_id'  => md_get_meta( $this->_clean_id, 'edd_button' ),
					'woo_id'  => md_get_meta( $this->_clean_id, 'woo_button' ),
					'popup'   => md_get_meta( $this->_clean_id, 'button_popup' ),
					'classes' => 'width-full mb-half'
				) ); ?>
				<?php do_action( 'md_hook_action_box_bottom' ); ?>
			</div>
		</div>
	<?php }

	/**
	 * Create options array to feed to the email form function
	 * (used in display() method).
	 *
	 * @since 4.0
	 */

	public function email_data() {
		$input  = md_get_meta( $this->_clean_id, 'email_input' );
		$style  = md_get_meta( $this->_clean_id, 'email_form_style' );

		$fields = array(
			'email_title' => md_get_meta( $this->_clean_id, 'email_title' ),
			'email_desc' => md_get_meta( $this->_clean_id, 'email_desc' ),
			'email_list' => md_get_meta( $this->_clean_id, 'email_list' ),
			'email_code' => md_get_meta( $this->_clean_id, 'email_code' ),
			'email_input' => array(
				'name' => ! empty( $input['name'] ) ? $input['name'] : ''
			),
			'email_name_label' => md_get_meta( $this->_clean_id, 'email_name_label' ),
			'email_email_label' => md_get_meta( $this->_clean_id, 'email_email_label' ),
			'email_submit_text' => md_get_meta( $this->_clean_id, 'email_submit_text' ),
			'email_form_style' => array(
				'attached' => ! empty( $style['attached'] ) ? $style['attached'] : ''
			),
			'email_form_title' => md_get_meta( $this->_clean_id, 'email_form_title' ),
			'email_form_footer' => md_get_meta( $this->_clean_id, 'email_form_footer' ),
			'email_thank_you' => md_get_meta( $this->_clean_id, 'email_thank_you' ),
			'email_bg_color' => md_get_meta( $this->_clean_id, 'bg_color' ),
			'email_text_color' => md_get_meta( $this->_clean_id, 'text_color_scheme' ),
			'email_image' => md_get_meta( $this->_clean_id, 'bg_image' ),
			'email_classes' => md_get_meta( $this->_clean_id, 'email_classes' )
		);

		return $fields;
	}

	/**
	 * Register fields to be sanitized & saved to database.
	 *
	 * @since 4.0
	 */

	public function register_fields() {
		$email = new md_email_fields( $this->_id );
		$button = new md_button( $this->_id );
		$button_fields = $button->register_fields( null, array(
			'button_text' => 'action_button_text',
			'button_link' => 'action_button_link'
		) );

		return array_merge( array(
			'select' => array(
				'type'    => 'select',
				'options' => array(
					'email',
					'action',
					'empty'
				)
			),
			'bg_color' => array(
				'type' => 'color'
			),
			'bg_image' => array(
				'type' => 'image'
			),
			'text_color_scheme' => array(
				'type' => 'select',
				'options' => array(
					'dark',
					'white'
				)
			),
			'action_title' => array(
				'type' => 'text'
			),
			'action_desc' => array(
				'type' => 'textarea'
			),
			'action_button_text' => array(
				'type' => 'text'
			),
			'action_button_link' => array(
				'type' => 'text'
			),
			'action_classes' => array(
				'type' => 'text'
			)
		), $email->register_fields(), $button_fields );
	}

	/**
	 * Hook design options to top of Email Form. Needs to be accessible
	 * from Action Box at some point, setup kinda weird right now.
	 *
	 * @since 4.0
	 */

	public function add_design_options() { ?>
		<div class="md-content-wrap md-widget md-toggle md-sep-small">
			<h3 class="md-widget-title"><?php echo __( 'Design Options', 'md' ); ?></h3>
			<div class="md-widget-item">
				<div class="columns-2 columns-single">
					<div class="col md-sep-small">
						<p><?php $this->label( 'bg_color', __( 'Background Color', 'md' ) ); ?></p>
						<?php $this->field( 'color', 'bg_color', null, array( 'default' => '#DDDDDD' ) ); ?>
					</div>
					<div class="col">
						<p><?php $this->label( 'text_color_scheme', __( 'Text Color', 'md' ) ); ?></p>
						<?php $this->field( 'select', 'text_color_scheme', array(
							'dark'  => __( 'Dark (default)', 'md' ),
							'white' => __( 'White', 'md' )
						) ); ?>
					</div>
				</div>
				<p><?php $this->label( 'bg_image', __( 'Background Image', 'md' ) ); ?></p>
				<?php $this->field( 'media', 'bg_image' ); ?>
			</div>
		</div>
	<?php }

	/**
	 * Create meta box fields.
	 *
	 * @since 4.0
	 */

	public function meta_box() {
		$button = new md_button( $this->_id );
		$email = new md_email_fields( $this->_id );
		$email_form = get_md( 'email' );
		$select = md_get_meta( $this->_clean_id, 'select' );
		$post = ! empty( $email_form['email_after_post']['display_posts'] ) ? array( 'empty'  => __( 'Leave empty', 'md' ) ) : array();
		$_prefix = "{$this->_option}_{$this->_clean_id}";
	?>

		<!-- Select -->

		<?php $this->fields->field( 'select', array(
			'type' => 'select',
			'options' => array_merge( array(
				'' => __( 'Show at the end of this post&hellip;', 'md' ),
				'email'  => __( 'Email Form', 'md' ),
				'action' => __( 'Action Box', 'md' ),
			), $post )
		) ); ?>

		<div id="<?php echo $_prefix; ?>_fields" style="display: <?php echo $select != '' ? 'block' : 'none'; ?>">

			<!-- Email Form -->

			<div id="<?php echo $_prefix; ?>_email_form" style="display: <?php echo $select == 'email' ? 'block' : 'none'; ?>">

				<p class="md-title"><?php _e( 'Create Custom Email Form', 'md' ); ?></p>

				<?php $this->desc( sprintf( __( 'Tip: If you leave the fields below empty, your <a href="%s" target="_blank">default email form</a> will appear at the end of this post.', 'md' ), admin_url( 'tools.php?page=md_email' ) ) ); ?>

				<?php $email->fields(); ?>

			</div>

			<!-- Action Box -->

			<div id="<?php echo $_prefix; ?>_action_box" style="display: <?php echo $select == 'action' ? 'block' : 'none'; ?>">

				<p class="md-title"><?php _e( 'Create Custom Action Box', 'md' ); ?></p>

				<!-- Title -->

				<div class="md-sep">
					<?php $this->fields->field( 'action_title', array(
						'type' => 'text',
						'label' => __( 'Title', 'md' )
					) ); ?>
				</div>

				<!-- Description -->

				<div class="md-sep">
					<?php $this->fields->field( 'action_desc', array(
						'type' => 'text',
						'label' => __( 'Description', 'md' )
					) ); ?>
				</div>

				<!-- Button -->

				<?php $button->fields( null, array(
					'button_text' => 'action_button_text',
					'button_link' => 'action_button_link'
				) ); ?>

				<!-- CSS Classes -->

				<div class="md-sep">
					<?php $this->fields->field( 'action_classes', array(
						'type' => 'text',
						'label' => __( 'CSS Classes', 'md' )
					) ); ?>
				</div>

			</div>

		</div>

		<script>
			( function() {
				document.getElementById( '<?php echo $_prefix; ?>_select' ).onchange = function() {
					document.getElementById( '<?php echo $_prefix; ?>_fields' ).style.display     = this.value != '' ? 'block' : 'none';
					document.getElementById( '<?php echo $_prefix; ?>_email_form' ).style.display = this.value == 'email' ? 'block' : 'none';
					document.getElementById( '<?php echo $_prefix; ?>_action_box' ).style.display = this.value == 'action' ? 'block' : 'none';
				}
			})();
		</script>

	<?php }

}

$md_after_post = new md_after_post;