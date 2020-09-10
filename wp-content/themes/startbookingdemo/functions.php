<?php

add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' );


function register_my_menu() {
    register_nav_menu('main-nav',__( 'Navigation principale' ));
}
add_action( 'init', 'register_my_menu' );
function my_enqueue_assets() {

    //wp_enqueue_style( 'slickcss', get_stylesheet_directory_uri() . '/css/slick.css', '1.6.0', 'all');
    //wp_enqueue_style( 'slickcsstheme', get_stylesheet_directory_uri(). '/css/slick-theme.css', '1.6.0', 'all');
    wp_enqueue_style( 'normalize', get_stylesheet_directory_uri(). '/node_modules/normalize.css/normalize.css');

    wp_enqueue_style( 'style', get_template_directory_uri().'/style.css' );

    //wp_enqueue_script( 'slickjs', get_stylesheet_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.6.0', false );
    //wp_enqueue_script( 'slickjs-init', get_stylesheet_directory_uri(). '/js/slick-init.js', array( 'slickjs' ), '1.6.0', false);

    //wp_enqueue_script( 'menu-js', get_stylesheet_directory_uri().'/js/menu.js', array('jquery'), '3.3.1', true );

}