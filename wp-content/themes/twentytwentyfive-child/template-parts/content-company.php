<article  id="post-<?php the_ID(); ?>" class="entry item <?php foreach((get_the_category()) as $category){ echo $category->slug." "; }?> <?php $posttags = wp_get_post_terms( $post->ID, 'post_tag', array( 'fields' => 'slugs' ) ); if ($posttags){foreach($posttags as $tag){ echo $tag . ' ';}}?>">
		<?php if ($posttags): ?><?php foreach( $posttags as $tag) : if ( $tag === 'exited' ) :?><div class="antetitle"><?php print_r($tag);?></div><?php else : endif; endforeach; ?><?php endif; ?>
		<header class="entry-header">
		<h2 class="entry-title hide"><?php the_field('company-name'); ?></h2>
		<?php $company_logo_b = get_field('company-logo-b'); if ($company_logo_b) : ?>
		<div class="company-logo-content" style="background-image:url('<?php echo the_field('company-logo-b'); ?>');">
		</div>
		<?php endif; ?>
		<ul class="category">
			<?php foreach((get_the_category()) as $category){echo "<li>" .$category->name. "</li>"; } ?>
		</ul>
		<?php $c_location = get_field('company-loactions'); if ($c_location) : ?>
			<p class="company-location"><?php the_field('company-loactions'); ?></p>
		<?php endif; ?>
		<?php $c_tagline = get_field('company-tagline'); if ($c_tagline) : ?>
		<p class="company-tagline"><?php the_field('company-tagline'); ?></p>
		<?php endif; ?>
		<?php
		$case_study = get_field('company-case');
		$company_website = get_field('company-website');
		
		if ($case_study or $company_website) : ?><div class="company-links"><?php endif; ?>
			<?php if ($case_study) : ?>
				<a class="btn btn-white case-study" rel="<?php the_ID(); ?>" href="<?php the_permalink();?>"><?php _e('Case study','PDP'); ?></a>
			<?php endif; ?>
			<?php if ($company_website) : ?>
				<a class="btn btn-white" href="<?php the_field('company-website'); ?>" target="_blank"><?php _e('Web','PDP'); ?></a>
			<?php endif; ?>
		<?php if ($case_study or $company_website) : ?></div><?php endif; ?>

	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
			<div class="post-thumbnail">
				<?php $white_logo = get_field('company-logo-w'); if ($white_logo) :?><img class="company-logo" src="<?php echo the_field('company-logo-w'); ?>" title="<?php the_field('company-name'); ?>" /><?php endif; ?>
				<?php the_post_thumbnail( 'thumbnail' ); ?>
			</div><!-- .post-thumbnail -->
		<?php endif; ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->