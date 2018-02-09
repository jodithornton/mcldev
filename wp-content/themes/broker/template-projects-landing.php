<?php
/**
 * Template Name: Projects landing
 * @package commercegurus
 */

global $cg_options;
$cg_portfolio_columns = '';

if ( isset( $cg_options['cg_portfolio_columns'] ) ) {
    $cg_portfolio_columns = $cg_options['cg_portfolio_columns'];
}


get_header();

?>

<?php cg_get_page_title(); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12">

        <ul id="filters">
            <li><a href="#" data-filter="*" class="selected is-checked"><?php esc_html_e( 'All', 'broker' ); ?></a></li>
            <?php 
                $terms = get_terms( "project-categories" );
                $count = count( $terms );
                if ( $count > 0 ){
                    foreach ( $terms as $term ) {
                        echo "<li><a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a></li>\n";
                    }
                } 
            ?>
        </ul>

        <?php if ( $cg_portfolio_columns == 'two' ) { ?>
            <div id="project" class="project-two-cols">

        <?php } else if ( $cg_portfolio_columns == 'three' ) { ?>
            <div id="project" class="project-three-cols">

        <?php } else if ( $cg_portfolio_columns == 'four' ) { ?>
            <div id="project" class="project-four-cols">

        <?php } else { ?>
            <div id="project" class="project-three-cols">
        <?php } ?>
 
        <?php 
            $args = array( 'post_type' => 'project', 'posts_per_page' => -1 );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post(); 
                 
            $terms = get_the_terms( $post->ID, 'project-categories' );                     
            if ( $terms && ! is_wp_error( $terms ) ) : 
                 
            $links = array();
                 
            foreach ( $terms as $term ) {
                $links[] = $term->slug;
            }
                 
            $tax_links = join( " ", str_replace(' ', '-', $links));          
            $tax = strtolower( $tax_links );
            else :  
            $tax = '';                  
            endif; 
                 
            echo '<div class="all project-item grid-sizer '. $tax .'"><div class="item-with-padding">';
        ?>
                   
        <a href="<?php the_permalink() ?>"><?php the_post_thumbnail() ?>
            <span class="overlay"></span>
                <span class="project-container">
                    <span class="title"><?php the_title() ?></span>
                    
                        
                    <?php 
                    $cg_project_categories = get_the_terms( $post->ID, 'project-categories' );
                    if ( $cg_project_categories ) { 
                    ?>
                    <span class="tags">
                    <?php
                                $cg_project_categories = array_values( $cg_project_categories );
                                for( $cat_count=0; $cat_count<count( $cg_project_categories ); $cat_count++ ) {
                                    echo $cg_project_categories[$cat_count]->name;
                                    if ( $cat_count<count( $cg_project_categories )-1 ){
                                        echo ', ';
                                    }
                                }
                     ?>
                     </span>
                     <?php        
                    }
                    ?>

                    
        <?php  echo '</span>'; ?>
        </a>
        <?php  echo '</div></div>';
        endwhile; ?>

         
        </div><!-- #project -->

        </div>
    </div><!--/row -->
</div>

<script type="text/javascript">

jQuery( function() {

    // Cache Container
    var $container = jQuery( '#project' );

    // Initialize Isotope
    $container.imagesLoaded( function() {
    $container.isotope({
    // Options
    itemSelector: '.project-item'
    });

});

// Filter items when filter link is clicked
jQuery( '#filters a' ).click( function(){

    jQuery( '#filters a.selected' ).removeClass( 'selected' );
    var selector = jQuery( this ).attr( 'data-filter' );
    $container.isotope({ filter: selector, animationEngine : "css" });
    jQuery( this ).addClass( 'selected' );
    return false;

});

});

</script>


<?php get_footer(); ?>
