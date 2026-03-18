<?php

/**
 *  Projects Slider.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'projects-slider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'projects-slider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$align_class = $block['align'] ? 'align' . $block['align'] : '';

$slide = get_field('slider-projects');
// $sldierSquinas = get_field('slider_esquinas');

if (have_rows('slider-projects')): ?>
<section class="wp-block-<?php echo esc_attr($className); ?> <?php echo $align_class; ?> home-teather">
  <div id="<?php echo esc_attr($id); ?>" class="home-slider cycle-slideshow owl-carousel owl-theme">
  <?php while (have_rows('slider-projects')) : the_row(); ?>
    <?php $slider_color = get_sub_field('slider-bw'); ?>
    <?php $iframe = get_sub_field('slider-video'); ?>
    <?php $slider_project_image = get_sub_field( 'slider-project-image' ); ?>
    <?php $slider_project_mobile = get_sub_field( 'slider-project-mobile' ); ?>
    <?php $slider_project_link = get_sub_field( 'slider-project-link' ); ?>
    <?php $slider_title = get_sub_field( 'slider-project-title' ); ?>
    <?php $slider_description = get_sub_field( 'slider-project-description' ); ?>
    <?php $layout_slider_galeria_images = get_field( 'slider-projects' ); ?>

    <article class="img-slider item <?php if( $slider_color ): ?><?php echo $slider_color; ?><?php endif; ?>">
      <?php if ($iframe): ?>
      <?php preg_match('/src="(.+?)"/', $iframe, $matches);
      $src = $matches[1];
      $params = array(
        'controls'  => 0,
        'hd'        => 0,
        'autohide'  => 0,
        'red'       => 0,
        'info'      => 0,
        'autoplay'  => 1,
        'muted'			=> 1,
        'loop'			=> 1,
        'background'=> 1,
        );
      $new_src = add_query_arg($params, $src);
      $iframe = str_replace($src, $new_src, $iframe);
      $attributes = 'frameborder="0"';
      $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
      ?>

      <div class="video"><div class="embed-container"><?php echo $iframe; ?></div></div>

      <?php else : ?>
      <?php if ($slider_project_mobile): ?>
        <div class="img-slider mobile" style="background-image: url('<?php echo $slider_project_mobile['url']; ?>');"></div>
      <?php endif; ?>
      <?php if ($slider_project_image): ?>
        <div class="img-slider desktop" style="background-image: url('<?php echo $slider_project_image['url']; ?>');"></div>
      <?php endif; ?>
      <?php if ($slider_title): ?>
        <h2 class="entry-title"><a class="slider-link" href="<?php echo ($slider_project_link);?>"><?php echo $slider_title; ?></a></h2>
      <?php endif; ?>
      <div class="slide-num"><span class="num">1</span>/<?php echo count( $layout_slider_galeria_images );?></div>
      <?php endif; ?>
      <!-- end article entry -->
    </article>
  <?php endwhile; ?>
</div>
<!-- end home slider carroussel -->
<?php else : ?>
  <?php // no rows found ?>
<?php endif; ?>
  <a class="owl-down" href="#home-page-content"><span class="photo-icons icon-down"></span></a>  
</section>


<?php $count = count($slide);?>
<?php if ($count > 1): ?>

<script type="text/javascript">
$(window).load(function() {
var owl = $(".owl-carousel");
owl.owlCarousel({
    center:true,
    loop:true,
    items:1,
    autoplay:false,
    // autoplay:true,
    autoplayTimeout:2000,
    autoplayHoverPause:true,
    nav:true,
    navText: ['<span class="photo-icons icon-prev"></span>','<span class="photo-icons icon-next"></span>'],
  });

  owl.on('changed.owl.carousel',function(event){
      var currentIndex = event.page.index;
      $('.num').html(currentIndex +1);
  });

  $('.owl-carousel').on('translated.owl.carousel', function(e){
    if ($('.owl-item.active > article').hasClass('black')){
        $('body').removeClass('black');
        $('body').addClass('black');
      } else {
        $('body').removeClass('black');
      }
  });

  $('.home-slider').ready(function() {
    if ($('.owl-item.active > article').hasClass('black')){
        $('body').removeClass('black');
        $('body').removeClass('white');
        $('body').addClass('black');
      } else {
        $('body').removeClass('black');
        $('body').removeClass('white');
        $('body').addClass('white');
      }
  });

});

$(document).keydown( function(eventObject) {
if(eventObject.which==37) {//left arrow
$('.owl-prev').click();//emulates click on prev button
} else if(eventObject.which==39) {//right arrow
$('.owl-next').click();//emulates click on next button
}
});

</script>

<?php endif; ?>