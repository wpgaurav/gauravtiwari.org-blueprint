<?php 
   // the query
   $the_query = new WP_Query( array(
      'posts_per_page' => 6,
	  'post_type' => 'deal',
	   'orderby' => 'rand',
   )); 
?>

<?php if ( $the_query->have_posts() ) : ?>
<div class="content-deal-single-wrapper">
<div class="content-deal">
<div class="blog-teasers">
	<div class="columns-4 columns-single columns-flex">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<article style="background:none; box-shadow:none" id="content-<?php the_ID(); ?>" <?php post_class( array( 'col' ) ); ?> <?php md_article_schema(); ?>>
					<?php md_hook_teaser_top(); ?>
					<?php if ( has_post_thumbnail() ) : ?>
			<a rel="nofollow" target="_blank" href="<?php the_field('affiliate_url');?>"><?php md_featured_image( 'above_headline', 'thumbnail' ); ?></a>
					<?php endif; ?>
			</article>
		<?php endwhile; ?>
	</div>
</div>
  <?php wp_reset_postdata(); ?>
</div>
</div>
<?php else : ?>
  <?php md_template( 'content-item-404' ); ?>
<?php endif; ?>