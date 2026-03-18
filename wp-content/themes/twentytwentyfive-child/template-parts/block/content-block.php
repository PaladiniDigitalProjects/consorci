<?php
/**
 * Block Name: Editorial content
 * This is the template that displays the image and text block.
 */

 $id = 'editorial-' . $block['id'];
 if( !empty($block['anchor']) ) {
     $id = $block['anchor'];
 }

 // Create class attribute allowing for custom "className" and "align" values.
 $className = 'editorial-block';
 if( !empty($block['className']) ) {
     $className .= ' ' . $block['className'];
 }
 if( !empty($block['align']) ) {
     $className .= ' align' . $block['align'];
 }

$title = get_field('page-block-title');
$subtitle = get_field('page-block-subtitle');
$link = get_field('page-block-link'); ?>
<?php if(!empty($link)):?>
<?php
$link_url = $link['url'];
$link_title = $link['title'];
$link_target = $link['target'] ? $link['target'] : '_self';
?>
<?php endif; ?>
<?php
$bkg_img_m = get_field('page-block-bkg-mob-image');
$bkg_img_d = get_field('page-block-bkg-desktop-image');
$bkg_img_oberlay_m = get_field('page-block-bkg-mobile-image-over');
$bkg_img_oberlay_d = get_field('page-block-bkg-desktop-image-over');
$posts = get_field('page-block-related-content');
$align_class = $block['align'] ? 'align' . $block['align'] : ''; ?>

<div id="<?php echo esc_attr($id); ?>" class="section wp-block-cover animate <?php if( $posts ): ?>has-slides<?php endif; ?> <?php echo esc_attr($className); ?>">
  <div class="wp-block-cover__inner-container">
  <?php if( $posts ): ?>
  <?php else: ?>
    <?php if ($title): ?>
      <h2 class="page-title"><?php echo ($title); ?></h2>
    <?php endif; ?>
  <?php endif; ?>
    <?php if ($subtitle): ?>
    <div class="subtitle">
        <?php echo ($subtitle); ?>
    </div>
    <?php endif; ?>
    <?php if(!empty($link)):?>
        <a class="btn call-to-action" href="<?php echo esc_url($link_url); ?>"><?php echo esc_html ($link_title); ?></a>
    <?php endif; ?>
  </div>

<?php if( $posts ): ?>
  <?php foreach( $posts as $post): ?>
    <?php setup_postdata($post); ?>
    <?php $post_logo = get_field( 'company-logo-home', $post->ID ); ?>
    <?php $post_company_name = get_field( 'company-name', $post->ID ); ?>
    <?php $post_tagline_home = get_field( 'company-tagline-home', $post->ID ); ?>
      <article class="entry slide">
        <div class="entry-content">
        <?php if ($title): ?>
            <h2 class="page-title"><?php echo ($title); ?></h2>
          <?php endif; ?>
          <h3 class="entry-title"><?php echo ($post_company_name); ?></h3>
          <p><strong><?php echo($post_tagline_home);?></strong></p>
          <br />
          <?php $post_calltoaction = get_field( 'company-link-home', $post->ID ); 
          if( $post_calltoaction ): 
            $post_url = $post_calltoaction['url'];
            $post_title = $post_calltoaction['title'];
            $post_target = $post_calltoaction['target'] ? $post_calltoaction['target'] : '_self';
          ?>
          <a class="btn call-to-action case-study" href="<?php echo esc_url( $post_url ); ?>" target="<?php echo esc_attr( $post_target ); ?>"><?php echo esc_html( $post_title ); ?></a>
          <?php endif; ?>
        </div>
        <div class="entry-image"><img src="<?php echo ($post_logo); ?>" title="<?php echo get_the_title( $post->ID ); ?>" /></div>
      </article>
    <?php endforeach; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

</div>

<style type="text/css">
  
    <?php if ($bkg_img_m): ?>
    #<?php echo esc_attr($id); ?> {
        background-image:url('<?php echo($bkg_img_m);?>');
    }

    <?php if ($bkg_img_oberlay_m): ?>
      #<?php echo esc_attr($id); ?>:after {
        background:url('<?php echo($bkg_img_oberlay_m);?>') no-repeat bottom right;
      }
    <?php endif; ?>
    
    <?php endif; ?>

    <?php if ($bkg_img_d): ?>
    @media (min-width: 768px) {
      #<?php echo esc_attr($id); ?> {
        background-image:url('<?php echo($bkg_img_d);?>');
      }

      <?php if ($bkg_img_oberlay_d): ?>
      #<?php echo esc_attr($id); ?>:after {
        background:url('<?php echo($bkg_img_oberlay_d);?>') no-repeat bottom right;
      }
      <?php endif; ?>
    }
    <?php endif; ?>

</style>