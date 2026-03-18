<?php
/**
 * @author Daniel Paladini | http://www.paladini.cat
 * @package PDP 0.1
 */
?>

<?php
$postID = get_the_ID();
$featured_img_url = get_the_post_thumbnail_url($postID, 'medium');
// echo $featured_img_url;
?>

<article id="post-<?php the_ID();?>" class="entry-tarja item article">
 <a class="link" href="<?php echo get_permalink(); ?>"></a>
 <div class="entry-image" style="background:url('<?php echo ($featured_img_url); ?>') no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">

</div>
 <div class="entry-content">
 <ul class="category">
   <?php	foreach((get_the_category()) as $category){	echo "<li>" .$category->name. "</li>"; } ?>
 </ul>
   <h3 class="entry-title"><?php the_title(); ?></h3>
   <p class="resum"><?php echo wp_trim_words( get_the_content(), 10, '...' ); ?></p>
 </div>
 <!-- end entry-content -->
</article>
