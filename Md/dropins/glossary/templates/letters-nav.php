<div class="glossary-letters">
	<div class="inner text-center">
		<?php foreach ( $terms as $term_count => $term ) :
			$active = $term->term_id == get_queried_object_id() ? ' active' : '';
		?>
			<a href="<?php echo esc_url( "{$archive_link}#" . $term->slug ); ?>" class="glossary-letter<?php echo $active; ?>"><?php echo esc_html( $term->name ); ?></a>
		<?php endforeach; ?>
	</div>
</div>