

<?php
/**
 * Block Name: Descargas
 */

 $id = 'descargas-' . $block['id'];
 if( !empty($block['anchor']) ) {
     $id = $block['anchor'];
 }

 // Create class attribute allowing for custom "className" and "align" values.
 $className = 'descargas';
 if( !empty($block['className']) ) {
     $className .= ' ' . $block['className'];
 }
 if( !empty($block['align']) ) {
     $className .= ' align' . $block['align'];
 }

$align_class = $block['align'] ? 'align' . $block['align'] : '';
$descargas_title = get_field('titulo_descargas');
$descarga_archivo = get_field('archivo_descargas');
$descargas_relacionado = get_field('archivos_descargas_relacionados');
?>

<section id="<?php echo esc_attr($id); ?>" class="wp-block-descargas <?php echo esc_attr($className); ?>">
<?php if( $descargas_title ): ?>
  <header class="section-header">
    <h3 class="section-title"><?php echo ($descargas_title);?></h3>
    <div class="wp-block-buttons is-content-justification-center">
      <div class="wp-block-button"><a href="<?php echo($descarga_archivo); ?>" class="wp-block-button__link has-blanco-color has-primary-background-color has-text-color has-background"><?php _e('Descarga PDF','PDP');?></a></div>
    </div>
  </header>
<?php endif; ?>
  <?php if( $descargas_relacionado ): ?>
  <ul class="post-list">
  <?php foreach( $descargas_relacionado as $d_post): ?>
    <?php
      setup_postdata($d_post);
      $PDFarchive = get_field('publicacion-documento', $d_post);
    ?>
    <li class="entry">
      <a href="<?php echo ( $PDFarchive ); ?>"><?php echo get_the_title( $d_post->ID ); ?></a>
    </li>  
    <?php endforeach; ?>
  <?php wp_reset_postdata(); ?>
  </ul>
  <!-- end post list -->
<?php endif; ?>
</section>