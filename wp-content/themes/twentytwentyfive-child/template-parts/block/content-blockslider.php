<?php
/**
 * Block Name: Editorial content slider FP
 * This is the template that displays the image and text block.
 */

 $id = 'editorial-' . $block['id'];
 if( !empty($block['anchor']) ) {
     $id = $block['anchor'];
 }

 // Create class attribute allowing for custom "className" and "align" values.
 $className = 'editorial-block';
 if( !empty($block['className']) ) {
     $className .= ' ' . $block['className'];
 }
 if( !empty($block['align']) ) {
     $className .= ' align' . $block['align'];
 }

?>

<?php if( have_rows('block-slide') ): ?>
  <div id="<?php echo esc_attr($id); ?>" class="section wp-block-cover animate has-slides <?php echo esc_attr($className); ?>">
    <?php while( have_rows('block-slide') ): the_row(); 
        $StitleSlide = get_sub_field('page-block-title-slide');
        $Ssubtitle = get_sub_field('page-block-subtitle-slide');
        $Spost_logo = get_sub_field('page-block-logo-slide');
        $Spost_company_name = get_sub_field('company-name-slide');
        
        $bkg_img_m = get_sub_field('page-block-bkg-mob-image-slide');
        $bkg_img_d = get_sub_field('page-block-bkg-desktop-image-slide');
        $bkg_img_oberlay_m = get_sub_field('page-block-bkg-mobile-image-over-slide');
        $bkg_img_oberlay_d = get_sub_field('page-block-bkg-desktop-image-over-slide');
        $align_class = $block['align'] ? 'align' . $block['align'] : '';

        $postS_calltoaction = get_sub_field('page-block-link-slide');
        $postS_url = $postS_calltoaction['url'];
        $postS_title = $postS_calltoaction['title'];
        $postS_target = $postS_calltoaction['target'] ? $postS_calltoaction['target'] : '_self';
        $arrow = get_sub_field('slider-whiteArrows');
          
      ?>

      <article class="entry slide <?php the_sub_field('company-name-slide');?><?php echo esc_attr($id); ?> <?php if ($arrow): ?> whiteArrow<?php endif; ?>">
        <div class="wp-block-cover__inner-container">
          <div class="entry-content">
            <h2 class="page-title"><?php the_sub_field('page-block-title-slide'); ?></h2>
            <h3 class="entry-title"><?php the_sub_field('company-name-slide');?></h3>
            <div class="subtitle"><?php the_sub_field('page-block-subtitle-slide'); ?></div>
            <?php echo wp_get_attachment_image( $Spost_logo, 'full' ); ?> 
            <a class="btn call-to-action case-study" href="<?php echo esc_url($postS_url); ?>" target="<?php echo esc_attr($postS_target); ?>"><?php echo esc_html($postS_title); ?></a>
          </div>
        </div>
        <!-- end inner block -->
        <style type="text/css">
          .slide.<?php the_sub_field('company-name-slide');?><?php echo esc_attr($id); ?> {
            background-image:url('<?php echo($bkg_img_m);?>');
          }
          .slide.<?php the_sub_field('company-name-slide');?><?php echo esc_attr($id); ?>:after {
            background-image:url('<?php echo($bkg_img_oberlay_m);?>') !important;
          }

        @media (min-width: 768px) {
          .slide.<?php the_sub_field('company-name-slide');?><?php echo esc_attr($id); ?> {
            background-image:url('<?php echo($bkg_img_d);?>');
          }
          .slide.<?php the_sub_field('company-name-slide');?><?php echo esc_attr($id); ?>:after {
            background-image:url('<?php echo($bkg_img_oberlay_d);?>') !important;
          }
        }
      </style>
      </article>

    <?php endwhile; ?>
  </div>
<script>
$(document).ready(function(){  
 $('.fp-controlArrow').click(function() {
    if ($('.fp-slide.active').hasClass('whiteArrow')){
        $('.fp-controlArrow').removeClass('whiteArrow');
    } else {
        $('.fp-controlArrow').addClass('whiteArrow');
      }
  });
});
</script>  
<?php wp_reset_postdata(); ?>
<?php endif; ?>