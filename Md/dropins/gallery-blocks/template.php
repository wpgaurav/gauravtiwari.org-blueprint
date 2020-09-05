<div class="gallery-blocks">
	<div class="inner">
		<div class="format text-center">
			<?php if ( ! empty( $title ) || ! empty( $text ) ) : ?>
				<div class="block-single">
					<?php if ( ! empty( $title ) ) : ?>
						<h2><?php echo esc_html( $title ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $text ) ) : ?>
						<?php echo wpautop( $text ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="columns-<?php echo esc_attr( $columns ); ?> columns-single columns-flex block-single-lr">
				<?php foreach ( $blocks as $block => $fields ) :
					$button_text = ! empty( $fields['button_text'] ) ? $fields['button_text'] : $default_button_text;
					$button_url = ! empty( $fields['button_url'] ) ? $fields['button_url'] : '#';
					$button_classes = empty( $fields['button_url'] ) ? ' md-popup-trigger' : '';
					$button_atts = empty( $fields['button_url'] ) ? ' data-popup="md_popup_gallery_block_' . esc_attr( $block ) . '"' : '';
				?>
					<div class="col col<?php echo $c; ?> mb-half">
						<?php if ( ! empty( $fields['thumbnail'] ) ) : ?>
							<p class="mb-none box block-half pb-none shadow">
								<a href="<?php echo esc_url( $button_url ); ?>" target="_blank">
									<img alt="<?php echo $fields['name']; ?>" src="<?php echo esc_url( $fields['thumbnail']['url'] ); ?>" />
								</a>
							</p>
						<?php endif; ?>
						<div class="shadow box">
							<p class="mb-single" style="padding:10px 7px; line-height:1.1"><strong><?php echo $fields['name']; ?></strong></p>
							<?php if ( ! empty( $fields['text'] ) ) : ?>
								<?php echo wpautop( $fields['text'] ); ?>
							<?php endif; ?>
							<a href="<?php echo esc_url( $button_url ); ?>" class="button button-arrow width-full<?php echo esc_attr( $button_classes); ?>"<?php echo $button_atts; ?>><?php echo esc_html( $button_text ); ?></a>
						</div>
					</div>
				<?php $c++; endforeach; ?>
			</div>
		</div>
	</div>
</div>