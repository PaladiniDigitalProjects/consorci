<article  id="post-<?php the_ID(); ?>" class="entry item <?php foreach((get_the_category()) as $category){ echo $category->slug." "; }?> <?php $posttags = wp_get_post_terms( $post->ID, 'post_tag', array( 'fields' => 'slugs' ) ); if ($posttags){foreach($posttags as $tag){ echo $tag . '';}}?>">
	<a class="entry-link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
	<?php if (has_post_thumbnail( $post->ID ) ): ?>
		<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
		<div class="entry-image" style="background: url('<?php echo $image[0]; ?>') no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;background-size: cover;"></div>
	<?php endif; ?>
	<div class="entry-content">
		<p class="category"><?php foreach((get_the_category()) as $category){ echo $category->name." "; }?></p>
		<h2 class="entry-title"><?php the_title(); ?></h2>
	</div>
</article>