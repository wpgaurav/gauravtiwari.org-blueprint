<?php
/**
 * Call this class to display generic MD email form fields and
 * associated save data.
 *
 * @since 4.0
 * @deprecated 5.0
 */

class md_email_fields extends md_api {

	/**
	 * Build array to save email form options.
	 *
	 * @zince 4.7
	 */

	public function register_fields() {
		return array(
			'email_list' => array(
				'type' => 'select',
				'options' => md_email_data( array( 'show' => 'ids' ) )
			),
			'email_title' => array(
				'type' => 'text'
			),
			'email_desc' => array(
				'type' => 'code'
			),
			'email_classes' => array(
				'type' => 'text'
			),
			'email_input' => array(
				'type' => 'checkbox',
				'options' => array(
					'name'
				)
			),
			'email_name_label' => array(
				'type' => 'text'
			),
			'email_email_label' => array(
				'type' => 'text'
			),
			'email_submit_text' => array(
				'type' => 'text'
			),
			'email_form_style' => array(
				'type'    => 'checkbox',
				'options' => array( 'attached' )
			),
			'email_form_title' => array(
				'type' => 'text'
			),
			'email_form_footer' => array(
				'type' => 'textarea'
			),
			'email_thank_you' => array(
				'type' => 'url'
			),
			'email_code' => array(
				'type' => 'code'
			)
		);
	}

	/**
	 * Build admin form HTML.
	 *
	 * @since 1.0
	 */

	public function fields() {
		$screen = get_current_screen();
		$_prefix = "{$this->_option}_{$this->_clean_id}";
		$data = md_setting( array( 'integrations' ) );
		$email_list = $this->module_field( 'email_list' );
		$input = $this->module_field( 'email_input' );
		$input_name = isset( $input['name'] ) ? $input['name'] : '';
	?>

		<div id="<?php echo $_prefix; ?>_fields">

			<?php do_action( "{$this->_id}_email_fields_top" ); ?>

			<h3 class="md-meta-h3"><?php echo __( 'Email Form Settings', 'md' ); ?></h3>

			<div class="columns-2 columns-single md-sep-small">

				<div class="col">

					<!-- List -->

					<div class="md-sep-small">
						<?php $this->fields->field( 'email_list', array(
							'type' => 'select',
							'optgroup' => true,
							'label' => __( 'Email List', 'md' ),
							'empty_label' => __( 'Select an email list...', 'md' ),
							'options' => md_email_data()
						) ); ?>
					</div>

					<!-- Title -->

					<div class="md-sep-small">
						<p><?php $this->label( 'email_title', __( 'Title', 'md' ) ); ?></p>
						<?php $this->field( 'text', 'email_title' ); ?>
					</div>

					<!-- Description -->

					<div class="md-sep-small">
						<p><?php $this->label( 'email_desc', __( 'Description', 'md' ) ); ?></p>
						<?php $this->field( 'textarea', 'email_desc' ); ?>
					</div>

					<!-- Classes -->

					<div class="md-sep-small">
						<p><?php $this->label( 'email_classes', __( '<acronym title="Cascading Style Sheets">CSS</acronym> Classes', 'md' ) ); ?></p>
						<?php $this->field( 'text', 'email_classes', null, array(
							'atts' => array(
								'placeholder' => 'form-full'
							)
						) ); ?>
					</div>

				</div>

				<div class="col">

					<!-- Form Fields -->

					<div class="md-sep-small">
						<p><?php $this->label( '#', __( 'Form Fields', 'md' ) ); ?></p>
						<?php $this->field( 'checkbox', 'email_form_style', array(
							'attached' => __( 'Attach input fields to each other in a single line', 'md' )
						) ); ?>
						<?php $this->field( 'checkbox', 'email_input', array(
							'name' => __( 'Ask for subscribers name in signup form', 'md' ),
						) ); ?>
					</div>

					<!-- Name Field Label -->

					<div id="<?php echo $_prefix; ?>_name_label_field" class="md-sep-small" style="display: <?php echo ! empty( $input['name'] ) ? 'block' : 'none'; ?>;">
						<p><?php $this->label( 'email_name_label', __( 'Name Field Label', 'md' ) ); ?></p>
						<?php $this->field( 'text', 'email_name_label', null, array(
							'atts' => array(
								'placeholder' => __( 'Enter your name&hellip;', 'md' )
							)
						) ); ?>
					</div>

					<!-- Email Field Label -->

					<div class="md-sep-small">
						<p><?php $this->label( 'email_email_label', __( 'Email Field Label', 'md' ) ); ?></p>
						<?php $this->field( 'text', 'email_email_label', null, array(
							'atts' => array(
								'placeholder' => __( 'Enter your email&hellip;', 'md' )
							)
						) ); ?>
					</div>

					<!-- Submit Button -->

					<div class="md-sep-small">
						<p><?php $this->label( 'email_submit_text', __( 'Submit Button Text', 'md' ) ); ?></p>
						<?php $this->field( 'text', 'email_submit_text', null, array(
							'atts' => array(
								'placeholder' => __( 'Join Now!', 'md' )
							)
						) ); ?>
					</div>

					<!-- Footer -->

					<div class="md-sep-small">
						<p><?php $this->label( 'email_form_title', __( 'Email Form Title', 'md' ) ); ?></p>
						<?php $this->field( 'text', 'email_form_title' ); ?>
					</div>
					<div class="md-sep-small">
						<p><?php $this->label( 'email_form_footer', __( 'Email Form Footer Text', 'md' ) ); ?></p>
						<?php $this->field( 'text', 'email_form_footer' ); ?>
					</div>

				</div>

			</div>

			<h3 class="md-meta-h3"><?php echo __( 'Extra Settings', 'md' ); ?></h3>

			<?php if ( ! empty( $data['enabled']['aweber'] ) || ! empty( $data['enabled']['mailerlite'] ) ) : ?>
				<div class="md-spacer-med">
					<p><?php $this->label( 'email_thank_you', sprintf( __( 'Thank You Page URL %s', 'md' ), '<span class="required">*</span>' ) ); ?></p>
					<?php $this->field( 'url', 'email_thank_you', null, array(
						'atts' => array( 'placeholder' => get_site_url() . '/thank-you/' )
					) ); ?>
					<?php $this->desc( sprintf( __( 'Subscribers will be redirected to this URL after signup. Leave blank to use settings from your email provider. <br /><small>%s only available for AWeber & MailerLite forms.</small>', 'md' ), '<span class="required">*</span>' ) ); ?>
				</div>
			<?php endif; ?>

			<?php do_action( "{$this->_id}_email_fields_bottom" ); ?>

			<!-- Custom Code -->

			<div class="md-content-wrap md-widget md-toggle md-sep-small">
				<h3 class="md-widget-title"><?php echo sprintf( __( '%s Form Code', 'md' ), '<acronym title="HyperText Markup Language">HTML</acronym>' ); ?></h3>
				<div class="md-widget-item">
					<?php $this->field( 'code', 'email_code' ); ?>
					<?php $this->desc( sprintf( __( 'For best results on formatting your email form code, refer to the <a href="%s" target="_blank">MD style guide</a>.', 'md' ), 'https://marketersdelight.com/style-guide/#email' ) ); ?>
				</div>
			</div>

		</div>

		<!-- Scripts -->

		<script>
			( function() {
				document.getElementById( '<?php echo $_prefix; ?>_email_list' ).onchange = function() {
					document.getElementById( '<?php echo $_prefix; ?>_email_form_fields' ).style.display = this.value != '' ? 'block' : 'none';
				}
				document.getElementById( '<?php echo $_prefix; ?>_email_input_name' ).onchange = function() {
					document.getElementById( '<?php echo $_prefix; ?>_name_label_field' ).style.display = this.checked ? 'block' : 'none';
				}
			})();
		</script>

	<?php }

}