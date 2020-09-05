<h2 style="text-align:center; font-size:28px" class="block-single" id="recent-posts">I have been writing since 2008. Here's what I wrote recently.</h2>
<?php 
   // the query
   $the_query = new WP_Query( array(
      'posts_per_page' => 12,
	  'ignore_sticky_posts' => 1,
   )); 
?>

<?php if ( $the_query->have_posts() ) : ?>
<div class="content-standard content-teasers block-single-lr" style="max-width:1200px; margin:auto">
<div class="content-inner">
<div class="blog-teasers">
	<div class="columns-3 columns-single columns-flex">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<article id="content-<?php the_ID(); ?>" <?php post_class( array( 'col' ) ); ?> <?php md_article_schema(); ?>>
					<?php md_hook_teaser_top(); ?>
					<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>"><?php md_featured_image( 'above_headline', 'thumbnail' ); ?></a>
					<?php endif; ?>
    <div class="<?php echo md_teaser_classes(); ?> shadow blog-teaser-x box block-half">
						<h2 class="teaser-title mb-small" style="font-size:19px; line-height:1.4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="content-footer <?php echo md_byline_classes(); ?>">
				<div class="content-footer-author">
						<?php md_byline_item( 'badge' ); ?>
					<?php md_byline_item( 'category' ); ?>
				</div>
			</div>
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

<div class="block-single" style="max-width:1200px; margin-left:auto; margin-right:auto">
	<div class="content-upgrade has-white-background-color has-text-color mb-mid block-single box-lr shadow" style=" color: #1E1E1E;">
<div class="content-upgrade-text mb-single">
<p>Visit my blog for more tutorials, blogging tips, business guides &amp; study notes.</p>
</div>
<div class="content-upgrade-action">
<a href="/blog/" class="button button-arrow has-button-background-color" style="max-width:1200px; margin:auto">Visit blog</a>
</div>
</div>
</div>