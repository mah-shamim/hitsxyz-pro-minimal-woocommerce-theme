<?php 
function hitsxyz_child_register_scripts(){
    $parent_style = 'hitsxyz-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', array('font-awesome-5', 'hitsxyz-reset'), hitsxyz_get_theme_version() );
    wp_enqueue_style( 'hitsxyz-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'hitsxyz_child_register_scripts', 99 );