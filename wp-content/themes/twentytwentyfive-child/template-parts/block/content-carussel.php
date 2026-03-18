<?php

/**
 *  Block Carousell.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'corousell-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'corousell';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$align_class = $block['align'] ? 'align' . $block['align'] : '';
$corousell_title = get_field('block_corousell_content_title');
$featured_posts = get_field('block_corousell_content');
?>

<?php if ($featured_posts): ?>
<section class="wp-block-<?php echo esc_attr($className); ?> <?php echo $align_class; ?>">
  <?php if ($corousell_title): ?>
    <header class="section-header">
      <h2 class="section-title"><?php echo ($corousell_title); ?></h2>
    </header>
  <?php endif; ?>
  <?php if( $featured_posts ): ?>
    <div id="<?php echo esc_attr($id); ?>" class="post-list owl-carousel owl-theme">
    <?php foreach( $featured_posts as $corousellpost): ?>
      <?php setup_postdata($corousellpost); ?>
      <?php $thumbURLC = wp_get_attachment_url( get_post_thumbnail_id($corousellpost->ID, 'medium') ); ?>
      <?php $categories = get_the_category($corousellpost); ?>
      <?php $post_types = get_post_type( $corousellpost->ID ); ?>

        <article class="entry entry-tarja item <?php if( ! empty($post_types)) { echo $post_types; } ?> <?php if ( ! empty( $categories ) ) { echo esc_html( $categories[0]->slug ); } ?>">
          <a href="<?php echo get_post_permalink($corousellpost); ?>" title="<?php echo get_the_title( $corousellpost->ID ); ?>" class="link"></a>
          <div class="entry-image">
            <img class="img-responsive box-shadow" src="<?php echo ($thumbURLC); ?>" />
          </div>
          <div class="entry-content">
             <h3 class="entry-title"><?php echo get_the_title( $corousellpost->ID ); ?></h3>
          </div>
        </article>

      <?php endforeach; ?>
    <?php wp_reset_postdata(); ?>
    </div>
  <!-- end post list -->
</section>

<?php endif; ?>

    <script type="text/javascript">

jQuery(document).ready(function ($) {

      var owl = $("#<?php echo esc_attr($id); ?>");
      owl.owlCarousel({
        center:false,
        autoplay:true,
        autoplayTimeout:4000,
        margin:30,
        nav:true,
        navText: ['<span class="photo-icons icon-prev"></span>','<span class="photo-icons icon-next"></span>'],
        loop:true,
        stagePadding:0,
        responsiveClass:true,
        responsive:{
            0:{
                items:2,
                nav:true,
            },
            450:{
                items:2,
                nav:true,
            },
            786:{
                items:3,
                nav:true,
            },
            1024:{
                items:4,
                nav:true,
            },
            1400:{
                items:6,
                nav:true,
            },
        }
      });

    });
</script>
<?php endif; ?>
