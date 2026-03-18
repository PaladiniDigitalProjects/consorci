<?php

/**
 *  Block Noticias.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'noticias-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'noticias';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$align_class = $block['align'] ? 'align' . $block['align'] : '';
$related_title = get_field('block_relacionado_title');
// $related_content = array('post', 'page', 'tribe_events', 'publicaciones');
$related_content = array('post', 'publicaciones');
$related_manueal_content = get_field('block_relacionado_contenido');
$post_numbers = get_field('block_relacionado_numbers');
$relatedCTA = get_field('block_relacionado_CTA');
$term = get_field('block_relacionado_categoria');

?>

<section class="wp-block-<?php echo esc_attr($className); ?> <?php echo $align_class; ?>">
    <?php if ($related_title): ?>
      <header class="section-header alignwide">
        <h3 class="section-title"><?php echo ($related_title); ?>/</h3>
      </header>
      <?php else: ?>
    <?php endif; ?>
    
    <?php if ($related_manueal_content == false): ?>
    <div id="<?php echo esc_attr($id); ?>" class="post-list owl-carousel owl-theme alignwide">
      <?php
      $args = array(  
        'post_type' => $related_content,
        'post_status' => 'publish',
        'posts_per_page' => $post_numbers, 
        // 'orderby' => 'title', 
        'order' => 'ASC',
        'category__in' => $term,
      );
     
      $loop = new WP_Query( $args ); 
      while ($loop->have_posts()) : $loop->the_post(); ?>
      <?php 
      setup_postdata($loop);
      $categoriesLoop = get_the_terms( $loop->ID, 'category' );
      // $excerptLoop = get_the_excerpt($loop->ID);
      $featured_img_urlLoop = get_the_post_thumbnail_url($loop->ID, 'large');
      $linkUrlLoop = get_permalink($loop->ID);
      $lolo = get_field('publicacion-documento', get_the_ID());
      ?>
        <article class="entry entry-tarja item">
        <?php if ('publicaciones' != get_post_type($loop->ID)) : ?>
          <a href="<?php echo($linkUrlLoop);?>" title="<?php the_title(); ?>" class="entry-link"></a>
        <?php endif; ?>
        <?php if ($featured_img_urlLoop): ?><div class="entry-image" style="background: url('<?php echo($featured_img_urlLoop) ;?>') no-repeat center center;"></div><?php endif;?>
        <div class="entry-content">   
            <?php if ( ! empty( $categoriesLoop ) ) : ?>
              <ul class="category-list">
              <?php if ('tribe_events' == get_post_type()) : ?>
                <li class="entry-categories"><i class="ico-evento"></i><?php _e('Evento', 'PDP');?></li>
              <?php endif; ?>
              <?php foreach ( $categoriesLoop as $cat ) { echo '<li class="entry-categories">#'.$cat->name.'</li> '; } ?>
              </ul>
            <?php endif; ?>
            <?php the_date(); ?>
            <h3 class="entry-title"><?php the_title(); ?></h3>
            <?php if ('publicaciones' == get_post_type($loop->ID)) : ?>
              <button class="btn btn-descargar" onclick="location.href='<?php echo ($lolo); ?>'" type="button"><?php _e('Descargar PDF', 'PDP') ;?></button>
			      <?php endif; ?>
          </div>    
        </article>  
      <?php endwhile;  wp_reset_postdata();  ?>
  <!-- end post list -->
  </div>
<?php else: ?>

<div id="<?php echo esc_attr($id); ?>" class="post-list owl-carousel owl-theme alignwide">
  <?php foreach( $related_manueal_content as $r_post): ?>
    <?php 
      setup_postdata($r_post);
      $categories = get_the_terms( $r_post, 'category' );
      $excerpt = get_the_excerpt($r_post);
      $featured_img_url = get_the_post_thumbnail_url($r_post->ID, 'large');
      $linkUrl = get_permalink($r_post->ID);
      $dowloadpdf = get_field('publicacion-documento', $r_post->ID );
      $linkpdf = get_field('publicacion-digital', $r_post->ID );
    ?>
      <article class="entry entry-tarja item">
      <?php if ('publicaciones' != get_post_type($r_post->ID)) : ?>
        <a href="<?php echo $linkUrl;?>" title="<?php echo $linkUrl;?>" class="entry-link"></a>
      <?php endif; ?>
        <?php if ($featured_img_url): ?><div class="entry-image" style="background: url('<?php echo($featured_img_url) ;?>') no-repeat center center;"></div><?php endif;?>
        <div class="entry-content">
          <ul class="category-list">
            <?php if ( ! empty( $categoriesLoop ) ) : ?>
              <?php if ('tribe_events' == get_post_type()) : ?>
              <li class="entry-categories"><i class="ico-evento"></i><?php _e('Evento', 'PDP');?></li>
              <?php endif; ?>
                <?php foreach ( $categoriesLoop as $cat ) { echo '<li class="entry-categories">#'.$cat->name.'</li> '; } ?>
            <?php endif; ?>
            </ul>
            <h3 class="entry-title"><?php echo get_the_title( $r_post->ID ); ?></h3>
            <?php if ('publicaciones' === get_post_type($r_post->ID)) : ?>
              <?php if ($linkpdf): ?><button class="btn btn-descargar" onclick="location.href='<?php echo ($linkpdf); ?>'" type="button"><?php _e('Ver publicación', 'PDP') ;?></button><?php endif ?>
              <?php if ($dowloadpdf): ?><button class="btn btn-descargar" onclick="location.href='<?php echo ($dowloadpdf); ?>'" type="button"><?php _e('Descargar PDF', 'PDP') ;?></button><?php endif ?>
			      <?php endif; ?>

        </div>
      </article>
    <?php endforeach; ?>
  <?php wp_reset_postdata(); ?>
</div>
<!-- end post list -->

<?php endif; ?>

<?php if ($relatedCTA): ?>
<footer class="section-footer">
<?php 
    $link = get_field('block_relacionado_CTA');
    if( $link ): 
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self';
    ?>
    <div class="wp-block-buttons">
        <div class="wp-block-button btn-pequeno"><a class="wp-block-button__link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
    </div>
    <?php endif; ?>
</footer>
<?php endif; ?>

</section>

<script type="text/javascript">
jQuery(document).ready(function ($) {

      var owl = $("#<?php echo esc_attr($id); ?>");
      owl.owlCarousel({
        center:false,
        // autoplay:true,
        autoplay:false,
        autoplayTimeout:4000,
        margin:16,
        nav:true,
        navText: ['<span class="photo-icons icon-prev"></span>','<span class="photo-icons icon-next"></span>'],
        // loop:true,
        stagePadding:10,
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
        }
      });

    });
</script>

