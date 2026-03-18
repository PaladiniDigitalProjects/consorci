<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage PDP
 * @since 1.0
 * @version 1.0
 */

?>


<article class="item <?php foreach ( get_the_terms( get_the_ID(), 'vacantes_tax' ) as $tax ) { echo($tax->slug); } ?> <?php foreach ( get_the_terms( get_the_ID(), 'poblacion_tax' ) as $taxp ) { echo ( ' ' . $taxp->slug );} ?>">
	<a class="link" href="<?php the_permalink(); ?>" rel="bookmark"></a>
	<header class="entry-header">
		<h4 class="entry-title"><?php the_title(); ?></h4>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<p><?php the_excerpt(); ?></p>
		<div class="metadata flex">
		<dl class="categories">
				<dt class="vacante"><?php _e('Vacante', 'PDP'); ?></dt>
				<?php	foreach ( get_the_terms( get_the_ID(), 'vacantes_tax' ) as $tax ) {
		    	echo '<dd>'. __( $tax->name ) . '</dd>';
				} wp_reset_query(); ?>
			</dl>

		<dl class="tags">
			<dt class="poblacion"><?php _e('Población', 'PDP'); ?></dt>
		<?php
			foreach ( get_the_terms( get_the_ID(), 'poblacion_tax' ) as $taxp ) {
			    echo '<dd>' . __( $taxp->name ) . '</dd>';
			} wp_reset_query(); ?>
		</dl>
	</div>
	<!-- end metadata -->
	</div><!-- .entry-content -->
</article><!-- #post-## -->
