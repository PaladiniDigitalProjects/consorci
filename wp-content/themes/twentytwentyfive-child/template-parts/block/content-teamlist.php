<?php
/**
 * Block Name: TEam maped content
 * This is the template that displays the image and text block.
 */

 $id = 'teamlist-' . $block['id'];
 if( !empty($block['anchor']) ) {
     $id = $block['anchor'];
 }

 // Create class attribute allowing for custom "className" and "align" values.
 $className = 'teamlist';
 if( !empty($block['className']) ) {
     $className .= ' ' . $block['className'];
 }
 if( !empty($block['align']) ) {
     $className .= ' align' . $block['align'];
 }

$bm_title = get_field('bm-block-title');
$bm_subtitle = get_field('bm-block-subtitle');
$bm_link = get_field('bm-block-link'); ?>

<?php if(!empty($bm_link)):?>
<?php
$bm_link_url = $bm_link['url'];
$bm_link_title = $bm_link['title'];
$bm_link_target = $bm_link['target'] ? $bm_link['target'] : '_self';
?>
<?php endif; ?>
<?php
$bm_bkg_img_m = get_field('bm-block-bkg-mob-image');
$bm_bkg_img_d = get_field('bm-block-bkg-desktop-image');
$bm_bkg_img_oberlay_m = get_field('bm-block-bkg-mobile-image-over');
$bm_bkg_img_oberlay_d = get_field('bm-block-bkg-desktop-image-over');
$bm_posts = get_field('block_related_content_team');
$align_class = $block['align'] ? 'align' . $block['align'] : ''; ?>
<?php if($bm_posts):?>
<div class="grid">
  <?php foreach( $bm_posts as $bm_post): ?>
    <?php setup_postdata($bm_post); ?>
    <article id="post-<?php the_ID($bm_post->ID); ?>" class="entry">
    <?php
    $TeamName = get_the_title($bm_post->ID );
    $TeamPosition = get_field('team-position', $bm_post->ID );
    $TeamLinkedin = get_field('team-linkedin', $bm_post->ID );
    $TeamThumb = get_field('team-secondary-thumb', $bm_post->ID );
    $TeamFirstThumb = get_the_post_thumbnail( $bm_post->ID, 'full' );
    ?>
  <?php if ($TeamLinkedin) : ?>
        <div class="social-link" action="" method="get" >
          <a href="<?php echo($TeamLinkedin); ?>" target="_blank" class="ico ico-linkdin-coral"></a>
      </div>
      <?php endif; ?> 
  <header class="entry-header">
		<div class="entry-data">
			<?php if ($TeamName) : ?><h2 class="entry-title"><?php echo($TeamName);?></h2><?php endif; ?>
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
        <?php if ($TeamName) : ?>
          <h2 class="entry-title"><?php echo ($TeamName);?></h2>
        <?php endif; ?>
        <?php if ($TeamPosition) : ?><p><?php echo($TeamPosition); ?></p><?php endif; ?>	
      </div>
      </div><!-- .entry-content -->
      <?php if ($TeamFirstThumb) : ?>
        <div class="post-thumbnail">
          <?php echo ($TeamFirstThumb); ?>
        </div><!-- .post-thumbnail -->
      <?php endif; ?> 
    </article><!-- #post-## -->
    <?php endforeach; ?>
  <?php wp_reset_postdata(); ?>
</div>
<!-- end grid -->
<?php endif; ?>