

<?php
/**
 * Block Name: REdes Sociales
 */

 $id = 'redes-sociales-' . $block['id'];
 if( !empty($block['anchor']) ) {
     $id = $block['anchor'];
 }

 // Create class attribute allowing for custom "className" and "align" values.
 $className = 'redes-sociales';
 if( !empty($block['className']) ) {
     $className .= ' ' . $block['className'];
 }
 if( !empty($block['align']) ) {
     $className .= ' align' . $block['align'];
 }

$align_class = $block['align'] ? 'align' . $block['align'] : '';
$redes_title = get_field('titulo-redes-sociales');
?>

<section id="<?php echo esc_attr($id); ?>" class="wp-block-redes-sociales <?php echo esc_attr($className); ?>">
<?php if( $redes_title ): ?>
  <header class="section-header">
    <h4 class="section-title"><?php echo ($redes_title);?></h4>
  </header>
<?php endif; ?>

<?php if( have_rows('block-redes-sociales') ): ?>
  <ul class="list">
  <?php while( have_rows('block-redes-sociales') ) : the_row(); ?>
      <?php 
        $rs_imagen = get_sub_field('image-rs');
        $rs_link = get_sub_field('enlace-rs');
        $rs_name = get_sub_field('nombres-rs');
      ?>
      <li><a href="<?php echo the_sub_field('enlace-rs'); ?>" target="_blank" title="<?php echo the_sub_field('nombres-rs'); ?>"><?php echo wp_get_attachment_image( $rs_imagen['ID'], 'full' ); ?></a></li>
  <?php endwhile; ?>
  </ul>
<?php else : ?>
    // Do something...
<?php endif; ?>

</section>