<?php
defined('ABSPATH') or die("No script kiddies please!");
$service_title = __( 'Services', 'ap-cpt' );
$service_title = apply_filters( 'service_title', $service_title );

$porduct_title = __( 'Products', 'ap-cpt' );
$porduct_title = apply_filters( 'product_title', $porduct_title );

$team_title = __( 'Team Members', 'ap-cpt' );
$team_title = apply_filters( 'team_title', $team_title );

$testimonials_title = __( 'Testimonials', 'ap-cpt' );
$testimonials_title = apply_filters( 'testimonials_title', $testimonials_title );

$client_title = __( 'Clients', 'ap-cpt' );
$client_title = apply_filters( 'client_title', $client_title );

$portfolio_title = __( 'Portfolios', 'ap-cpt' );
$portfolio_title = apply_filters( 'portfolio_title', $portfolio_title );

$price_title = __( 'Price Tables', 'ap-cpt' );
$price_title = apply_filters( 'price_title', $price_title );

/**
* Our Service post type
*/
register_post_type( 'services', 
        array( 'labels' => 
                array(
                'name' => __( $service_title , 'ap-cpt' ),
                'singular_name' => __( 'Service', 'ap-cpt' ), 
                'all_items' => __( 'All Services', 'ap-cpt' ), 
                'add_new' => __( 'Add New', 'ap-cpt' ), 
                'add_new_item' => __( 'Add New Service', 'ap-cpt' ), 
                'edit' => __( 'Edit Service', 'ap-cpt' ), 
                'edit_item' => __( 'Edit', 'ap-cpt' ), 
                'new_item' => __( 'New Post Services', 'ap-cpt' ), 
                'view_item' => __( 'View Services', 'ap-cpt' ), 
                'search_items' => __( 'Search Services', 'ap-cpt' ),
                'not_found' =>  __( 'Nothing found in the Database.', 'ap-cpt' ), 
                'not_found_in_trash' => __( 'Nothing found in Trash', 'ap-cpt' ), 
                'parent_item_colon' => ''
                ), 
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 22,
        'menu_icon' => 'dashicons-clipboard',
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt')
    ) 
); 

/**
* Featured Products post type
*/
register_post_type( 'products', 
        array( 'labels' => 
                array(
                'name' => __( $porduct_title, 'ap-cpt' ),
                'singular_name' => __( 'Product', 'ap-cpt' ), 
                'all_items' => __( 'All Products', 'ap-cpt' ), 
                'add_new' => __( 'Add New', 'ap-cpt' ), 
                'add_new_item' => __( 'Add New Product', 'ap-cpt' ), 
                'edit' => __( 'Edit Product', 'ap-cpt' ), 
                'edit_item' => __( 'Edit', 'ap-cpt' ), 
                'new_item' => __( 'New Post Product', 'ap-cpt' ), 
                'view_item' => __( 'View Products', 'ap-cpt' ), 
                'search_items' => __( 'Search Products', 'ap-cpt' ),
                'not_found' =>  __( 'Nothing found in the Database.', 'ap-cpt' ), 
                'not_found_in_trash' => __( 'Nothing found in Trash', 'ap-cpt' ), 
                'parent_item_colon' => ''
                ), 
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 23,
        'menu_icon' => 'dashicons-cart',
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title', 'thumbnail')
    ) 
);

/**
* Our Team post type
*/
register_post_type( 'team-members', 
        array( 'labels' => 
                array(
                'name' => __( $team_title, 'ap-cpt' ),
                'singular_name' => __( 'Team Member', 'ap-cpt' ), 
                'all_items' => __( 'All Team Members', 'ap-cpt' ), 
                'add_new' => __( 'Add New', 'ap-cpt' ), 
                'add_new_item' => __( 'Add New Member', 'ap-cpt' ), 
                'edit' => __( 'Edit Member', 'ap-cpt' ), 
                'edit_item' => __( 'Edit', 'ap-cpt' ), 
                'new_item' => __( 'New Post Member', 'ap-cpt' ), 
                'view_item' => __( 'View Members', 'ap-cpt' ), 
                'search_items' => __( 'Search Members', 'ap-cpt' ),
                'not_found' =>  __( 'Nothing found in the Database.', 'ap-cpt' ), 
                'not_found_in_trash' => __( 'Nothing found in Trash', 'ap-cpt' ), 
                'parent_item_colon' => ''
                ), 
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 24,
        'menu_icon' => 'dashicons-groups',
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'thumbnail')
    ) 
);

/**
* Testimonials post type
*/
register_post_type( 'testimonials', 
        array( 'labels' => 
                array(
                'name' => __( $testimonials_title, 'ap-cpt' ),
                'singular_name' => __( 'Testimonial', 'ap-cpt' ), 
                'all_items' => __( 'All Testimonials', 'ap-cpt' ), 
                'add_new' => __( 'Add New', 'ap-cpt' ), 
                'add_new_item' => __( 'Add New Testimonial', 'ap-cpt' ), 
                'edit' => __( 'Edit Testimonial', 'ap-cpt' ), 
                'edit_item' => __( 'Edit', 'ap-cpt' ), 
                'new_item' => __( 'New Post Testimonial', 'ap-cpt' ), 
                'view_item' => __( 'View Testimonials', 'ap-cpt' ), 
                'search_items' => __( 'Search Testimonials', 'ap-cpt' ),
                'not_found' =>  __( 'Nothing found in the Database.', 'ap-cpt' ), 
                'not_found_in_trash' => __( 'Nothing found in Trash', 'ap-cpt' ), 
                'parent_item_colon' => ''
                ), 
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 25,
        'menu_icon' => 'dashicons-businessman',
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'thumbnail')
    ) 
);

/**
* Clients post type
*/
register_post_type( 'clients', 
        array( 'labels' => 
                array(
                'name' => __( $client_title, 'ap-cpt' ),
                'singular_name' => __( 'Client', 'ap-cpt' ), 
                'all_items' => __( 'All Clients', 'ap-cpt' ), 
                'add_new' => __( 'Add New', 'ap-cpt' ), 
                'add_new_item' => __( 'Add New Client', 'ap-cpt' ), 
                'edit' => __( 'Edit Client', 'ap-cpt' ), 
                'edit_item' => __( 'Edit', 'ap-cpt' ), 
                'new_item' => __( 'New Post Client', 'ap-cpt' ), 
                'view_item' => __( 'View Clients', 'ap-cpt' ), 
                'search_items' => __( 'Search Clients', 'ap-cpt' ),
                'not_found' =>  __( 'Nothing found in the Database.', 'ap-cpt' ), 
                'not_found_in_trash' => __( 'Nothing found in Trash', 'ap-cpt' ), 
                'parent_item_colon' => ''
                ), 
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 26,
        'menu_icon' => 'dashicons-universal-access',
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'thumbnail')
    ) 
);

/**
* Portfolio post type
*/
register_post_type( 'portfolios', 
        array( 'labels' => 
                array(
                'name' => __( $portfolio_title, 'ap-cpt' ),
                'singular_name' => __( 'Portfolio', 'ap-cpt' ), 
                'all_items' => __( 'All Portfolios', 'ap-cpt' ), 
                'add_new' => __( 'Add New', 'ap-cpt' ), 
                'add_new_item' => __( 'Add New Portfolio', 'ap-cpt' ), 
                'edit' => __( 'Edit Portfolio', 'ap-cpt' ), 
                'edit_item' => __( 'Edit', 'ap-cpt' ), 
                'new_item' => __( 'New Post Portfolio', 'ap-cpt' ), 
                'view_item' => __( 'View Portfolios', 'ap-cpt' ), 
                'search_items' => __( 'Search Portfolios', 'ap-cpt' ),
                'not_found' =>  __( 'Nothing found in the Database.', 'ap-cpt' ), 
                'not_found_in_trash' => __( 'Nothing found in Trash', 'ap-cpt' ), 
                'parent_item_colon' => ''
                ), 
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 27,
        'menu_icon' => 'dashicons-portfolio',
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'thumbnail')
    ) 
);
// now let's add custom categories for Galleries
register_taxonomy( 'portfolio_category', 
        array('portfolios'),
                array(
                    'hierarchical' => true,
                    'labels' => array(
                        'name' => __( 'Categories', 'ap-cpt' ), 
                        'singular_name' => __( 'Category', 'ap-cpt' ), 
                        'search_items' =>  __( 'Search Category', 'ap-cpt' ), 
                        'all_items' => __( 'All Category', 'ap-cpt' ),
                        'parent_item' => __( 'Parent Category', 'ap-cpt' ), 
                        'parent_item_colon' => __( 'Parent Category', 'ap-cpt' ), 
                        'edit_item' => __( 'Edit Category', 'ap-cpt' ), 
                        'update_item' => __( 'Update Category', 'ap-cpt' ), 
                        'add_new_item' => __( 'Add New Category', 'ap-cpt' ),
                        )
                    )
                );
                
    add_filter("manage_edit-portfolios_columns", "portfolios_edit_columns");
    function portfolios_edit_columns( $columns ){
     $columns = array(
       "cb" => "<input type='checkbox' />",
       "title" => "Title",
       "taxonomy-portfolio_category"  => 'Categories',
       "project_thumb" =>'Thumbnail',
       "date" => "Date",
     ); 
     return $columns;
    }
    
    add_action("manage_posts_custom_column",  "portfolios_custom_columns");
    function portfolios_custom_columns( $column ){
     global $post;
    
     switch ( $column ) {
       case "project_thumb":
         the_post_thumbnail( array(72, 72) );
         break;
     }
}

/**
* Pricing Table
*/
register_post_type( 'price-table', 
        array( 'labels' => 
                array(
                'name' => __( $price_title , 'ap-cpt' ),
                'singular_name' => __( 'Price Table', 'ap-cpt' ), 
                'all_items' => __( 'All Price Tables', 'ap-cpt' ), 
                'add_new' => __( 'Add Price Table', 'ap-cpt' ), 
                'add_new_item' => __( 'Add New Price Table', 'ap-cpt' ), 
                'edit' => __( 'Edit Price Table', 'ap-cpt' ), 
                'edit_item' => __( 'Edit', 'ap-cpt' ), 
                'new_item' => __( 'New Post Price Tables', 'ap-cpt' ), 
                'view_item' => __( 'View Price Tables', 'ap-cpt' ), 
                'search_items' => __( 'Search Price Tables', 'ap-cpt' ),
                'not_found' =>  __( 'Nothing found in the Database.', 'ap-cpt' ), 
                'not_found_in_trash' => __( 'Nothing found in Trash', 'ap-cpt' ), 
                'parent_item_colon' => ''
                ), 
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 28,
        'menu_icon' => 'dashicons-index-card',
        'rewrite' => true,
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title')
    ) 
); 