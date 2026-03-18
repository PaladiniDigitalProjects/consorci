<?php

/**
 *  Block Ticker.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'ticker-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'ticker';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$align_class = $block['align'] ? 'align' . $block['align'] : ''; ?>

<?php if( have_rows('ticker') ): ?>
  <section class="wp-block-<?php echo esc_attr($className); ?> <?php echo $align_class; ?>">
    <ul class="ticker">
    <?php while( have_rows('ticker') ): the_row(); 
        $images = get_sub_field('ticker-image');
        // print_r($images);
        $text = get_sub_field('ticker-text');
        $link = get_sub_field('ticker-link');
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self';
        ?>
        <li class="ticker_item">
          <?php if($link): ?><a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php endif;?>
          <?php if($text): ?><?php echo ($text); ?><?php endif;?>
          <?php if( !empty( $images ) ): ?><img src="<?php echo esc_url($images['url']); ?>" alt="<?php echo esc_attr($images['alt']); ?>" /><?php endif; ?>
          <?php if($link): ?></a><?php endif;?>
        </li>
    <?php endwhile; ?>
    </ul>
    </section>
<?php endif; ?>