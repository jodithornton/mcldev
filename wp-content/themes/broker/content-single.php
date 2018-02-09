<?php
/**
 * @package commercegurus
 */
?>
<?php 		
$allowed_args = array(
	//formatting
	'span' => array(
		'class' => array()
	),
);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="structured-metadata">
		<div class="entry-title"><?php the_title(); ?></div>
		<div class="entry-posted"><?php cg_posted_on(); ?></div>
	</div>
	<div class="image">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail(); ?>
		<?php endif; ?>
    </div>

	<div class="blog-meta">
		<span><time class="entry-date published updated" datetime="%1$s"><?php the_time( 'F j, Y' ) ?></time></span> <span class="comments"><?php comments_number(); ?> </span>
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
	
	<?php if( get_field('author_name') ): ?>
	
		<h1>Meet the author</h1>
	
		<div class="row">
			<div class="col-sm-4"><img class="img-thumbnail" src ="<?php the_field('author_image'); ?>"/></div>
			<div class="col-sm-8">
				<h2 style="margin-top:0;"><?php the_field('author_name'); ?></h2>
				<p><?php the_field('author_blurb'); ?></p>
				<p>
				<?php if( get_field('author_email') ): ?>
					<?php echo '<i class="fa fa-at" aria-hidden="true"></i>';?> 
					<a href="mailto:<?php the_field('author_email'); ?>">Send an email to <?php the_field('author_name'); ?></a>
				<?php endif; ?>
				</p>
				<p><i class="fa fa-linkedin-square" aria-hidden="true"></i> <a href="<?php the_field('linkedin_handle'); ?>">Connect with <?php the_field('author_name'); ?> on LinkedIn</a></p>
			</div>

		</div>
	
	<?php endif; ?>
	
		
    <footer class="entry-meta">
		<?php
		/* translators: used between list items, there is a space after the comma */
		$category_list	 = get_the_category_list( esc_html__( ', ', 'broker' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', esc_html__( ', ', 'broker' ) );

		if ( !cg_categorized_blog() ) {
			// This blog only has 1 category so we just need to worry about tags in the meta text
			if ( '' != $tag_list ) {
				$meta_text = wp_kses( __( '<span class="tags">%2$s</span>', 'broker' ), $allowed_args );
			} else {
				$meta_text = wp_kses( __( '<span class="tags">%2$s</span>', 'broker' ), $allowed_args );
			}
		} else {
			// But this blog has loads of categories so we should probably display them here
			if ( '' != $tag_list ) {
				$meta_text = wp_kses( __( '<span class="categories">%1$s</span> <span class="tags">%2$s</span>', 'broker' ), $allowed_args );
			} else {
				$meta_text = wp_kses( __( '<span class="categories">%1$s</span> <span class="tags">%2$s</span>', 'broker' ), $allowed_args );
			}
		} // end check for categories on this blog

		printf(
		$meta_text, $category_list, $tag_list, get_permalink()
		);
		?>

<?php // edit_post_link( esc_html__( 'Edit', 'broker' ), '<span class="edit-link">', '</span>' );  ?>
    </footer><!-- .entry-meta -->

</article><!-- #post-## -->
