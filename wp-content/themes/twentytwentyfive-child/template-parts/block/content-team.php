<?php
/**
 * Block Name: TEam maped content
 * This is the template that displays the image and text block.
 */

 $id = 'team-' . $block['id'];
 if( !empty($block['anchor']) ) {
     $id = $block['anchor'];
 }

 // Create class attribute allowing for custom "className" and "align" values.
 $className = 'team-block';
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
$bm_posts = get_field('bm-block-related-content');
$bm_maped_image = get_field('bm-block-maped-image');
$bm_map_image_code = get_field('bm-block-map-code');


$align_class = $block['align'] ? 'align' . $block['align'] : ''; ?>

<div id="<?php echo esc_attr($id); ?>" class="section wp-block-cover animate editorial-block editorial-block-team <?php if( $bm_posts ): ?>has-slides<?php endif; ?><?php echo esc_attr($className); ?>">
  <div class="wp-block-cover__inner-container">
    <?php if ($bm_title): ?>
      <h2 class="page-title"><?php echo ($bm_title); ?></h2>
    <?php endif; ?>
    <?php if ($bm_subtitle): ?>
      <div class="subtitle">
        <?php echo ($bm_subtitle); ?>
      </div>
      <?php endif; ?>
      <?php if(!empty($bm_link)):?>
        <a class="btn call-to-action" href="<?php echo esc_url($bm_link_url); ?>"><?php echo esc_html ($bm_link_title); ?></a>
      <?php endif; ?>
  </div>
  <!-- end block cover -->
<?php if( $bm_posts ): ?>
<div class="post-list">
  <?php $i = 1; ?>
  <?php foreach( $bm_posts as $bm_post) : ?>
    <?php setup_postdata($bm_post); ?>
    <?php $bm_thumbURL = get_field( 'team-secondary-thumb', $bm_post->ID ); ?>
    <?php $bm_position = get_field( 'team-position', $bm_post->ID ); ?>
      <div class="entry team-featured" id="team-person-<?php echo $i++ ?>" style="background:url('<?php echo ($bm_thumbURL); ?>') no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;filter: multiply(100%);">
        <h3 class="entry-title"><?php echo get_the_title( $bm_post->ID ); ?></h3>
        <strong><?php echo($bm_position);?></strong>
      </div>
    <?php endforeach; ?>
  <?php wp_reset_postdata(); ?>
</div>
<!-- end post list -->
<?php endif; ?>
  <?php if ($bm_maped_image): ?>
  <div class="image-map-team">
    <img class="img-responsive" src="<?php echo ($bm_maped_image); ?>" usemap="#image-map">
    <?php if ($bm_maped_image): ?>
      <?php echo($bm_map_image_code); ?>
    <?php endif; ?>
  </div>
<?php endif; ?>
<style type="text/css">
    <?php if ($bm_bkg_img_m): ?>
    #<?php echo esc_attr($id); ?> {
      background-image:url('<?php echo($bm_bkg_img_m);?>');
    }
  <?php if ($bm_bkg_img_oberlay_m): ?>
    #<?php echo esc_attr($id); ?>:after {
      background:url('<?php echo($bm_bkg_img_oberlay_m);?>') no-repeat bottom right;
    }
  <?php endif; ?>
  <?php endif; ?>
  <?php if ($bm_bkg_img_d): ?>
    @media (min-width: 768px) {
      #<?php echo esc_attr($id); ?> {
        background-image:url('<?php echo($bm_bkg_img_d);?>');
      }
  <?php if ($bm_bkg_img_oberlay_d): ?>
    .post-list {
      background:url('<?php echo($bm_bkg_img_oberlay_d);?>') no-repeat top right;
    }
    <?php endif; ?>
  }
  <?php endif; ?>
</style>
</div>
<!-- end editorial block team -->