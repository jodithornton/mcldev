</div>
</div><!--/page-container -->

</div><!--/wrapper-->
</div><!-- close #cg-page-wrap -->



<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package commercegurus
 */
global $cg_options;
$cg_footer_message		 = '';
$cg_footer_message		 = $cg_options['cg_footer_message'];
$cg_footer_top_active	 = '';
$cg_footer_top_active	 = $cg_options['cg_footer_top_active'];
$cg_footer_bottom_active = '';
$cg_footer_bottom_active = $cg_options['cg_footer_bottom_active'];
$cg_back_to_top = '';
$cg_back_to_top = $cg_options['cg_back_to_top'];

?>

<footer class="footercontainer"> 
	<?php if ( $cg_footer_top_active == 'yes' ) { ?>
		<?php if ( is_active_sidebar( 'first-footer' ) ) : ?>
			<div class="first-footer">
				<div class="container">
					<div class="row">
						<?php dynamic_sidebar( 'first-footer' ); ?>   
					</div><!-- /.row -->
				</div><!-- /.container -->
			</div><!-- /.lightwrapper -->
		<?php endif; ?>
	<?php } ?>

	<?php if ( $cg_footer_bottom_active == 'yes' ) { ?>
		<?php if ( is_active_sidebar( 'second-footer' ) ) : ?>
			<div class="second-footer">
				<div class="container">
					<div class="row">
                    <div class="divider"></div>
						<?php dynamic_sidebar( 'second-footer' ); ?>            
					</div><!-- /.row -->
				</div><!-- /.container -->
			</div><!-- /.subfooter -->
		<?php endif; ?>
	<?php } ?>

</footer>



    <div class="footer">
        <div class="container">
            <div class="row">
            	<div class="bottom-footer-left col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php
                    if ( $cg_footer_message ) {
                        echo '<div class="footer-copyright">';
                        echo $cg_footer_message;
                        echo '</div>';
                    }
                    ?>
                </div>
                
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.footer -->

<?php if ( $cg_back_to_top == 'yes' ) { ?>
	<a href="#0" class="cd-top">Top</a>
<?php } ?>
<?php
global $cg_live_preview;
if ( isset( $cg_live_preview ) )
	include("live-preview.php")
?>
<?php wp_footer(); ?>
</body>
</html>