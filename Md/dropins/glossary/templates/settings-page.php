
<h1 class="md-spacer"><?php _e( 'Glossary', 'md-child-theme' ); ?></h1>

<!-- General Settings -->

<h2><?php echo __( 'Archives Settings', 'md-child-theme' ); ?></h2>

<div class="columns-2 columns-double">
	<div class="col">
		<div class="md-sep-small">
			<p><?php $this->label( 'archives_title', __( 'Page Title', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'text', 'archives_title', null, array(
				'atts' => array(
					'placeholder' => __( 'The Glossary', 'md-child-theme' )
				)
			) ); ?>
			<?php $this->desc( __( 'Add an <code>h1</code> title tag to the top of the archives page.', 'md-child-theme' ) ); ?>
		</div>
		<div class="md-sep-small">
			<p><?php $this->label( 'archives_subtitle', __( 'Page Subtitle', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'text', 'archives_subtitle' ); ?>
		</div>
		<div class="md-sep-small">
			<p><?php $this->label( 'archives_search_text', __( 'Search Text', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'text', 'archives_search_text', null, array(
				'atts' => array(
					'placeholder' => __( 'Search by letter:', 'md-child-theme' )
				)
			) ); ?>
		</div>
		<div class="md-sep-small">
			<p><?php $this->label( 'archives_text', __( 'Page Text', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'textarea', 'archives_text', null, array(
				'rows' => 4
			) ); ?>
			<?php $this->desc( __( 'Add a text description below the archives title.', 'md-child-theme' ) ); ?>
		</div>
	</div>
	<div class="col">
		<div class="md-sep-small">
			<p><?php $this->label( 'archives_slug', __( 'Page Slug', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'text', 'archives_slug', null, array(
				'atts' => array(
					'placeholder' => 'glossary'
				)
			) ); ?>
			<?php $this->desc( __( 'Change the URL of the bookshelf archives page.', 'md-child-theme' ) ); ?>
		</div>
		<div class="md-sep-small">
			<p><?php $this->label( 'archives_listing', __( 'Page Layout', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'checkbox', 'archives_layout', $layout ); ?>
			<?php $this->desc( sprintf( __( 'To add a <b>custom sidebar</b>, first enable it here, then go to the "Edit Sidebars" in the <a href="%s">Widgets</a> panel.', 'md-child-theme' ), admin_url( 'widgets.php' ) ) ); ?>
		</div>
	</div>
</div>

<hr class="md-sep" />

<!-- Single Pages -->

<div style="max-width: 650px;">

	<h2><?php echo __( 'Single Page Settings', 'md-child-theme' ); ?></h2>

	<div class="md-sep-small">
		<p><?php $this->label( 'single_prefix', __( 'Term Prefix', 'md-child-theme' ) ); ?></p>
		<?php $this->field( 'text', 'single_prefix', null, array(
			'atts' => array(
				'placeholder' => __( 'What is:', 'md-child-theme' )
			)
		) ); ?>
		<?php $this->desc( __( 'Add a prefix to the beginning of every Glossary Term.', 'md-child-theme' ) ); ?>
	</div>

	<div class="md-sep-small">
		<p><?php $this->label( 'single_after_title', __( 'After Post Title', 'md-child-theme' ) ); ?></p>
		<?php $this->field( 'text', 'single_after_title', null, array(
			'atts' => array(
				'placeholder' => __( 'Learn More', 'md-child-theme' )
			)
		) ); ?>
	</div>

	<div class="md-sep-small">
		<p><?php $this->label( 'single_after_text', __( 'After Post Text', 'md-child-theme' ) ); ?></p>
		<?php $this->field( 'textarea', 'single_after_text', null, array( 'rows' => 4 ) ); ?>
	</div>

</div>

<hr class="md-sep" />

<!-- Call to Action -->

<h2><?php echo __( 'Call to Action', 'md-child-theme' ); ?></h2>

<div class="md-sep-small">
	<p><?php $this->label( 'cta_type', __( 'Type', 'md-child-theme' ) ); ?></p>
	<?php $this->field( 'select', 'cta_type', array(
		'' => __( 'Select call to action type...', 'md-child-theme' ),
		'button' => __( 'Button URL', 'md-child-theme' ),
		'popup' => __( 'Popup', 'md-child-theme' ),
		'email' => __( 'Email Form', 'md-child-theme' )
	) ); ?>
</div>

<div id="glossary_ctas" style="display: <?php echo $ctas_display; ?>; max-width: 650px;">

	<hr />

	<!-- Titles and Description -->

	<div class="columns-2 columns-single">
		<div class="col">
			<p><?php $this->label( 'cta_title', __( 'CTA Title', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'text', 'cta_title' ); ?>
		</div>
		<div class="col">
			<p><?php $this->label( 'cta_subtitle', __( 'CTA Subtitle', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'text', 'cta_subtitle' ); ?>
		</div>
	</div>

	<div class="md-sep-small">
		<p><?php $this->label( 'cta_text', __( 'CTA Text', 'md-child-theme' ) ); ?></p>
		<?php $this->field( 'textarea', 'cta_text', null, array( 'rows' => 4 ) ); ?>
	</div>

	<!-- Button -->

	<div id="glossary_cta_button" style="display: <?php echo $button_display; ?>;">

		<div class="columns-2 columns-single">
			<div class="col">
				<p><?php $this->label( 'cta_button_text', __( 'Button Text', 'md-child-theme' ) ); ?></p>
				<?php $this->field( 'text', 'cta_button_text', null, array(
					'atts' => array(
						'placeholder' => __( 'Get access now', 'md-child-theme' )
					)
				) ); ?>
			</div>
			<div class="col">
				<p><?php $this->label( 'cta_button_url', __( 'Button URL', 'md-child-theme' ) ); ?></p>
				<?php $this->field( 'url', 'cta_button_url', null, array(
					'atts' => array(
						'placeholder' => 'https://'
					)
				) ); ?>
			</div>
		</div>

		<!-- Popup -->

		<div id="glossary_cta_popup" class="md-sep-small" style="display: <?php echo $popup_display; ?>;">
			<p><?php $this->label( 'cta_popup', __( 'Popup', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'select', 'cta_popup', $popups ); ?>
		</div>

	</div>

	<!-- Email Form -->

	<div  id="glossary_cta_email" style="display: <?php echo $email_display; ?>;">

		<div class="columns-2 columns-single">
			<div class="col">
				<div class="md-sep-small">
					<?php $this->fields->field( 'cta_email', array(
						'type' => 'select',
						'label' => __( 'Email List', 'md-child-theme' ),
						'options' => md_email_data(),
						'empty_label' => __( 'Select an email list...', 'md-child-theme' ),
						'optgroup' => true
					) ); ?>
				</div>
				<?php if ( ! empty( $data['enabled']['aweber'] ) || ! empty( $data['enabled']['mailerlite'] ) ) : ?>
					<div class="md-spacer-small">
						<p><?php $this->label( 'cta_email_thank_you', sprintf( __( 'Thank You Page URL %s', 'md-child-theme' ), '<span class="required">*</span>' ) ); ?></p>
						<?php $this->field( 'url', 'cta_email_thank_you', null, array(
							'atts' => array( 'placeholder' => get_site_url() . '/thank-you/' )
						) ); ?>
						<?php $this->desc( sprintf( __( 'Subscribers will be redirected to this URL after signup. Leave blank to use settings from your email provider. <br /><small>%s only available for AWeber & MailerLite forms.</small>', 'md-child-theme' ), '<span class="required">*</span>' ) ); ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="col">
				<div class="md-sep-small">
					<?php $this->field( 'checkbox', 'cta_email_input', array(
						'name' => __( 'Ask for subscribers name in signup form', 'md-child-theme' ),
					) ); ?>
				</div>
				<div id="cta_name_label_field" class="md-sep-small" style="display: <?php echo $name_display; ?>;">
					<p><?php $this->label( 'cta_email_name_label', __( 'Name Field Label', 'md-child-theme' ) ); ?></p>
					<?php $this->field( 'text', 'cta_email_name_label', null, array(
						'atts' => array(
							'placeholder' => __( 'Enter your name&hellip;', 'md-child-theme' )
						)
					) ); ?>
				</div>
				<div class="md-sep-small">
					<p><?php $this->label( 'cta_email_email_label', __( 'Email Field Label', 'md-child-theme' ) ); ?></p>
					<?php $this->field( 'text', 'cta_email_email_label', null, array(
						'atts' => array(
							'placeholder' => __( 'Enter your email&hellip;', 'md-child-theme' )
						)
					) ); ?>
				</div>
				<div class="md-sep-small">
					<p><?php $this->label( 'cta_email_submit_text', __( 'Submit Button Text', 'md-child-theme' ) ); ?></p>
					<?php $this->field( 'text', 'cta_email_submit_text', null, array(
						'atts' => array(
							'placeholder' => __( 'Get Access Now', 'md-child-theme' )
						)
					) ); ?>
				</div>
			</div>

		</div>

	</div>

</div>

<?php $this->fields->save(); ?>