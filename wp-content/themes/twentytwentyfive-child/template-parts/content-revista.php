<article id="post-<?php the_ID(); ?>" class="revista">
	<?php $revista_image = get_field('revista-portada');
		if( !empty($revista_image) ): ?>
		<img class="img-responsive" src="<?php echo $revista_image['url']; ?>" alt="<?php echo $revista_image['alt']; ?>" />
	<?php endif; ?>
	<header class="revista-header">
		<?php $revista_link = get_field('publicacion-digital');
			if( $revista_link ): ?>
			<a href="<?php echo the_field('publicacion-digital'); ?>">
		<?php endif; ?>
			<h2 class="revista-numero"><?php the_field('revista-numero'); ?></h2>
			<p><?php the_field('revista-tema'); ?></p>
		<?php if( $revista_link ): ?>
			</a>
		<?php endif; ?>

		<?php $revista_file = get_field('revista-pdf');
			if( $revista_file ): ?>
			<a href="<?php echo $revista_file['url']; ?>">
		<?php endif; ?>
			<h2 class="revista-numero"><?php the_field('revista-numero'); ?></h2>
			<p><?php the_field('revista-tema'); ?></p>
		<?php if( $revista_file ): ?>
			</a>
		<?php endif; ?>
	</header>
</article><!-- #post-## -->
