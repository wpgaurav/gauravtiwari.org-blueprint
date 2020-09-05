<?php 
   // the query
   $the_query = new WP_Query( array(
      'posts_per_page' => -1,
	  'post_type' => 'resource',
   )); 
?>

<?php if ( $the_query->have_posts() ) : ?>
<div class="content-portfolio-wrapper" style="max-width:1200px; margin:10px auto">
<div class="content-portfolio">
<div class="blog-teasers">
	<div class="columns-4 columns-single columns-flex">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<article style="background:none; box-shadow:none" id="content-<?php the_ID(); ?>" <?php post_class( array( 'col' ) ); ?> <?php md_article_schema(); ?>>
					<?php md_hook_teaser_top(); ?>
					<?php if ( has_post_thumbnail() ) : ?>
			<a rel="nofollow" target="_blank" href="<?php the_field('resource_url');?>"><?php md_featured_image( 'above_headline', 'thumbnail' ); ?></a>
					<?php endif; ?>
    <div class="<?php echo md_teaser_classes(); ?> white shadow white shadow blog-teaser-x">
							<h3 style="padding:10px; font-size:22px" class="teaser-title mb-small"><?php the_title(); ?></h3>
		<p style="padding:10px; font-size:16px"><?php the_field('about_the_resource');?>
		</p>
					<a style="color:#fff; text-align:center" rel="nofollow" target="_blank" href="<?php the_field('resource_url');?>" class="deal-button button button-arrow button-small"><?php the_field('resource_cta');?></a>

			</div>
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