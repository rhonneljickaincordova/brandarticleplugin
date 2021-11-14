<?php
/*
  Plugin Name: Brand Articles Custom Post Type
  Plugin URI: 
  Description: Bradnd Articles Custom Post Type for test project
  Author: Rhonnel Cordova
  Version: 0.1
  Author URI: 
 */

/* Enqueue Owl Carousel Library */
function enqueue_owl_carousel_scripts() {   
    wp_enqueue_script( 'owl-carousel-js', plugin_dir_url( __FILE__ ) . '/owlcarousel/owl.carousel.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'owl-carousel-initalise', plugin_dir_url( __FILE__ ) . '/owlcarousel/owl-init.js', array( 'jquery' ), false, true );
    
    wp_enqueue_style( 'cpt-css', plugin_dir_url( __FILE__ ) . 'cpt-style.css' );   
    wp_enqueue_style( 'owl-carousel-css', plugin_dir_url( __FILE__ ) . '/owlcarousel/assets/owl.carousel.css' );
    wp_enqueue_style( 'owl-carousel-theme', plugin_dir_url( __FILE__ ) . '/owlcarousel/assets/owl.theme.default.css' );
}
add_action('wp_enqueue_scripts', 'enqueue_owl_carousel_scripts');

/* Register Custom Post Type 'Brand Articles' */
function register_brand_articles_custom_post_type_init() {
    $labels = array(
        'name' => 'Brand Articles',
        'singular_name' => 'Brand Article',
        'add_new' => 'Add Brand Article',
        'add_new_item' => 'Add New Brand Article',
        'edit_item' => 'Edit Brand Articlee',
        'new_item' => 'New Brand Article',
        'all_items' => 'All Brand Articles',
        'show_in_rest' => true,
        'view_item' => 'View Brand Article',
        'search_items' => 'Search Brand Articles',
        'not_found' =>  'No ABrand Articles Found',
        'not_found_in_trash' => 'There are no Brand Articles',
        'menu_name' => 'Brand Articles',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'has_archive' => true,
        'menu_position' => 21,
        'supports' => array( 'title', 'editor', 'comments', 'author', 'thumbnail', 'revisions', 'custom-fields',),
		'menu_icon' => 'dashicons-smiley',
		'show_in_rest' => true
    );
    register_post_type('brand_articles', $args);
}

add_action( 'init', 'register_brand_articles_custom_post_type_init' );

/* Create a shortcode to display the articles */
function display_brand_articles(){
   $args = array(
       'post_type'      => 'brand_articles',
       'posts_per_page' => '21',
       'publish_status' => 'published',
   );
  
    $query = new WP_Query($args);
  
    if($query->have_posts()){
        
        $result .='<div class="owl-carousel brand-article-wrapper">';
        
        while($query->have_posts()) :
            $query->the_post() ;
        
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full" );
                      
            $result .= '<a href="'.get_the_permalink().'"><div class="brand-article-item">';
            $result .= '<div class="brand-article-thumbnail" style="background-image: url('. $thumb[0] . ')"> </div>';
            $result .= '<h3 class="brand-article-title">' . get_the_title() . '</h3>';
            $result .= '<span class="brand-article-auth"> by ' . get_the_author() . '</span>'; 
            $result .= '</div></a>';
  
        endwhile;
        
        $result .= "</div>";
        
        wp_reset_postdata();
    }else{
        $result = "<p>Sorry, No posts yet.</p>";
    }
    
    return $result;
}

add_shortcode('brand-articles', 'display_brand_articles');