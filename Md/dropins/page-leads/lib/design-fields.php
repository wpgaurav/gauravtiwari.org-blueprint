<?php
/**
 * Design Options meta box that can be used to quickly output
 * Design Options into post meta boxes, admin settings pages,
 * and taxonomy settings.
 *
 * See its use in any Page Lead class.
 *
 * @note MD4.8 adds new design system, this thing is on the chopping block.
 * @since 4.3
 * @deprecated 5.0
 */

class md_design_options extends md_api {
	public function __construct( $id = null, $bg_color = '', $bg_image = null, $text_color = null ) {
		parent::__construct( $id );
		$this->bg_color = $bg_color;
		$this->text_color = $text_color;
	}
	public function fields() {
		$screen = get_current_screen();
		$text_color = $this->text_color == 'white' ?
			array(
				'white' => __( 'White (default)', 'md' ),
				'dark'  => __( 'Dark', 'md' ),
			)
		:
			array(
				'dark'  => __( 'Dark (default)', 'md' ),
				'white' => __( 'White', 'md' )
			);
	?>
		<div class="md-content-wrap md-widget md-toggle md-sep-small">
			<h3 class="md-widget-title"><?php echo __( 'Design Options', 'md' ); ?></h3>
			<div class="md-widget-item">
				<?php do_action( "{$this->_id}_design_options_top" ); ?>
				<div class="columns-2 columns-single">
					<div class="col md-sep-small">
						<p><?php $this->label( 'bg_color', __( 'Background Color', 'md' ) ); ?></p>
						<?php $this->field( 'color', 'bg_color', null, array(
							'default' => $this->bg_color
						) ); ?>
					</div>
					<div class="col">
						<p><?php $this->label( 'text_color_scheme', __( 'Text Color', 'md' ) ); ?></p>
						<?php $this->field( 'select', 'text_color_scheme', $text_color ); ?>
					</div>
				</div>
				<p><?php $this->label( 'bg_image', __( 'Background Image', 'md' ) ); ?></p>
				<?php $this->fields->field( 'bg_image', array(
					'type' => 'upload',
					'upload_type' => 'media'
				) ); ?>
				<?php do_action( "{$this->_id}_design_options_bottom" ); ?>
			</div>
		</div>
	<?php }
}