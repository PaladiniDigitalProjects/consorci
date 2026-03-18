<?php

/**
 *  Block Slider.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'slider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'slider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$align_class = $block['align'] ? 'align' . $block['align'] : '';

$slide = get_field('slide');
$sldierSquinas = get_field('slider_esquinas');

if (have_rows('slide')): ?>
<section class="wp-block-<?php echo esc_attr($className); ?> <?php echo $align_class; ?> <?php if($sldierSquinas == true) {echo('rounded');} ?>">
  <div id="<?php echo esc_attr($id); ?>" class="owl-carousel owl-theme">
    <?php while (have_rows('slide')) : the_row(); ?>
      <?php
        $link = get_sub_field('slide_boto');
        if( $link ) {
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self'; 
        } 
        $linkCase = get_sub_field('slide_case_testimonial');
        if( $linkCase ) {
          $linkCase_url = $linkCase['url'];
          $linkCase_title = $linkCase['title'];
          $linkCase_target = $linkCase['target'] ? $linkCase['target'] : '_self';
        } ?>
      <div class="item" <?php if(get_sub_field('slide_background')): ?>style="background-color:<?php the_sub_field('slide_background'); ?>;" <?php endif; ?>>
      <?php if(get_sub_field('slide_imatge_escriptori')): ?>
          <div class="slide background-slide">
          <div class="slide-claim alignwide">
            <?php if(get_sub_field('slide_titular')): ?><h2 class="slide-title"<?php if(get_sub_field('slide_color_titol')): ?> style="color:<?php the_sub_field('slide_color_titol'); ?>;" <?php endif; ?>><?php the_sub_field('slide_titular'); ?></h2><?php endif;?>
            <?php if(get_sub_field('slide_subtitol')): ?><h4 class="slide-subtitle" <?php if(get_sub_field('slide_color_subtitol')): ?> style="color:<?php the_sub_field('slide_color_subtitol'); ?>;" <?php endif; ?>><?php the_sub_field('slide_subtitol'); ?></h4><?php endif;?>
            <?php if(get_sub_field('slide_subtitol_parraf')): ?><div class="slide-parraf" <?php if(get_sub_field('slide_subtitol_parraf')): ?> style="color:<?php echo the_sub_field('slide_color_parraf'); ?>;" <?php endif; ?>><?php the_sub_field('slide_subtitol_parraf'); ?></div><?php endif;?>
            
            <?php if(get_sub_field('slide_picture_testimonial') && get_sub_field('slide_text_testimonial') ): ?>
              <div class="slide-testimonial"> 
                <img src="<?php the_sub_field('slide_picture_testimonial'); ?>" class="img-responsive img-circular" />
                <div class="slide-testimonial-text"><?php the_sub_field('slide_text_testimonial'); ?></div>
              </div>
            <?php endif;?>

            <div class="slide-footer alignwide">
              <div><a class="link btn btn-coral case-study" style="<?php if(get_sub_field('slide_color_boto')): ?>background-color:<?php the_sub_field('slide_color_boto'); ?>;<?php endif;?>" target="<?php echo esc_attr( $link_target ); ?>" href="<?php echo( $linkCase_url ); ?>" target="<?php echo ( $linkCase_target ); ?>"><?php echo ( $linkCase_title ); ?></a></div>
              <div><a class="link button btn btn-coral" style="<?php if(get_sub_field('slide_color_text_boto')): ?>color:<?php echo the_sub_field('slide_color_text_boto'); ?>;<?php endif; ?><?php if(get_sub_field('slide_color_boto')): ?>background-color:<?php the_sub_field('slide_color_boto'); ?>;<?php endif;?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
            </div>
          </div>
          <!-- end slide claim -->
        </div>
        <!-- end sldie -->
        <style>
          .background-slide {
            background:url('<?php the_sub_field('slide_imatge_mobil'); ?>') no-repeat center center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
          }
          @media (min-width: 700px) {
            .background-slide {
             background:url('<?php the_sub_field('slide_imatge_escriptori'); ?>') no-repeat center center;
            }
          }
        </style>
        <?php else: ?>

        <div class="slide" <?php if(get_sub_field('slide_background')): ?>style="background-color:<?php the_sub_field('slide_background'); ?>;" <?php endif; ?>>
          <div class="slide-claim alignwide">
            <?php if(get_sub_field('slide_titular')): ?><h2 class="slide-title"<?php if(get_sub_field('slide_color_titol')): ?> style="color:<?php the_sub_field('slide_color_titol'); ?>;" <?php endif; ?>><?php the_sub_field('slide_titular'); ?></h2><?php endif;?>
            <?php if(get_sub_field('slide_subtitol')): ?><h4 class="slide-subtitle" <?php if(get_sub_field('slide_color_subtitol')): ?> style="color:<?php the_sub_field('slide_color_subtitol'); ?>;" <?php endif; ?>><?php the_sub_field('slide_subtitol'); ?></h4><?php endif;?>
            <?php if(get_sub_field('slide_subtitol_parraf')): ?><div class="slide-parraf" <?php if(get_sub_field('slide_subtitol_parraf')): ?> style="color:<?php echo the_sub_field('slide_color_parraf'); ?>;" <?php endif; ?>><?php the_sub_field('slide_subtitol_parraf'); ?></div><?php endif;?>
            
            <?php if(get_sub_field('slide_picture_testimonial') && get_sub_field('slide_text_testimonial') ): ?>
              <div class="slide-testimonial"> 
                <img src="<?php the_sub_field('slide_picture_testimonial'); ?>" class="img-responsive img-circular" />
                <div class="slide-testimonial-text"><?php the_sub_field('slide_text_testimonial'); ?></div>
              </div>
            <?php endif;?>

            <div class="slide-footer alignwide">
              <div><a class="link btn btn-coral case-study" style="<?php if(get_sub_field('slide_color_boto')): ?>background-color:<?php the_sub_field('slide_color_boto'); ?>;<?php endif;?>" target="<?php echo esc_attr( $link_target ); ?>" href="<?php echo( $linkCase_url ); ?>" target="<?php echo ( $linkCase_target ); ?>"><?php echo ( $linkCase_title ); ?></a></div>
              <div><a class="link button btn btn-coral" style="<?php if(get_sub_field('slide_color_text_boto')): ?>color:<?php echo the_sub_field('slide_color_text_boto'); ?>;<?php endif; ?><?php if(get_sub_field('slide_color_boto')): ?>background-color:<?php the_sub_field('slide_color_boto'); ?>;<?php endif;?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
            </div>
          </div>
          <!-- end slide claim -->
        </div>
        <!-- end sldie -->
        <?php endif; ?>
  		</div>
  	<?php endwhile; ?>
  </div>
</section>
<?php else : ?>
  <?php // no rows found ?>
<?php endif; ?>


<?php $count = count($slide);?>
<?php if ($count > 1): ?>

<script type="text/javascript">
$(document).ready(function(){
    var owl = $("#<?php echo esc_attr($id); ?>");
    owl.owlCarousel({
      center:false,
      autoplay:false,
      autoplayTimeout: 4000,
      autoHeight: false,
      margin:0,
      items:1,
      nav:true,
      loop:true,
      navText: ['<span class="photo-icons icon-prev"></span>','<span class="photo-icons icon-next"></span>'],
    });
  });
  </script>
<?php endif; ?>