<?php
if( function_exists( 'geoport_framework_init' ) ) {
  $geoport_breadcrumb_switch = geoport_get_option('geoport_breadcrumb_switch');
  $sticky_menu_switch = geoport_get_option('sticky_menu_switch');
  $top_header = geoport_get_option('top_header2');
} else {
  $geoport_breadcrumb_switch = '';
  $all_default_height = 'all-default-h2';
  $sticky_menu_switch = '';
  $top_header = '';
}

if( function_exists( 'geoport_framework_init' ) ) {
  if ($geoport_breadcrumb_switch == true) {
    $breadcrumb_height = 'breadcrumb_height';
  } else {
    $breadcrumb_height = 'breadcrumb_menu_height';
  }
} else {
  $breadcrumb_height = 'breadcrumb_height';
}

$geoport_header_settings = get_post_meta( get_the_ID(), '_custom_page_header_options', true );
if(!empty($geoport_header_settings['header_style'])) {
  $all_default_height = '';
} elseif(function_exists( 'geoport_framework_init' ) ) {
  $default_header_style = geoport_get_option('default_header_style');
  if($default_header_style == 'style1') {
    $all_default_height = 'all-default-h1';
  } elseif ($default_header_style == 'style2')  {
    $all_default_height = 'all-default-h2';
  } elseif ($default_header_style == 'style3')  {
    $all_default_height = 'all-default-h3';
  } else {
    $all_default_height = 'all-default-h1';
  }
} else {
  $all_default_height = 'all-default-h1';
}

if (!empty($sticky_menu_switch)) {
  $sticky_id = 'header-sticky';
} else {
  $sticky_id = 'header-sticky-none';  
}
if (display_header_text()==true) {
  $auto_class = ' have-site-desc';
} else {
  $auto_class = ' none-site-desc';
} 

$dynamic_classes = $breadcrumb_height.' '.$all_default_height.$auto_class; 

?>

<!-- header-area -->
<header id="<?php echo esc_attr( $sticky_id ); ?>" class="transparent-header header-style-two <?php echo esc_attr( $dynamic_classes ); ?>">
  <?php if (!empty( $top_header )) { 
    $header2_left_list = geoport_get_option('header2_left_list');
    $header2_right_list = geoport_get_option('header2_right_list');
    $header2_social_btn = geoport_get_option('header2_social_btn');

    if ( ! empty( $header2_left_list ) && ( ! empty( $header2_right_list ) || ! empty( $header2_social_btn ) ) ) {
      $left_cols = '5';
      $right_cols = '7';
      $content_align = 'justify-content-end';
    } elseif ( ! empty( $header2_left_list ) && ( empty( $header2_right_list ) || empty( $header2_social_btn ) ) ) {
      $left_cols = '12';
      $right_cols = '0';
      $content_align = 'justify-content-end';
    } elseif ( empty( $header2_left_list ) && ( ! empty( $header2_right_list ) || ! empty( $header2_social_btn ) ) ) {
      $left_cols = '0';
      $right_cols = '12';
      $content_align = 'justify-content-start';
    } else {
      $left_cols = '5';
      $right_cols = '7';
      $content_align = 'justify-content-end';
    }
    if ( ! empty( $header2_left_list ) || ( ! empty( $header2_right_list ) || ! empty( $header2_social_btn ) ) ) {
      ?>
      <div class="header-top-area">
        <div class="container-fluid header-full-width">
          <div class="row">
            <?php if (is_array($header2_left_list)) { ?>
              <div class="col-lg-<?php echo esc_attr( $left_cols ); ?> col-md-5">
                <div class="header-top-link">
                  <ul>
                    <?php foreach ( $header2_left_list as $key => $value ) { 

                      $data_type = $value['list_link'];
                      if(filter_var($data_type, FILTER_VALIDATE_EMAIL)){
                        $href_value = 'email';
                      } elseif ( preg_match('/^[0-9\-\(\)\/\+\s]*$/', $data_type ) ) {
                        $href_value = 'phone';
                      } elseif (filter_var($data_type, FILTER_VALIDATE_URL)) {
                        $href_value = 'url';
                      } else {
                        $href_value = '';
                      }
                    ?>
                    <li>
                      <?php if (!empty($href_value == 'email')) { ?>
                      <a href="mailto:<?php echo sanitize_email( $data_type ); ?>">
                      <?php } elseif (!empty( $href_value == 'phone' )) { 
                        $phone_no = str_replace(" ", "", $data_type);
                      ?>
                      <a href="tel:<?php echo esc_attr($phone_no); ?>">
                      <?php } else { ?>
                        <a href="<?php echo esc_url( $data_type ); ?>">
                        <?php } if ( ! empty( $value['list_icon'] ) ) { ?>
                          <i class="<?php echo esc_attr( $value['list_icon'] ); ?>"></i>
                        <?php } ?>
                        <?php echo esc_attr( $value['list_text'] ); ?>
                      </a>
                    </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            <?php } if ( is_array( $header2_right_list ) || is_array( $header2_social_btn ) ) { ?>
            <div class="col-lg-<?php echo esc_attr( $right_cols ); ?> col-md-7">
              <div class="header-top-right d-flex align-items-center <?php echo esc_attr( $content_align ); ?>">
                <?php if ( is_array( $header2_right_list ) ) { ?>
                  <div class="header-top-link">
                    <ul>
                      <?php foreach ( $header2_right_list as $key => $value ) { 

                      $data_type = $value['list_link'];
                      if(filter_var($data_type, FILTER_VALIDATE_EMAIL)){
                        $href_value = 'email';
                      } elseif ( preg_match('/^[0-9\-\(\)\/\+\s]*$/', $data_type ) ) {
                        $href_value = 'phone';
                      } elseif (filter_var($data_type, FILTER_VALIDATE_URL)) {
                        $href_value = 'url';
                      } else {
                        $href_value = '';
                      }
                      ?>
                      <li>
                        <?php if (!empty($href_value == 'email')) { ?>
                          <a href="mailto:<?php echo sanitize_email( $data_type ); ?>">
                          <?php } elseif (!empty( $href_value == 'phone' )) { 
                            $phone_no = str_replace(" ", "", $data_type);
                            ?>
                            <a href="tel:<?php echo esc_attr($phone_no); ?>">
                            <?php } else { ?>
                              <a href="<?php echo esc_url( $data_type ); ?>">
                              <?php } if ( ! empty( $value['list_icon'] ) ) { ?>
                                <i class="<?php echo esc_attr( $value['list_icon'] ); ?>"></i>
                              <?php } ?>
                              <?php echo esc_attr( $value['list_text'] ); ?>
                            </a>
                          </li>
                        <?php } ?>
                    </ul>
                  </div>
                <?php } if ( is_array( $header2_social_btn ) ) { ?>
                  <div class="header-social">
                    <?php foreach ( $header2_social_btn as $key => $value ) { ?>
                      <a href="<?php echo esc_url( $value['social_link'] ); ?>"><i class="<?php echo esc_attr( $value['social_icon'] ); ?>"></i></a>
                    <?php } ?>
                  </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php }
    }
    if ( display_header_text()==true ) {
      $auto_class = ' have-site-desc';
    } else {
      $auto_class = ' none-site-desc';
    }
    $dynamic_class =  $breadcrumb_height.$auto_class;
  ?>
  <div class="container-fluid header-full-width <?php echo esc_attr( $dynamic_class ); ?>">
    <div class="menu-area">
      <div class="row align-items-center">
        <div class="col-lg-3 col-sm-6">
          <div class="logo">
            <?php
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            if ( has_custom_logo() ) {
              echo '<a href="'.esc_url(home_url('/')).'" class="navbar-brand-logo"><img src="'. esc_url( $logo[0] ) .'" alt="'.esc_attr__( 'Geoport logo', 'geoport' ).'"></a>';
              $auto_class = 'customizer-logo';
            } elseif(function_exists( 'geoport_framework_init' ) ) {
              $site_logo_id = geoport_get_option('geoport_logo1_sticky');
              $attachment = wp_get_attachment_image_src( $site_logo_id, 'full' );
              $site_logo    = ($attachment) ? $attachment[0] : $site_logo_id;
              if (!empty($site_logo )) {
                echo'<a href="'.esc_url(home_url('/')).'" class="navbar-brand-logo"><img alt="'.esc_attr__( 'Geoport logo', 'geoport' ).'" src="'.esc_url( $site_logo ).'"></a>';
                $auto_class = 'option-logo';
              } else {
                echo '<a href="'.esc_url(home_url('/')).'" class="default-logo">'. get_bloginfo( 'name' ) .'</a>';
                $auto_class = 'text-logo';
              }
            } else {
              $auto_class = 'text-logo';
              echo '<a href="'.esc_url(home_url('/')).'" class="default-logo">'. get_bloginfo( 'name' ) .'</a>';
            } 
            ?>
          </div>
          <?php 
          if ( display_header_text() == true ) {
            $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) : ?>
              <div class="site-description"><?php echo esc_attr($description); ?></div>
            <?php endif; 
          }
          ?>
        </div>
        <?php 
        if(function_exists( 'geoport_framework_init' ) ) {
          $lan_btn_switch = geoport_get_option('lan2_btn_switch');
          $menu_btn_switch = geoport_get_option('menu2_btn_switch');
          if ( !empty($lan_btn_switch) && !empty($menu_btn_switch) ) {
            $menu_col = '6';
            $sc_col = '3';
          } elseif ( !empty($lan_btn_switch) ){
            $menu_col = '8';
            $sc_col = '1';
          } elseif ( !empty($menu_btn_switch) ){
            $menu_col = '6';
            $sc_col = '3';
          } else {
            $menu_col = '9';
            $sc_col = '0';
          }
          $lan_btn_shortcode = geoport_get_option('lan2_btn_shortcode');
          $menu2_btn_icon = geoport_get_option('menu2_btn_icon');
          $menu2_btn_text = geoport_get_option('menu2_btn_text');
          $menu2_btn_link = geoport_get_option('menu2_btn_link');
        } else {
          $lan_btn_switch  = '';
          $menu_btn_switch = '';
          $lan_btn_shortcode = '';
          $menu2_btn_icon = '';
          $menu2_btn_text = '';
          $menu2_btn_link = '';
          $menu_col = '9';
          $sc_col = '0';
        }
        if (!empty($menu2_btn_icon)) {
          $btn_icon = '<i class="'.esc_attr( $menu2_btn_icon ).'"></i>';
        } else {
          $btn_icon = '';
        }
        ?>
        <div class="col-xl-<?php echo esc_attr( $menu_col ); ?> col-lg-8 d-none d-lg-block">
          <div class="main-menu">
            <nav id="mobile-menu">
              <?php if ( has_nav_menu( 'primary' ) ) { 
                wp_nav_menu(array(
                  'theme_location' => 'primary',
                  'container'      => false,
                  'menu_class'     => '',
                  'echo'           => true,
                  'depth'          => 3,
                  'items_wrap'     => '<ul class="geoport-main-menu">%3$s</ul>',
                  'walker'         => new Geoport_Navwalker()
                ));
              } else {
                if ( is_user_logged_in() ) {
                  echo '<ul id="menu" class="nav navbar-nav navbar-right nav-sideb fallbackcd-menu-item"><li><a class="fallbackcd" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add a menu', 'geoport' ) . '</a></li></ul>';
                }
              } ?>
            </nav>
          </div>
        </div>
        <?php if ( !empty($lan_btn_switch) || !empty($menu_btn_switch) ) { ?>
          <div class="col-xl-<?php echo esc_attr( $sc_col ); ?> col-lg-1 col-sm-6 d-sm-block device575">
            <div class="header-action d-flex align-items-center justify-content-end">
              <?php if ( !empty($lan_btn_switch) && !empty($lan_btn_shortcode) ) {
                echo do_shortcode( $lan_btn_shortcode );
              } if ( !empty($menu_btn_switch) ) { ?>
                <div class="header-btn">
                  <a href="<?php echo esc_html( $menu2_btn_link ); ?>" class="btn transparent-btn">
                    <?php 
                    echo wp_kses_stripslashes($btn_icon);
                    echo esc_html( $menu2_btn_text ); 
                    ?>
                  </a>
                </div>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
        <div class="col-12 <?php echo esc_attr( $auto_class ); ?>">
          <div class="mobile-menu"></div>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- header-area-end -->

<div class="stricky-height-fix header2"></div>