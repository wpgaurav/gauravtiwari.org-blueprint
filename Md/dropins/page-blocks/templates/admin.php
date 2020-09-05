<div class="md-page-blocks">
	<?php $this->fields->field( array( $group, $field, 'id' ), array(
		'type' => 'text',
		'hidden' => true
	) ); ?>
	<?php $this->fields->field( array( $group, $field, 'content' ), array(
		'type' => 'code'
	) ); ?>
	<div class="md-alignright mt-half">
		<?php $this->desc( sprintf( __( 'Refer to the <a href="%s" target="_blank">MD Style Guide</a> for coding tips + shortcuts.', 'md' ), 'https://marketersdelight.com/style-guide/' ) ); ?>
	</div>
	<?php $this->fields->field( array( $group, $field, 'format' ), array(
		'type' => 'checkbox',
		'options' => array(
			'enable' => __( 'Add WordPress post formatting', 'md' )
		)
	) ); ?>
	<hr />
	<div class="md-page-block-design columns-4 md-sep-small">
		<div class="col">
			<?php $this->fields->field( array( $group, $field, 'bg_color' ), array(
				'type' => 'color',
				'group' => true,
				'label' => __( 'Background Color', 'md' )
			) ); ?>
		</div>
		<div class="col">
			<?php $this->fields->field( array( $group, $field, 'color' ), array(
				'type' => 'color',
				'group' => true,
				'label' => __( 'Text Color', 'md' )
			) ); ?>
		</div>
		<div class="col">
			<?php $this->fields->field( array( $group, $field, 'links' ), array(
				'type' => 'color',
				'group' => true,
				'label' => __( 'Links Color', 'md' )
			) ); ?>
		</div>
		<div class="col">
			<?php $this->fields->field( array( $group, $field, 'margin_bottom' ), array(
				'type' => 'select',
				'label' => __( 'Margin Bottom', 'md' ),
				'empty_label' => __( 'Select margin...', 'md' ),
				'options' => array(
					'mb-half' => __( 'Half', 'md' ),
					'mb-single' => __( 'Single', 'md' ),
					'mb-mid' => __( 'Mid', 'md' ),
					'mb-double' => __( 'Double', 'md' ),
					'mb-triple' => __( 'Triple', 'md' ),
					'mb-quad' => __( 'Quadruple', 'md' )
				)
			) ); ?>
		</div>
	</div>
	<?php if ( ! empty( $blocks[$group] ) ) : ?>
		<div class="md-page-block-css md-widget md-toggle">
			<h3><?php echo __( 'Block CSS', 'md' ); ?></h3>
			<div class="md-widget-item">
				<div class="md-sep-small">
					<?php $this->fields->field( array( $group, $field, 'css' ), array(
						'type' => 'code',
						'label' => __( 'Enter custom CSS', 'md' )
					) ); ?>
				</div>
				<p><?php echo __( 'Block CSS selector: ', 'md' ); ?> <code>.page-block-<?php echo esc_attr( $blocks[$group] ); ?></code></p>
			</div>
		</div>
	<?php endif; ?>
</div>