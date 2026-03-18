<?php

/**
 *  Block Contact.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'contact-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'contact';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$align_class = $block['align'] ? 'align' . $block['align'] : '';

$slide = get_field('slide');
$sldierSquinas = get_field('slider_esquinas');

?>
<div class="wp-block-<?php echo esc_attr($className); ?> <?php echo($className);?> <?php echo $align_class; ?>">
	<?php
	$title = get_field('contact_titulo');
	$email = get_field('contact_email');
	$direccio = get_field('contact_block_direccion');	
	?>
 	<div class="contact-email alignwide">
		<div class="flex">
	   		<?php if($title == true): ?><h2 class="block-title"><?php the_field('contact_titulo'); ?></h2><?php endif; ?>
			<?php if($email == true): ?><a href="mailto:<?php the_field('contact_email'); ?>" class="btn block-title"><?php _e('Contactar', 'PDP');?></a><?php endif; ?>
		</div>
		<?php if($direccio == true): ?><div class="item"><?php the_field('contact_block_direccion'); ?></div><?php endif; ?>
	</div>
</div>