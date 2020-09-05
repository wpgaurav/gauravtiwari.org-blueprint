<p class="glossary-breadcrumbs mb-single">
	<a class="mr-small" href="<?php echo esc_attr( $archive_link ); ?>"><?php echo __( 'Glossary', 'md-child-theme' ); ?></a>
	<i class="md-icon-angle-right mr-small"></i>
	<a href="<?php echo esc_attr( "{$archive_link}#" . $terms[0]->slug ); ?>" class="mr-small"><?php echo esc_html( $terms[0]->name ); ?></a>
	<i class="md-icon-angle-right mr-small"></i>
	<?php echo get_the_title(); ?>
</p>