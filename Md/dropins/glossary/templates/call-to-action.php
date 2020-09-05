<div class="glossary-cta glossary-term box shadow-small block-mid mb-single format">

	<?php if ( ! empty( $subtitle ) ) : ?>
		<p class="caps mb-half text-sec"><?php echo apply_filters( 'the_title', $subtitle ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $title ) ) : ?>
		<p class="med-title bold mb-half"><?php echo apply_filters( 'the_title', $title ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $text ) ) : ?>
		<?php echo wpautop( $text ); ?>
	<?php endif; ?>

	<?php if ( in_array( $type, array( 'button', 'popup' ) ) && ( ! empty( $button_url ) || ! empty( $popup ) ) ) : ?>
		<p><a href="<?php echo esc_url( $button_url ); ?>" class="button button-arrow width-full<?php echo esc_attr( $popup_classes ); ?>"<?php echo $popup_data; ?>><?php echo esc_html( $button_text ); ?></a></p>
	<?php elseif ( $type == 'email' ) : ?>
		<?php md_email_form( $email ); ?>
	<?php endif; ?>

</div>