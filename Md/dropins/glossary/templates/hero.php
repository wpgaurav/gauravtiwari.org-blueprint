<div class="glossary-hero box">
	<div class="inner">
		<div class="glossary-content format text-center">
			<?php if ( ! empty( $subtitle ) ) : ?>
				<p class="caps"><?php echo apply_filters( 'the_title', $subtitle ); ?></p>
			<?php endif; ?>
			<h1 class="mb-half"><?php echo ! empty( $title ) ? apply_filters( 'the_title', $title ) : __( 'The Glossary', 'md-child-theme' ); ?></h1>
			<?php if ( ! empty( $text ) ) : ?>
				<div class="block-quad-lr micro-text mb-mid">
					<?php echo wpautop( $text ); ?>
				</div>
			<?php endif; ?>
			<p class="small caps mb-half"><?php echo ! empty( $search_text ) ? esc_html( $search_text ) : __( 'Search by letter:', 'md-child-theme' ); ?></p>
		</div>
	</div>
</div>