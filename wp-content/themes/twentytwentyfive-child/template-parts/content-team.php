<?php $i = 1;?>
<article id="post-<?php the_ID(); ?>" class="entry animate" data-animate="fadeIn" data-duration="1s" data-delay="<?php echo $i++;?>s"  data-offset="100" data-iteration="1">
	<?php 
	$TeamPosition = get_field('team-position');
	$TeamLinkedin = get_field('team-linkedin');
	$TeamThumb = get_field('team-secondary-thumb');
	?>

	<header class="entry-header">
		<div class="entry-data">
			<h2 class="entry-title"><?php the_title();?></h2>	
			<?php if ($TeamPosition) : ?><p><?php echo($TeamPosition); ?></p><?php endif; ?>	
		</div>
		<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content" <?php if ($TeamThumb) : ?>style="background-image: url('<?php echo($TeamThumb); ?>');"<?php endif; ?>>
		<div class="content">
			<?php the_content(); ?>
		</div>
		<div class="entry-data">
			<h2 class="entry-title"><?php the_title();?></h2>	
			<?php if ($TeamPosition) : ?><p><?php echo($TeamPosition); ?></p><?php endif; ?>	
		</div>
		<?php if ($TeamLinkedin) : ?>
			<form class="social-link" action="<?php echo($TeamLinkedin); ?>" method="get" target="_blank">
				<button type="submit"><i class="ico ico-linkdin-coral"></i></button>
			</form>
		<?php endif; ?> 
	</div><!-- .entry-content -->
</article><!-- #post-## -->
