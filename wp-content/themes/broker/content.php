<?php
/**
 * @package commercegurus
 */
global $cg_options, $cg_news_layout;
?>

			<?php if ( $cg_news_layout == 'grid-news' ) { ?>

					<div class="col-lg-4 col-md-4 col-sm-12">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="image">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
								<?php the_post_thumbnail(); ?>
							</a>
						</div>
					
						<header class="entry-header">

							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>   

							<?php if ( 'post' == get_post_type() ) : ?>
								<div class="blog-meta">
									<span><?php the_time( 'F j, Y' ) ?></span>
								</div>
							<?php endif; ?>

						</header><!-- .entry-header -->
						<!-- Displays the excerpt unless the post type is a Link or a Quote -->
						<div class="entry-content">
							<?php
							the_content( esc_html__( 'Read more', 'broker' ) );
							wp_link_pages( array(
								'before'		 => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'broker' ) . '</span>',
								'after'			 => '</div>',
								'link_before'	 => '<span>',
								'link_after'	 => '</span>',
							) );
							?>
						</div><!-- .entry-content -->
					</article><!-- /article -->
					</div><!--/4 -->



					<?php
				} else if ( $cg_news_layout == 'grid-news-two' ) {
					
					?>

					<div class="col-lg-6 col-md-6 col-sm-12">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="image">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
								<?php the_post_thumbnail(); ?>
							</a>
						</div>
					
						<header class="entry-header">

							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>   

							<?php if ( 'post' == get_post_type() ) : ?>
								<div class="blog-meta">
									<span><?php the_time( 'F j, Y' ) ?></span>
								</div>
							<?php endif; ?>

						</header><!-- .entry-header -->
						<!-- Displays the excerpt unless the post type is a Link or a Quote -->
						<div class="entry-content">
							<?php
							the_content( esc_html__( 'Read more', 'broker' ) );
							wp_link_pages( array(
								'before'		 => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'broker' ) . '</span>',
								'after'			 => '</div>',
								'link_before'	 => '<span>',
								'link_after'	 => '</span>',
							) );
							?>
						</div><!-- .entry-content -->
					</article><!-- /article -->
					</div><!--/6 -->

					<?php
				} else {
					// default blog with images 
					?>


					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="cg-blog-article">

					<div class="image">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
							<?php the_post_thumbnail(); ?>
						</a>  
					</div>

					<header class="entry-header">
					<div class="blog-meta">
							<?php cg_get_author_name(); ?>
							<span><time class="entry-date published updated" datetime="%1$s"><?php the_time( 'F j, Y' ) ?></time></span> <span class="comments"><?php comments_number(); ?> </span>
					</div>
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>   
						
					</header><!-- .entry-header -->
					<?php if ( is_search() ) { // Only display Excerpts for Search   ?>
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->
					<?php } else { ?>
						<div class="entry-content">
							<?php
							the_content( esc_html__( 'Read more', 'broker' ) );
							wp_link_pages( array(
								'before'		 => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'broker' ) . '</span>',
								'after'			 => '</div>',
								'link_before'	 => '<span>',
								'link_after'	 => '</span>',
							) );
							?>
						</div><!-- .entry-content -->
					<?php } ?>
					<footer class="entry-meta">
						<?php if ( 'post' == get_post_type() ) { // Hide category and tag text for pages on Search ?>
							<?php
							/* translators: used between list items, there is a space after the comma */
							$categories_list = get_the_category_list( esc_html__( ', ', 'broker' ) );
							if ( $categories_list && cg_categorized_blog() ) {
								?>
								<span class="categories">
									<?php printf( esc_html__( '%1$s', 'broker' ), $categories_list ); ?>
								</span>
							<?php } // End if categories ?>

							<?php
							/* translators: used between list items, there is a space after the comma */
							$tags_list = get_the_tag_list( '', esc_html__( ', ', 'broker' ) );
							if ( $tags_list ) {
								?>
								<span class="tags">
									<?php printf( esc_html__( '%1$s', 'broker' ), $tags_list ); ?>
								</span>
							<?php } // End if $tags_list ?>
						<?php } // End if 'post' == get_post_type()   ?>



					</footer><!-- .entry-meta --> 

					</div><!--/cg-blog-article -->
			    </article><!-- #post-## -->

					<?php
				}
				
				?>