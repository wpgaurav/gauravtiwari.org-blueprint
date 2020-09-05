<div id="page_blocks_<?php echo get_the_ID(); ?>" class="page-blocks format">
	<?php foreach ( $page_blocks as $block => $fields ) :
		$margin_bottom = ! empty( $fields['margin_bottom'] ) ? ' ' . $fields['margin_bottom'] : '';
	?>
		<div class="page-block page-block-<?php echo esc_attr( $block ); ?><?php echo esc_attr( $margin_bottom ); ?>">
			<?php if ( ! empty( $fields['format']['enable'] ) ) : ?>
				<?php echo apply_filters( 'the_content', $fields['content'] ); ?>
			<?php elseif ( ! empty( $fields['content'] ) ) : ?>
				<?php echo $fields['content']; ?>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>