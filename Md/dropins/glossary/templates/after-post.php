<div class="glossary-after content-width auto">

	<div class="text-center mb-mid">

		<h2><?php echo apply_filters( 'the_title', $title ); ?></h2>

		<?php if ( ! empty( $text ) ) : ?>
			<?php echo wpautop( $text ); ?>
		<?php endif; ?>

	</div>

	<?php $this->loop(); ?>

	<?php $this->call_to_action(); ?>

</div>