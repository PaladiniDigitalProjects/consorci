<?php
/**
 * Block Name: Event list
 * This is the template that displays the image and text block.
 */

 $id = 'events-' . $block['id'];
 if( !empty($block['anchor']) ) {
     $id = $block['anchor'];
 }

 // Create class attribute allowing for custom "className" and "align" values.
 $className = 'events-list';
 if( !empty($block['className']) ) {
     $className .= ' ' . $block['className'];
 }
 if( !empty($block['align']) ) {
     $className .= ' align' . $block['align'];
 }

$event_number = get_field('block_event_number');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$event_title = get_field('block_event_title');
$events = tribe_get_events( [ 'posts_per_page' => $event_number ] );
$eventsterms = get_field('event-category');
$enlaceEvento = get_field('block_enlace_event');
global $post;
?>
<div id="eventos"></div>
<section id="<?php echo esc_attr($id); ?>" class="wp-block-events <?php echo esc_attr($className); ?>">
<?php if( $event_title ): ?>
  <header class="section-header">
    <h2 class="section-title"><?php if(get_field('block_enlace_event')): ?><a href="<?php the_field('block_enlace_event')?>"><?php endif ?><?php echo ($event_title);?><?php if(get_field('block_enlace_event')): ?></a><?php endif ?></h2>
  </header>
<?php endif; ?>

<ul class="post-list">
<?php
$today = date("Y-m-d");
$args = array(
  'showposts' => $event_number,
  'post_type' => 'tribe_events',
  'post_status' => 'publish',
  'order' => 'ASC',
  'category__in' => $eventsterms,
  'orderby' =>'meta_value',
   'meta_query' => array(
    array(
    'key' => '_EventEndDate',
    'value' => $today,
    'compare' => '>=',
    )
  )
);


$events_loop = new WP_Query( $args ); 
while ($events_loop->have_posts()) : $events_loop->the_post(); ?>
<?php 
setup_postdata($events_loop);
$featured_img_urlLoop = get_the_post_thumbnail_url($events_loop->ID, 'large');
$linkUrlLoop = get_permalink($events_loop->ID);
$excerpt = get_the_excerpt($events_loop->ID);
$organizer = tribe_get_organizer($events_loop->ID);

?>
  <li>
    <article class="entry">
    <?php if ($featured_img_urlLoop):?>
      <div class="entry-image" style="background: url('<?php echo($featured_img_urlLoop) ;?>') no-repeat center center;"></div>
    <?php else:?>
      <div class="entry-image" style="background: url('<?php echo esc_url( get_template_directory_uri() . "/img/magarana_SJD.png" ); ?>') no-repeat center center;"></div>
    <?php endif;?>
    <div class="entry-day">
          <?php if (tribe_get_start_date($events_loop->ID, true, 'j') !== tribe_get_end_date($events_loop->ID, true, 'j')) { ?>
            <time datetime="<?php echo tribe_get_start_date($events_loop->ID); ?>">
              <?php echo tribe_get_start_date($events_loop->ID, true, 'j'); ?>-<?php echo tribe_get_end_date($events_loop->ID, true, 'j'); ?>
              <span><?php echo tribe_get_start_date($events_loop->ID, true, 'F'); ?></span>
            </time>
          <?php } else { ?>
            <time datetime="<?php echo tribe_get_start_date($events_loop->ID); ?>"><?php echo tribe_get_start_date($events_loop->ID, true, 'j'); ?><span><?php echo tribe_get_start_date($events_loop->ID, true, 'F'); ?></span></time>
          <?php } ?>
    </div>
    <!-- end entry-dat   -->

    <div class="entry-content">
      <h2 class="entry-title"><?php the_title(); ?></h2>
      <?php if ( $organizer ): ?>
        <p><?php _e('Organizer', 'PDP');?>: <?php echo tribe_get_organizer(); ?></p>
      <?php endif; ?>

      <button class="btn-primary">
        <a href="<?php the_permalink($events_loop->ID); ?>" title="<?php the_title_attribute($events_loop->ID); ?>"><?php _e('Leer más', 'PDP');?></a>
      </button>
    </div>    
  </article>
  </li> 
<?php endwhile;  wp_reset_postdata();  ?>
</ul>
<!-- end post list -->
</div>

</section>