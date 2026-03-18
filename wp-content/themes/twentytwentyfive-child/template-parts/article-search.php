<?php
/**
 * @author Daniel Paladini | http://www.paladini.cat
 * @package Veritas 0.1
 */
?>

<?php
$postID = get_the_ID();
$featured_img_url = get_the_post_thumbnail_url($postID, 'medium');
$categories = get_the_category($postID);
$postype = get_post_type($postID);
?>

<?php if ($postype == 'revista'): ?>

<article class="entry entry-tarja item rev<?php if( ! empty($postype)) { echo $postype; } ?> <?php if ( ! empty( $categories ) ) { echo esc_html( $categories[0]->slug ); } ?>">
  <a href="<?php echo get_post_permalink($postID); ?>" title="<?php echo get_the_title(); ?>" class="link"></a>
  <div class="entry-image" style="background:url('<?php echo ($featured_img_url); ?>') no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
  <div class="entry-content">
    <ul class="category">
      <li><?php if ( ! empty( $categories ) ) { echo esc_html( $categories[0]->name ); } ?></li>
    </ul>
    <h3 class="entry-title"><?php echo get_the_title(); ?></h3>
    <p class="resum"><?php echo wp_trim_words( get_the_content(), 10, '...' ); ?></p>
  </div>
</article>

<?php elseif ($postype == 'page'): ?>

  <article class="entry entry-tarja item <?php if( ! empty($postype)) { echo $postype; } ?> <?php if ( ! empty( $categories ) ) { echo esc_html( $categories[0]->slug ); } ?>">
    <a href="<?php echo get_post_permalink($postID); ?>" title="<?php echo get_the_title(); ?>" class="link"></a>
    <div class="entry-image" style="background:url('<?php echo ($featured_img_url); ?>') no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
    <div class="entry-content">
      <ul class="category">
        <li><?php if ( ! empty( $categories ) ) { echo esc_html( $categories[0]->name ); } ?></li>
      </ul>
      <h3 class="entry-title"><?php echo get_the_title(); ?></h3>
      <p class="resum"><?php echo wp_trim_words( get_the_content(), 10, '...' ); ?></p>
    </div>
  </article>

<?php else : ?>

  <article class="entry entry-tarja item <?php if( ! empty($postype)) { echo $postype; } ?> <?php if ( ! empty( $categories ) ) { echo esc_html( $categories[0]->slug ); } ?>">
    <a href="<?php echo get_post_permalink($postID); ?>" title="<?php echo get_the_title(); ?>" class="link"></a>
    <div class="entry-image" style="background:url('<?php echo ($featured_img_url); ?>') no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
    <div class="entry-content">
      <ul class="category">
        <li><?php if ( ! empty( $categories ) ) { echo esc_html( $categories[0]->name ); } ?></li>
      </ul>
      <h3 class="entry-title"><?php echo get_the_title(); ?></h3>
      <p class="resum"><?php echo wp_trim_words( get_the_content(), 10, '...' ); ?></p>
    </div>
  </article>


<?php endif; ?>
