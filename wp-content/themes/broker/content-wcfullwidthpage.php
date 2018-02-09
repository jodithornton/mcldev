<?php
/**
 * The template used for displaying full width page content in page.php
 *
 * @package commercegurus
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="structured-metadata">
		<div class="entry-title"><?php the_title(); ?></div>
		<div class="entry-posted"><?php cg_posted_on(); ?></div>
	</div>
    <div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'broker' ),
			'after'	 => '</div>',
		) );
		?>
    </div><!-- .entry-content -->
    <div class="container">
		<?php edit_post_link( esc_html__( 'Edit', 'broker' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
    </div>
</article><!-- #post-## -->
