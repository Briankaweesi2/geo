<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package geoport
 */

/*--------------------------------------------------------------------------------------------------*/
/*  Comments from call back function.
/*--------------------------------------------------------------------------------------------------*/

if(!function_exists('geoport_comment')):

    function geoport_comment($comment, $args, $depth) {
        
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
            // Display trackbacks differently than normal comments.
        ?>
        <li <?php comment_class(); ?> id="submited-comment">

            <p><?php esc_html_e( 'Pingback:', 'geoport' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'geoport' ), '<span class="edit-link">', '</span>' ); ?></p>
            <?php
            break;
            default :

            global $post;
            ?>

            <li <?php comment_class(); ?>>

                <div class="bs-example" data-example-id="media-list"> 
                    <ul class="comments media-list">
                        <li class="comment-box clearfix" id="comment-<?php comment_ID(); ?>">
                            <article>
                                <div class="single-comment bd-comment-box">
                                    <div class="comments-avatar">
                                        <?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
                                    </div>
                                    <div class="comment-text">
                                        <div class="avatar-name mb-15">
                                            <h6><?php comment_author(); ?>
                                            <?php comment_reply_link( array_merge( $args, array( 'reply_text' => '<i class="fal fa-reply"></i>'.esc_html__( 'Reply', 'geoport' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>                                                
                                            </h6>
                                             <span class="ago"><?php echo (get_comment_date() . esc_html__( ' at ', 'geoport' ) .get_comment_time()); ?></span>
                                        </div>
                                        <div class="text"><?php comment_text(); ?></div>
                                    </div>
                                </div>
                            </article>
                        </li>
                    </ul>
                </div>
            <?php
        break;
        endswitch; 
    }
endif;


/*--------------------------------------------------------------------------------------------------*/
/*  Search
/*--------------------------------------------------------------------------------------------------*/
add_filter('get_search_form', 'geoport_search_form');
function geoport_search_form($form) {

    /**
     * Search form customization.
     *
     * @link http://codex.wordpress.org/Function_Reference/get_search_form
     * @since 1.0.0
     */
    $form = '<div class="ws-input"><form role="search" method="get" action="' .esc_url( home_url('/') ) . '">
                <input type="search" placeholder="'.esc_attr__( 'Enter Search Keywords', 'geoport' ).'" name="s">
                <button><i class="dashicons dashicons-search"></i></button>
            </form></div>';
    return $form;
}

/*--------------------------------------------------------------------------------------------------*/
/*   The excerpt
/*--------------------------------------------------------------------------------------------------*/
function geoport_excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
    return $excerpt;
}

/*--------------------------------------------------------------------------------------------------*/
/* Category List count wrap by span
/*--------------------------------------------------------------------------------------------------*/
add_filter('wp_list_categories', 'geoport_cat_count_span');
function geoport_cat_count_span($links) {        
    $links = str_replace('(', '<span class="pull-right">', $links);
    $links = str_replace(')', '</span>', $links);
    return $links;
}

/*--------------------------------------------------------------------------------------------------*/
/* Archive List count wrap by span
/*--------------------------------------------------------------------------------------------------*/
add_filter('get_archives_link', 'geoport_archive_cat_count_span');
function geoport_archive_cat_count_span($links) {        
    $links = str_replace('(', '<span class="pull-right">', $links);
    $links = str_replace(')', '</span>', $links);
    return $links;
}

/*--------------------------------------------------------------------------------------------------*/
/*  Geoport Breadcrum
/*--------------------------------------------------------------------------------------------------*/
add_action('geoport_breadcrum', 'geoport_breadcrum_set');
function geoport_breadcrum_set() {

    if(function_exists( 'geoport_framework_init' ) ) {

        $breadcrumb_bg_condition = geoport_get_option('breadcrumb_bg_condition');

        $blog_page_breadcrumb = geoport_get_option('blog_page_breadcrumb_title');
        if (!empty($blog_page_breadcrumb)) {
            $blog_page_breadcrumb_title = $blog_page_breadcrumb;
        } else {
            $blog_page_breadcrumb_title = esc_html__( 'Blog Posts', 'geoport' );
        }

        $team_single_breadcrumb = geoport_get_option('team_details_breadcrumb_title');
        if (!empty($team_single_breadcrumb)) {
            $team_single_breadcrumb_title = $team_single_breadcrumb;
        } else {
            $team_single_breadcrumb_title = esc_html__( 'Team Details', 'geoport' );
        }

        $page_404_breadcrumb_title = geoport_get_option('404_breadcrumb_title');
        $bg_img_id = geoport_get_option('breadcrumb_bg_img');
        $attachment = wp_get_attachment_image_src( $bg_img_id, 'full' );
        $bg_img    = ($attachment) ? $attachment[0] : $bg_img_id;

    } else {
        $team_single_breadcrumb_title = esc_html__( 'Team Details', 'geoport' );
        $blog_page_breadcrumb_title = esc_html__( 'Blog Posts', 'geoport' );
        $page_404_breadcrumb_title = esc_html__( '404 Error', 'geoport' );
        $breadcrumb_bg_condition = '';
        $bg_img = '';
    }

    if ( has_header_image() ) {
        $bg_img = get_header_image();
    } else {
        $bg_img = $bg_img;
    }

    if (!empty($breadcrumb_bg_condition == 'image')) {
        if ( !empty($bg_img )) {
            $image_overlay = 'image-overlay';
            $breadcrumb_bg = '';
        } else {
            $image_overlay = '';
            $breadcrumb_bg = 'breadcrumb-img-none';
        }
        $bg_img = $bg_img;
    } else {
        $image_overlay = '';
        $breadcrumb_bg = '';
        $bg_img = '';
    }

    if( function_exists( 'geoport_framework_init' ) ) {
        $geoport_breadcrumb_switch = geoport_get_option('geoport_breadcrumb_switch');
    } else {
        $geoport_breadcrumb_switch = '';
    }

    if( function_exists( 'geoport_framework_init' ) ) {

        if ($geoport_breadcrumb_switch == true) {
            $breadcrumb_height = 'breadcrumb_height';
        } else {
            $breadcrumb_height = 'breadcrumb_menu_height';
        }

    } else {
        $breadcrumb_height = '';
    }

    $geoport_header_settings = get_post_meta( get_the_ID(), '_custom_page_options', true );
    
    if(!empty($geoport_header_settings['header_style'])) {
        if($geoport_header_settings['header_style'] == 'style1') {
            $hv = 'hv1';
        } elseif ($geoport_header_settings['header_style'] == 'style2')  {
            $hv = 'hv2';
        } elseif ($geoport_header_settings['header_style'] == 'style3')  {
            $hv = 'hv3';
        } else {
            $hv = 'hv1';
        }
    } elseif(function_exists( 'geoport_framework_init' ) ) {
        $default_header_style = geoport_get_option('default_header_style');
        if($default_header_style == 'style1') {
            $hv = 'hv1';
        } elseif ($default_header_style == 'style2')  {
            $hv = 'hv2';
        } elseif ($default_header_style == 'style3')  {
            $hv = 'hv3';
        } else {
            $hv = 'hv1';
        }
    } else {
        $hv = 'hv1';
    }

    $page_breadcrumb_data = get_post_meta( get_the_ID(), '_custom_page_options', true );

    if (!empty($page_breadcrumb_data['page_breadcrumb_switch'])) {
        if (!empty($page_breadcrumb_data['page_breadcrumb_bg_img'])) {
            $bg_img_id  = $page_breadcrumb_data['page_breadcrumb_bg_img'];
            $attachment = wp_get_attachment_image_src( $bg_img_id, 'full' );
            $bg_img     = ($attachment) ? $attachment[0] : $bg_img_id;
        } else {
            $bg_img = '';
        }
        if (!empty($page_breadcrumb_data['page_breadcrumb_title'])) {
            $page_title = $page_breadcrumb_data['page_breadcrumb_title'];
        } else {
            $page_title = '';
        }
    } else {
        $bg_img = $bg_img;
        $page_title = '';
    }

    if (!empty($page_breadcrumb_data['page_breadcrumb_title'])) {
        $page_bread_title = $page_breadcrumb_data['page_breadcrumb_title'];
    } elseif (!empty( $page_title )) {
        $page_bread_title = $page_title;
    } else {
        $page_bread_title = get_the_title();
    }

    if (!empty($bg_img)) {
        $image_overlay = 'image-overlay';
    } else {
         $image_overlay = '';
    }

    $logical_class = $image_overlay.' '.$breadcrumb_bg.' '.$breadcrumb_height.' '.$hv;

    if ( is_home() || is_front_page() ) { ?>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg d-flex align-items-end <?php echo esc_attr( $logical_class ); ?>" style="background-image: url(<?php echo esc_url($bg_img); ?>);">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2><?php echo esc_html( $blog_page_breadcrumb_title ); ?></h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'geoport') ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php geoport_meta_breadcrumbs(); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <?php } elseif ( is_singular( 'team' ) ) { ?>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg d-flex align-items-end <?php echo esc_attr( $logical_class ); ?>" style="background-image: url(<?php echo esc_url($bg_img); ?>);">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2><?php echo esc_html( $team_single_breadcrumb_title ); ?></h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><?php geoport_meta_breadcrumbs(); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <?php } elseif ( is_single() ) { ?>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg d-flex align-items-end <?php echo esc_attr( $logical_class ); ?>" style="background-image: url(<?php echo esc_url($bg_img); ?>);">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2><?php the_title(); ?></h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><?php geoport_meta_breadcrumbs(); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <?php } elseif ( is_page() || is_archive() || is_search() || is_404() ) { ?>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg d-flex align-items-end <?php echo esc_attr( $logical_class ); ?>" style="background-image: url(<?php echo esc_url($bg_img); ?>);">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2>
                            <?php 
                                if ( is_page() ) {
                                    echo esc_html( $page_bread_title );
                                } elseif (is_archive()) {
                                    geoport_archive_page_title();
                                } elseif (is_search()) {
                                    printf( esc_html__( 'Search for: %s', 'geoport' ), get_search_query() );
                                } elseif (is_404()) {
                                    echo esc_html( $page_404_breadcrumb_title );
                                }
                            ?>  
                        </h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><?php geoport_meta_breadcrumbs(); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->
<?php }
}


/*--------------------------------------------------------------------------------------------------*/
/*  Header Style Load
/*--------------------------------------------------------------------------------------------------*/

add_action('geoport_header_style', 'geoport_header_style_load');

function geoport_header_style_load() {
    $geoport_header_settings = get_post_meta( get_the_ID(), '_custom_page_options', true );
    
    if(!empty($geoport_header_settings['header_style'])) {
        if($geoport_header_settings['header_style'] == 'style1') {
            get_template_part('headers/header', 'default' );
        } elseif ($geoport_header_settings['header_style'] == 'style2')  {
            get_template_part('headers/header', 'style2' );
        } elseif ($geoport_header_settings['header_style'] == 'style3')  {
            get_template_part('headers/header', 'style3' );
        } else {
            get_template_part('headers/header', 'default' );
        }
    } elseif(function_exists( 'geoport_framework_init' ) ) {
        $default_header_style = geoport_get_option('default_header_style');
        if($default_header_style == 'style1') {
            get_template_part('headers/header', 'default' );
        } elseif ($default_header_style == 'style2')  {
            get_template_part('headers/header', 'style2' );
        } elseif ($default_header_style == 'style3')  {
            get_template_part('headers/header', 'style3' );
        } else {
            get_template_part('headers/header', 'default' );
        }
    } else {
        get_template_part('headers/header', 'default' );
    }
}


/*--------------------------------------------------------------------------------------------------*/
/*  Geoport Nav Walker
/*--------------------------------------------------------------------------------------------------*/
class Geoport_Navwalker extends Walker_Nav_Menu {
    /**
     * @see Walker::start_lvl()
     * @since 1.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    private $Geoport_megamenu_status = "";
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        if ($depth == 0 && $this->Geoport_megamenu_status == "enabled") {
            $output .= "\n$indent\n<ul class=\"mormal-menu\">\n";
        } elseif ($depth >= 1 && $this->Geoport_megamenu_status == "enabled") {
            $output .= "\n$indent<ul>\n";
        } elseif ($depth == 0 && $this->Geoport_megamenu_status != "enabled") {
            $output .= "\n$indent<ul class=\"submenu\">\n";
        } elseif ($depth >= 1 && $this->Geoport_megamenu_status != "enabled") {
            $output .= "\n$indent<ul class=\"submenu\">\n";
        } else {
            $output .= "\n$indent<ul>\n";
        }
    }
    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        /**
         * Dividers, Headers or Disabled
         * =============================
         * Determine whether the item is a Divider, Header, Disabled or regular
         * menu item. To prevent errors we use the strcasecmp() function to so a
         * comparison that is not case sensitive. The strcasecmp() function returns
         * a 0 if the strings are equal.
         */
        if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
            $output .= $indent . '<li role="presentation" class="divider">';
        } else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
            $output .= $indent . '<li role="presentation" class="divider">';
        } else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
            $output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
        } else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
            $output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
        } else {
            $class_names = $value = '';
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
            if ( $args->has_children )
                $class_names .= ' submenu-area';
            if ( in_array( 'current-menu-item', $classes ) )
                $class_names .= ' active';
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
            $output .= $indent . '<li' . $id . $value . $class_names .'>';
            $atts = array();
            $atts['title']  = ! empty( $item->title )   ? $item->title  : '';
            $atts['target'] = ! empty( $item->target )  ? $item->target : '';
            $atts['rel']    = ! empty( $item->xfn )     ? $item->xfn    : '';
            // If item has_children add atts to a.
            if ( $args->has_children && $depth === 0 ) {
                $atts['href'] = ! empty( $item->url ) ? $item->url : '';
                $atts['data-toggle']    = 'submenu-area';
                $atts['class']          = 'dropdown-toggle';
                $atts['aria-haspopup']  = 'true';
            } else {
                $atts['href'] = ! empty( $item->url ) ? $item->url : '';
            }
            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
            $item_output = $args->before;
            /*
             * Glyphicons
             * ===========
             * Since the the menu item is NOT a Divider or Header we check the see
             * if there is a value in the attr_title property. If the attr_title
             * property is NOT null we apply it as the class name for the glyphicon.
             */
            if ( ! empty( $item->attr_title ) )
                $item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
            else
                $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= ( $args->has_children && 0 === $depth ) ? '</a>' : '</a>';
            $item_output .= $args->after;
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }
    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max
     * depth and no ignore elements under that depth.
     *
     * This method shouldn't be called directly, use the walk() method instead.
     *
     * @see Walker::start_el()
     * @since 2.5.0
     *
     * @param object $element Data object
     * @param array $children_elements List of elements to continue traversing.
     * @param int $max_depth Max depth to traverse.
     * @param int $depth Depth of current element.
     * @param array $args
     * @param string $output Passed by reference. Used to append additional content.
     * @return null Null on failure with no changes to parameters.
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;
        $id_field = $this->db_fields['id'];
        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
    /**
     * Menu Fallback
     * =============
     * If this function is assigned to the wp_nav_menu's fallback_cb variable
     * and a manu has not been assigned to the theme location in the WordPress
     * menu manager the function with display nothing to a non-logged in user,
     * and will add a link to the WordPress menu manager if logged in as an admin.
     *
     * @param array $args passed from the wp_nav_menu function.
     *
     */
    public static function fallback( $args ) {
        if ( current_user_can( 'manage_options' ) ) {
            extract( $args );
            $fb_output = null;
            if ( $container ) {
                $fb_output = '<' . $container;
                if ( $container_id )
                    $fb_output .= ' id="' . $container_id . '"';
                if ( $container_class )
                    $fb_output .= ' class="' . $container_class . '"';
                $fb_output .= '>';
            }
            $fb_output .= '<ul';
            if ( $menu_id )
                $fb_output .= ' id="' . $menu_id . '"';
            if ( $menu_class )
                $fb_output .= ' class="' . $menu_class . '"';
            $fb_output .= '>';
            $fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">'.esc_html__( 'Add a menu', 'geoport' ).'</a></li>';
            $fb_output .= '</ul>';
            if ( $container )
                $fb_output .= '</' . $container . '>';
            echo wp_kses( $fb_output );
        }
    }
}