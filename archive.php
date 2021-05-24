<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package geoport
 */

get_header(); ?>

<?php do_action( 'geoport_breadcrum' ); ?>

<!-- archive-section - start
================================================== -->
<div class="primary-bg">
    <div class="inner-blog pt-120 pb-90">
        <div class="container">
            <div class="row">

                <?php 
                    if ( is_active_sidebar( 'right-sidebar') ) {
                        if( function_exists( 'geoport_framework_init' ) ) {
                            $blog_layout = geoport_get_option('blog_layout');
                            if ( $blog_layout == 'left-sidebar' ) {
                                $col   = '8';
                                $class = 'order-12';
                            } elseif ( $blog_layout == 'right-sidebar' ) {
                                $col   = '8';
                                $class = '';
                             } elseif ( $blog_layout == 'full-width' ) {
                                $class = '';
                                $col   = '12';
                            } else {
                                $class = '';
                                $col   = '8';
                            }
                        } else {
                            $col   = '8';
                            $class = '';
                        }
                    } else {
                        $col   = '12';
                        $class = '';
                    }
                ?>
                <div class="col-lg-<?php echo esc_attr( $col . ' ' . $class ); ?>">
                    <!-- Letest Blog Btn -->
                    <div class="row">
                        <!-- ========== blog - start ========== -->
                        <?php  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            
                        <?php get_template_part( 'template-parts/content', get_post_format() ); ?>

                        <?php endwhile; ?>

                        <?php echo geoport_paging_nav(); ?>

                        <?php else : ?>
                            <?php get_template_part( 'template-parts/content', 'none' ); ?>
                        <?php endif; ?>
                        <!-- ========== blog - end ========== -->
                    </div>
                    <!-- Start Blog Sidebar -->
                </div>
                
                <?php 
                    if ( is_active_sidebar( 'right-sidebar') ) {
                        if( function_exists( 'geoport_framework_init' ) ) {
                            $blog_layout = geoport_get_option('blog_layout');
                            if ( $blog_layout == 'left-sidebar' ||  $blog_layout == 'right-sidebar' ) {
                                get_sidebar('right');
                            } elseif ($blog_layout == 'full-width') {
                                
                            } else {
                                get_sidebar('right');
                            }
                        } else {
                           get_sidebar('right');
                        }
                    }
                ?>
            </div><!-- row -->
        </div><!-- container -->
    </div>
</div>
<!-- archive-section - End
================================================== -->

<?php get_footer(); ?>