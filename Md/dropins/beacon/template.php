<div<?php echo $menu_id; ?> class="<?php echo esc_attr( $classes ); ?>">
    <a<?php echo $trigger_id; ?> class="beacon-status" href="<?php echo esc_url( $url ); ?>"></a>
    <?php if ( $status == 'on' ) : ?>
	    <span class="beacon-pulse"></span>
    <?php endif; ?>
    <?php if ( ! isset( $args['trigger_only'] ) ) : ?>
	    <div class="beacon-content block-single">
	        <div class="beacon-text">
				<?php echo wpautop( $text ); ?>
			</div>
	        <a href="<?php echo esc_url( $url ); ?>" class="button button-arrow"><?php echo esc_html( $button_text ); ?></a>
	    </div>
	<?php endif; ?>
</div>