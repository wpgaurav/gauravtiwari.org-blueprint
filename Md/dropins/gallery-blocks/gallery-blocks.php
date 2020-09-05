<?php
/**
 * Dropin Name: Gallery Blocks
 * Dropin Author: Alex Mangini
 * Dropin Demo: https://marketersdelight.net/dropins/gallery/
 * Dropin Description: A simple Gallery meta box that allows you to create an image gallery with popup lightboxes.
 * Dropin Version: 1.1
 */

if ( ! class_exists( 'md_gallery_blocks' ) ) :

class md_gallery_blocks extends md_api {

	/**
	 * Settings for quick adjustments.
	 */

	public $settings = array(
		'default_button_text' => 'Visit site',
		'columns' => 4
	);

	/**
	 * Start engine.
	 *
	 * @since 1.0
	 */

	public function register() {
		return array(
			'meta_box' => array(
				'name' => __( 'Gallery Blocks', 'md-child-theme' ),
				'post_types' => array( 'post', 'page' ),
				'fields' => array(
					'position' => array(
						'type' => 'select',
						'options' => array(
							'md_hook_before_html',
							'md_hook_after_header',
							'md_hook_before_content_box',
							'md_hook_content',
							'md_hook_before_footer',
							'md_hook_after_footer'
						)
					),
					'title' => array( 'type' => 'text' ),
					'text' => array( 'type' => 'textarea' ),
					'blocks' => array(
						'type' => 'group',
						'fields' => array(
							'name' => array( 'type' => 'text' ),
							'text' => array( 'type' => 'textarea' ),
							'button_text' => array( 'type' => 'text' ),
							'button_url' => array( 'type' => 'text' ),
							'thumbnail' => array(
								'type' => 'upload',
								'upload_type' => 'media'
							),
							'full_image' => array(
								'type' => 'upload',
								'upload_type' => 'media'
							)
						)
					)
				)
			)
		);
	}

	/**
	 * Build out admin fields.
	 *
	 * @since 1.0
	 */

	public function meta_box() { ?>
		<div class="md-sep-small">
			<p><?php $this->label( 'position', __( 'Position', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'select', 'position', array(
				'' => __( 'Select position on page...', 'md-child-theme' ),
				'md_hook_before_html' => __( 'Before HTML', 'md-child-theme' ),
				'md_hook_after_header' => __( 'After Header', 'md-child-theme' ),
				'md_hook_before_content_box' => __( 'Before Content Box (default)', 'md-child-theme' ),
				'md_hook_content' => __( 'After Post', 'md-child-theme' ),
				'md_hook_before_footer' => __( 'Before Footer', 'md-child-theme' ),
				'md_hook_after_footer' => __( 'After Footer', 'md-child-theme' )
			) ); ?>
		</div>
		<div class="md-sep-small">
			<p><?php $this->label( 'title', __( 'Title', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'text', 'title' ); ?>
		</div>
		<div class="md-sep">
			<p><?php $this->label( 'text', __( 'Text', 'md-child-theme' ) ); ?></p>
			<?php $this->field( 'textarea', 'text', null, array(
				'rows' => 5
			) ); ?>
		</div>
		<?php $this->fields->field( 'blocks', array(
			'type' => 'group',
			'style' => 'boxes',
			'title' => __( 'Gallery Blocks', 'md-child-theme' ),
			'callback' => array( $this, 'blocks' )
		) ); ?>
	<?php }

	/**
	 * Build individual Gallery Blocks.
	 *
	 * @since 1.0
	 */

	public function blocks( $group, $field ) { ?>
		<div class="md-sep-small">
			<?php $this->fields->field( array( $group, $field, 'text' ), array(
				'type' => 'textarea',
				'label' => __( 'Text', 'md-child-theme' )
			) ); ?>
		</div>
		<div class="columns-2 columns-single md-sep-small">
			<div class="col">
				<?php $this->fields->field( array( $group, $field, 'button_text' ), array(
					'type' => 'text',
					'label' => __( 'Button Text', 'md-child-theme' ),
					'placeholder' => $this->settings['default_button_text']
				) ); ?>
			</div>
			<div class="col">
				<?php $this->fields->field( array( $group, $field, 'button_url' ), array(
					'type' => 'text',
					'label' => __( 'Button URL', 'md-child-theme' ),
				) ); ?>
			</div>
		</div>
		<div class="columns-2 columns-single">
			<div class="col md-sep-small">
				<?php $this->fields->field( array( $group, $field, 'thumbnail' ), array(
					'type' => 'upload',
					'upload_type' => 'media',
					'label' => __( 'Thumbnail Image', 'md-child-theme' )
				) ); ?>
			</div>
			<div class="col">
				<?php $this->fields->field( array( $group, $field, 'full_image' ), array(
					'type' => 'upload',
					'upload_type' => 'media',
					'label' => __( 'Full Image', 'md-child-theme' )
				) ); ?>
			</div>
		</div>
	<?php }

	/**
	 * Manipulate templates.
	 *
	 * @since 1.0
	 */

	public function template() {
		$blocks = md_post_meta( array( 'gallery_blocks', 'blocks' ) );
		if ( ! empty( $blocks ) && is_singular() ) {
			$pos = md_post_meta( array( 'gallery_blocks', 'position' ) );
			$position = ! empty( $pos ) ? $pos : 'md_hook_before_content_box';
			add_action( $position, array( $this, 'gallery' ), 12 );
			$this->popups();
		}
	}

	/**
	 * Create popup gallery.
	 *
	 * since 1.0
	 */

	public function gallery() {
		$c = 1;
		$columns = $this->settings['columns'];
		$default_button_text = $this->settings['default_button_text'];
		$blocks = md_post_meta( array( 'gallery_blocks', 'blocks' ) );
		$title = md_post_meta( array( 'gallery_blocks', 'title' ) );
		$text = md_post_meta( array( 'gallery_blocks', 'text' ) );
		include( 'template.php' );
	}

	/**
	 * Manually create popup template for inline galleries.
	 *
	 * @since 1.0
	 */

	public function popup_template( $atts ) { ?>
		<div id="md_popup_<?php echo $atts['id']; ?>" class="md-popup">
			<div class="md-popup-content">
				<img src="<?php echo esc_url( $atts['full_image']['url'] ); ?>" />
			</div>
			<div class="md-popup-close md-popup-close-corner">&times;</div>
		</div>
	<?php }

	/**
	 * Programmatically add popups to the Showcase.
	 *
	 * @since 1.0
	 */

	public function popups() {
		$blocks = md_post_meta( array( 'gallery_blocks', 'blocks' ) );
		if ( ! empty( $blocks ) )
			foreach ( $blocks as $block => $fields ) {
				if ( empty( $fields['full_image']['url'] ) )
					continue;
				$fields['id'] = $block;
				md_popup( array(
					'id' => "gallery_block_{$block}",
					'callback' => array( $this, 'popup_template' ),
					'atts' => $fields
				) );
			}
	}

}
new md_gallery_blocks;

endif;