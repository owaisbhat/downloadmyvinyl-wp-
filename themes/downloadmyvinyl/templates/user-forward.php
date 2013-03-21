<?php
/*
 * Template Name: User Forward
 */

if ( is_user_logged_in() ) : 
    // Get the Current User Info
    global $current_user;
    get_currentuserinfo();

    $query_vars = http_build_query( $_GET );

    wp_redirect( get_home_url() . "/user/{$current_user->nickname}?$query_vars" );
else :
    get_header();

    echo ( "<div class='span8'>" );
        echo insert_login_page();
    echo ( "</div><!-- end .span8 -->" );
    
    get_footer();
endif;

?>
