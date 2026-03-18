<article class="entry entry-tarja item <?php if( ! empty($post_types)) { echo $post_types; } ?> <?php if ( ! empty( $categories ) ) { echo esc_html( $categories[0]->slug ); } ?>">
	<div class="entry-image" style="background:url('<?php echo ($thumbURLC); ?>') no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
	<div class="entry-content">
		<span class="categoria"><?php if ( ! empty( $categories ) ) { echo esc_html( $categories[0]->name ); } ?></span>
		<h3 class="entry-title"><a href="<?php echo get_post_permalink($corousellpost); ?>" title="<?php echo get_the_title( $corousellpost->ID ); ?>" class="link"><?php echo get_the_title( $corousellpost->ID ); ?></a></h3>
		<?php $excerpt = ''; if (has_excerpt()) : ?>
		<p class="resum"><?php echo excerpt('20'); ?></p>
			<?php else : ?>
		<p class="resum"><?php //echo content('20'); ?></p>
		<?php endif; ?>
	</div>
</article>
