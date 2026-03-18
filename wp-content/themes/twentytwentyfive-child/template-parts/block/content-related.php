

<?php
/**
 * Block Name: Related content
 * This is the template that displays the image and text block.
 */

 $id = 'related-' . $block['id'];
 if( !empty($block['anchor']) ) {
     $id = $block['anchor'];
 }

 // Create class attribute allowing for custom "className" and "align" values.
 $className = 'related-content';
 if( !empty($block['className']) ) {
     $className .= ' ' . $block['className'];
 }
 if( !empty($block['align']) ) {
     $className .= ' align' . $block['align'];
 }

$related_posts = get_field('block_related_content');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$related_title = get_field('block_related_content_title');
$related_CTA = get_field('block_related_content_calltoactionlink');
$related_CTA_txt = get_field('block_related_content_calltoactiontext');
?>

<section id="<?php echo esc_attr($id); ?>" class="wp-block-related <?php echo esc_attr($className); ?>">
<?php if( $related_title ): ?>
  <header class="section-header">
    <h3 class="section-title"><?php echo ($related_title);?></h3>
  </header>
<?php endif; ?>
  <?php if( $related_posts ): ?>
  <ul class="post-list">
  <?php foreach( $related_posts as $r_post): ?>
    <?php 
      setup_postdata($r_post);
      $categories = get_the_terms( $r_post, 'category' );
      $categoriesProjects = get_the_terms( $r_post , 'estage');
      $excerpt = get_the_excerpt($r_post);
      $featured_img_url = get_the_post_thumbnail_url($r_post->ID, 'large'); 
    ?>
    <li>
      <article class="entry<?php if (! empty( $categories ) ) { echo ' '.($categories[0]->slug );} ?>" <?php if (!empty( $featured_img_url )): ?>style="background:url('<?php echo($featured_img_url) ;?>') top left no-repeat;"<?php endif;?>>
        <a class="entry-link" href="#"></a>
        <?php if (!empty( $categoriesProjects ) ) { echo '<span class="project-categories '.($categoriesProjects[0]->slug ).'">'.($categoriesProjects[0]->name ).'</span>';} ?>
        <div class="entry-content">
          <?php if (!empty( $categories ) ) { echo '<span class="entry-categories">'.($categories[0]->name ).'</span>';} ?>
          <h3 class="entry-title"><?php echo get_the_title( $r_post->ID ); ?></h3>
          <div class="entry-metadata"><span class="entry-data"><?php echo get_the_date('d.m.y'); ?></span><span class="entry-author"> - <?php //echo get_the_author_meta('display_name', $author_id);?></span></div>
          <?php if (!empty( $excerpt ) ) { echo '<p class="entry-excerpt">'.$excerpt.'</p>';} ?>
          <span class="more"><?php _e('Read Now', 'PDP');?></span>
        </div>
      </article>
    </li>
    <?php endforeach; ?>
  <?php wp_reset_postdata(); ?>
  </ul>
  <!-- end post list -->
<?php endif; ?>
<?php if( $related_CTA ): ?>
  <footer class="section-footer">
    <a href="<?php echo ($related_CTA); ?>" class="btn btn-more"><?php echo($related_CTA_txt);?></a>
  </footer>
<?php endif; ?>
</section>