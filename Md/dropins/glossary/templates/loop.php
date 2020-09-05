<<?php echo $html; ?> id="<?php echo esc_attr( $term->slug ); ?>" class="glossary-term box shadow-small block-double mb-single format">
	<div class="columns-20-80 columns-double">
		<div class="col col1 mb-half">
			<h2 class="glossary-term-letter"><?php echo $term->name; ?></h2>
		</div>
		<div class="col col2">
			<div class="columns-2 columns-single">
				<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
					<div class="col mb-half">
						<a href="<?php the_permalink(); ?>" class="glossary-link<?php echo is_singular() && $page_id == get_the_ID() ? ' active' : ''; ?>"><?php the_title(); ?></a>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</<?php echo $html; ?>>