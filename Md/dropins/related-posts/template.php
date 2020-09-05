<div class="related-posts">
	<div class="block-single">
		<h3 class="text-center"><?php echo $settings['title']; ?></h3>
		<div class="columns-<?php echo $settings['columns']; ?> columns-single columns-flex">
			<?php while ( $related->have_posts() ) : $related->the_post(); ?>
				<div class="col mb-mid">
					<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink()?>"><?php md_featured_image( 'above_headline', 'thumbnail' ); ?></a>
					<?php endif; ?>
					<div class="box block-single shadow-small">
						<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</div>