<?php
/**
 * Block Name: Contenidos Relacionado
 * This is the template that displays the image and text block.
 */

 $id = 'relacionado-' . $block['id'];
 if( !empty($block['anchor']) ) {
     $id = $block['anchor'];
 }

 // Create class attribute allowing for custom "className" and "align" values.
 $className = 'relacionado';
 if( !empty($block['className']) ) {
     $className .= ' ' . $block['className'];
 }
 if( !empty($block['align']) ) {
     $className .= ' align' . $block['align'];
 }

$align_class = $block['align'] ? 'align' . $block['align'] : '';
$related_title = get_field('block_relacionado_title');
$repeatItems = get_field('block_relacionado_repeat');
$ancla = get_field('block_relacionado_title_ancla');
$related_paragraf = get_field('block_relacionado_parrafo_intro');

?>

<section class="wp-block-relacionado <?php echo esc_attr($className); ?>">
<?php if( $related_title ): ?>
  <header class="section-header alignwide">
    <h3 class="section-title"><?php echo($related_title);?></h3>
  </header>
<?php endif; ?>

<?php if( $related_paragraf ): ?>
  <div class="related_paragraf alignwide">
    <?php echo($related_paragraf);?>
  </div>
<?php endif; ?>

<?php if( $repeatItems ): ?>
  <ul class="post-list">
    <?php while( the_repeater_field('block_relacionado_repeat') ): ?>
    <?php $related = get_sub_field('sub_item');?>
    <?php if($related): ?>
      <li>
      <p>Subitem</p>
      <?php $imagenrelacionada = get_sub_field('block_relacionado_image'); ?>
      <?php if($imagenrelacionada): ?>
        <div class="imagen_relacionada" style="background:url('<?php the_sub_field('block_relacionado_image'); ?>') center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
      <?php endif; ?>
      <div class="related-comtent">
        <h4><?php the_sub_field('block_relacionado_item'); ?></h4>
        <?php the_sub_field('block_relacionado_item_descripcion'); ?>
        <?php
          $link = get_sub_field('block_relacionado_item_enlace');
          if( $link ): 
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
          <a class="link new-window" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
        <?php endif; ?>
      </div>
    </li>
    <?php else: ?>
      <li>
      <?php $imagenrelacionada = get_sub_field('block_relacionado_image'); ?>
      <?php if($imagenrelacionada): ?>
        <div class="imagen_relacionada" style="background:url('<?php the_sub_field('block_relacionado_image'); ?>') center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
      <?php endif; ?>
      <div class="related-comtent">
        <h4><?php the_sub_field('block_relacionado_item'); ?></h4>
        <?php the_sub_field('block_relacionado_item_descripcion'); ?>
        <?php
          $link = get_sub_field('block_relacionado_item_enlace');
          if( $link ): 
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
          <a class="link new-window" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
        <?php endif; ?>
      </div>
    </li>

    <?php endif; ?>
    
    <?php endwhile; ?>
 <?php endif;?>

  <?php wp_reset_postdata(); ?>
  </ul>
  <!-- end post list -->
</section>