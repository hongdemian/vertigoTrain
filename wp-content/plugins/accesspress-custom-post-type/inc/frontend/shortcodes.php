<?php
defined('ABSPATH') or die("No script kiddies please!");

/*=========================================================================================================*/
/**
 * Shortcode for Service 
 */   
add_shortcode( 'ap-services', 'ap_service_short' );
function ap_service_short( $service_atts ){
    $posts_per_page = 10;
    $post_order = 'DESC';
    $pagination_option = 'no';
    $section_title = 'Our Services';
    foreach( $service_atts as $key=>$value ){
        if( $key == 'posts_per_page' ){
            $posts_per_page = $value;
        } elseif( $key == 'title' ){
            $section_title = $value;
        }elseif( $key == 'order' ){
            $post_order = $value;
        } elseif( $key == 'pagination' ){
            $pagination_option = $value;
        } else{ }
    }
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $service_args = array(
                        'post_type'=>'services',
                        'post_status'=>'publish',
                        'posts_per_page'=>$posts_per_page,
                        'order'=>$post_order,
                        'paged' => $paged
                        );
    $service_query = new WP_Query( $service_args );
?>
<div class="service_posts_wrapper">
    <h1 class="section-title"><?php echo esc_attr( $section_title ); ?></h1>
<?php
    if( $service_query->have_posts() ){
        while( $service_query->have_posts() ){
            $service_query->the_post();
            $post_id = get_the_ID();
            $service_icon = get_post_meta( $post_id, 'ap_cpt_service_icon', true );
            $service_custom_link = get_post_meta( $post_id, 'ap_cpt_service_link', true );
?>
    <div class="single-service-wrap">
        <h3 class="service-title">
            <?php if( !empty( $service_custom_link ) ){ ?>
                <a href="<?php echo esc_url( $service_custom_link );?>"><?php the_title(); ?></a>
            <?php } else { the_title(); } ?>
        </h3>
        <?php if( !empty( $service_icon ) ){ ?><span class="service-icon"><i class="fa <?php echo $service_icon ;?>"></i></span><?php } ?>
        <div class="service-excerpt"><?php the_excerpt();?></div>
    </div>
<?php
        }
     $big = 999999999; // need an unlikely integer
     $page_args = array(
    	'base'               => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
    	'format'             => '?page=%#%',
    	'total'              => $service_query->max_num_pages,
    	'current'            => max( 1, get_query_var('paged') ),
    	'show_all'           => False,
    	'end_size'           => 1,
    	'mid_size'           => 2,
    	'prev_next'          => True,
    	'prev_text'          => __('&lt;&lt; Previous'),
    	'next_text'          => __('Next &gt;&gt;'),
    	'type'               => 'plain',
    	'add_args'           => False,
    	'add_fragment'       => '',
    	'before_page_number' => '',
    	'after_page_number'  => ''
    );
    if( $pagination_option == 'yes' ){
        echo '<div class="cpt-pagination clear">'. paginate_links( $page_args ) .'</div>';    
    }
        
    } wp_reset_query();
?>  
</div>
<?php
}

/*=========================================================================================================*/
/**
 * Shortcode for Featured Product 
 */ 
 
add_shortcode( 'ap-products', 'ap_product_short' );
function ap_product_short( $products_atts ){
    $posts_per_page = 10;
    $post_order = 'DESC';
    $pagination_option = 'no';
    $section_title = 'Products';
    foreach( $products_atts as $key=>$value ){
        if( $key == 'posts_per_page' ){
            $posts_per_page = $value;
        } elseif( $key == 'title' ){
            $section_title = $value;
        } elseif( $key == 'order' ){
            $post_order = $value;
        } elseif( $key == 'pagination' ){
            $pagination_option = $value;
        } else{ }
    }
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $product_args = array(
                        'post_type'=>'products',
                        'post_status'=>'publish',
                        'posts_per_page'=>$posts_per_page,
                        'order'=>$post_order,
                        'paged' => $paged
                        );
    $product_query = new WP_Query( $product_args );
?>
<div class="product-section-wrapper">
    <h1 class="section-title"><?php echo esc_attr( $section_title ); ?></h1>
<?php
    if( $product_query->have_posts() ){
    while($product_query->have_posts()){
        $product_query->the_post();
        $post_id = get_the_ID();
        $image_id = get_post_thumbnail_id();
        $image_path = wp_get_attachment_image_src( $image_id, 'large', true );
        $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
        $product_features = get_post_meta( $post_id, 'product_feature', true );
?>
    <div class="product-container clearfix">
        <h3 class="product-title"><?php the_title();?></h3>
        <div class="signle-product-wrap">
            <?php
                if( !empty( $product_features ) ) {
                    foreach( $product_features as $feature ) {
                        $feature_name = $feature['feature_name'];
                        $feature_description = $feature['feature_description'];
                        $feature_icon = $feature['feature_icon'];
            ?>
                        <?php if( !empty( $feature_icon ) ){ ?>
                            <div class="feature-icon"><span><i class="fa <?php echo $feature_icon ;?>"></i></span></div>
                        <?php } ?>                
                        <div class="features_wrap">
                            <div class="feature-name"><?php echo esc_attr( $feature_name ) ;?></div>
                            <div class="feature-description"><?php echo $feature_description ;?></div>
                        </div>
            <?php 
                    }
                }
            ?>
        </div><!-- .signle-product-wrap -->
        <div class="single-product-image">
            <?php if( has_post_thumbnail() ){ ?>
                <figure><img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $image_alt );?>" title="<?php the_title();?>" /></figure>
            <?php } ?>
        </div>
    </div>
<?php 
            }
         $big = 999999999; // need an unlikely integer
         $page_args = array(
        	'base'               => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
        	'format'             => '?page=%#%',
        	'total'              => $product_query->max_num_pages,
        	'current'            => max( 1, get_query_var('paged') ),
        	'show_all'           => False,
        	'end_size'           => 1,
        	'mid_size'           => 2,
        	'prev_next'          => True,
        	'prev_text'          => __('&lt;&lt; Previous'),
        	'next_text'          => __('Next &gt;&gt;'),
        	'type'               => 'plain',
        	'add_args'           => False,
        	'add_fragment'       => '',
        	'before_page_number' => '',
        	'after_page_number'  => ''
        );
        if( $pagination_option == 'yes' ){
            echo '<div class="cpt-pagination clear">'. paginate_links( $page_args ) .'</div>';    
        }
        }
        wp_reset_query();   
?>
</div>
<?php    
}

/*=========================================================================================================*/
/**
 * Shortcode for Team Member 
 */ 
add_shortcode( 'ap-team', 'ap_team_short' );
function ap_team_short( $team_atts ){
    $posts_per_page = 10;
    $post_order = 'DESC';
    $pagination_option = 'no';
    $section_title = 'Team Member';
    foreach( $team_atts as $key=>$value ){
        if( $key == 'posts_per_page' ){
            $posts_per_page = $value;
        } elseif( $key == 'order' ){
            $post_order = $value;
        } elseif( $key == 'pagination' ){
            $pagination_option = $value;
        } else{ }
    }
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $team_args = array(
                        'post_type'=>'team-members',
                        'post_status'=>'publish',
                        'posts_per_page'=>$posts_per_page,
                        'order'=>$post_order,
                        'paged' => $paged
                        );
    $team_query = new WP_Query( $team_args );
?>
<div class="team-section-wrapper clearfix">
    <h1 class="section-title"><?php echo esc_attr( $section_title ); ?></h1>
<?php
    if( $team_query->have_posts() ){
        while($team_query->have_posts()){
            $team_query->the_post();
            $post_id = get_the_ID();
            $image_id = get_post_thumbnail_id();
            $image_path = wp_get_attachment_image_src( $image_id, 'medium', true );
            $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
            $member_position = get_post_meta( $post_id, 'ap_cpt_member_position', true );
            $member_fb_link = get_post_meta( $post_id, 'ap_cpt_member_fb_link', true );
            $member_tw_link = get_post_meta( $post_id, 'ap_cpt_member_tw_link', true );
            $member_gp_link = get_post_meta( $post_id, 'ap_cpt_member_gp_link', true );
            $member_lnk_link = get_post_meta( $post_id, 'ap_cpt_member_lnk_link', true );
?>
    <div class="single-member-wrap">
        <div class="member-flip-wrap">
            <?php if( has_post_thumbnail() ) { ?>
                <figure><img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php the_title(); ?>" /></figure>
            <?php } ?>
            <div class="member-info">
                <h3 class="member-name"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
                <div class="member-desgination"><?php echo esc_attr( $member_position ); ?></div>
                <div class="member-social-links">
                    <?php if( !empty( $member_fb_link ) ){ ?><span class="fb"><a href="<?php echo esc_url( $member_fb_link );?>" target="_blank"><i class="fa fa-facebook"></i></a></span><?php } ?>
                    <?php if( !empty( $member_tw_link ) ){ ?><span class="tw"><a href="<?php echo esc_url( $member_tw_link );?>" target="_blank"><i class="fa fa-twitter"></i></a></span><?php } ?>
                    <?php if( !empty( $member_gp_link ) ){ ?><span class="gp"><a href="<?php echo esc_url( $member_gp_link );?>" target="_blank"><i class="fa fa-google-plus"></i></a></span><?php } ?>
                    <?php if( !empty( $member_lnk_link ) ){ ?><span class="lnk"><a href="<?php echo esc_url( $member_lnk_link );?>" target="_blank"><i class="fa fa-linkedin"></i></a></span><?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php 
        }
        $big = 999999999; // need an unlikely integer
         $page_args = array(
        	'base'               => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
        	'format'             => '?page=%#%',
        	'total'              => $team_query->max_num_pages,
        	'current'            => max( 1, get_query_var('paged') ),
        	'show_all'           => False,
        	'end_size'           => 1,
        	'mid_size'           => 2,
        	'prev_next'          => True,
        	'prev_text'          => __('&lt;&lt; Previous'),
        	'next_text'          => __('Next &gt;&gt;'),
        	'type'               => 'plain',
        	'add_args'           => False,
        	'add_fragment'       => '',
        	'before_page_number' => '',
        	'after_page_number'  => ''
        );
        if( $pagination_option == 'yes' ){
            echo '<div class="cpt-pagination clear">'. paginate_links( $page_args ) .'</div>';    
        }
     } wp_reset_query(); 
?>
</div>
<?php
}

/*=========================================================================================================*/
/**
 * Shortcode for Testimonials
 */ 
 
add_shortcode( 'ap-testimonials', 'ap_testimonials_short' );
function ap_testimonials_short( $testimonials_atts ){
    $posts_per_page = 10;
    $post_order = 'DESC';
    $pagination_option = 'no';
    $section_title = 'Testimonials';
    foreach( $testimonials_atts as $key=>$value ){
        if( $key == 'posts_per_page' ){
            $posts_per_page = $value;
        } elseif( $key == 'title' ){
            $section_title = $value;
        } elseif( $key == 'order' ){
            $post_order = $value;
        } elseif( $key == 'pagination' ){
            $pagination_option = $value;
        } else{ }
    }
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $tesitmonials_args = array(
                        'post_type'=>'testimonials',
                        'post_status'=>'publish',
                        'posts_per_page'=>$posts_per_page,
                        'order'=>$post_order,
                        'paged' => $paged
                        );
    $tesitmonials_query = new WP_Query( $tesitmonials_args );
?>
<div class="testimonials-wrapper clearfix">
    <h1 class="section-title"><?php echo esc_attr( $section_title ); ?></h1>
<?php
    if( $tesitmonials_query->have_posts() ){
        while($tesitmonials_query->have_posts()){
            $tesitmonials_query->the_post();
            $post_id = get_the_ID();
            $image_id = get_post_thumbnail_id();
            $image_path = wp_get_attachment_image_src( $image_id, 'meidum', true );
            $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
            $author_position = get_post_meta( $post_id, 'ap_cpt_author_position', true );
            $author_company = get_post_meta( $post_id, 'ap_cpt_author_company', true );
?>
    <div class="single-testimonial-wrap clearfix">
        <div class="testi-author-image-wrap">
            <?php if( has_post_thumbnail() ) { ?>
                <figure><a href="<?php the_permalink();?>"><img src="<?php echo esc_url( $image_path[0] );?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php the_title(); ?>" /></a></figure>
            <?php } ?>
        </div>
        <div class="testi-author-article-wrap">
            <div class="testimonial-conent"><?php the_content();?></div>
            <div class="tauthor-info">
                <h4 class="testi-author-name"><?php the_title(); ?></h4>
                <?php if( !empty( $author_position ) ) { ?><span class="testi-author-desgination"><?php echo esc_attr( $author_position ); ?></span><?php } ?>
                <?php if( !empty( $author_company ) ) { ?><span class="testi-author-company"><?php echo esc_attr( $author_company ); ?></span><?php } ?>
            </div>
        </div>
    </div>
<?php 
        }
        $big = 999999999; // need an unlikely integer
         $page_args = array(
        	'base'               => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
        	'format'             => '?page=%#%',
        	'total'              => $tesitmonials_query->max_num_pages,
        	'current'            => max( 1, get_query_var('paged') ),
        	'show_all'           => False,
        	'end_size'           => 1,
        	'mid_size'           => 2,
        	'prev_next'          => True,
        	'prev_text'          => __('&lt;&lt; Previous'),
        	'next_text'          => __('Next &gt;&gt;'),
        	'type'               => 'plain',
        	'add_args'           => False,
        	'add_fragment'       => '',
        	'before_page_number' => '',
        	'after_page_number'  => ''
        );
        if( $pagination_option == 'yes' ){
            echo '<div class="cpt-pagination clear">'. paginate_links( $page_args ) .'</div>';    
        }
      }
      wp_reset_query(); 
?>
</div>
<?php
}

/*=========================================================================================================*/
/**
 * Shortcode for Clients
 */ 
 
add_shortcode( 'ap-clients', 'ap_clients_short' );
function ap_clients_short( $clients_atts ){
    $posts_per_page = 10;
    $post_order = 'DESC';
    $pagination_option = 'no';
    $section_title = 'Our Clients';
    foreach( $clients_atts as $key=>$value ){
        if( $key == 'posts_per_page' ){
            $posts_per_page = $value;
        } elseif( $key == 'title' ){
            $section_title = $value;
        } elseif( $key == 'order' ){
            $post_order = $value;
        } elseif( $key == 'pagination' ){
            $pagination_option = $value;
        } else{ }
    }
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $clients_args = array(
                        'post_type'=>'clients',
                        'post_status'=>'publish',
                        'posts_per_page'=>$posts_per_page,
                        'order'=>$post_order,
                        'paged' => $paged
                        );
    $clients_query = new WP_Query( $clients_args );
?>
<div class="clients-wrapper clearfix">
    <h1 class="section-title"><?php echo esc_attr( $section_title ); ?></h1>
<?php
    if( $clients_query->have_posts() ){
        while($clients_query->have_posts()){
            $clients_query->the_post();
            $post_id = get_the_ID();
            $image_id = get_post_thumbnail_id();
            $image_path = wp_get_attachment_image_src( $image_id, 'medium', true );
            $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
            $client_custom_url = get_post_meta( $post_id, 'ap_cpt_clients_custom_link', true );
            if( !empty( $client_custom_url ) ){
                $permalink = esc_url( $client_custom_url );
                $target = '_blank';
            } else {
                $permalink = get_the_permalink();
                $target = '_self';
            }
?>
    <div class="single-client-wrap">
        <figure>
            <a href="<?php echo $permalink ;?>" target="<?php echo esc_attr( $target ); ?>">
                <?php if( has_post_thumbnail() ) { ?>
                <img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $image_alt ) ;?>" title="<?php the_title();?>" />
                <?php } else{ the_title(); } ?>
            </a>
        </figure>
    </div>
<?php
            }
            $big = 999999999; // need an unlikely integer
            $page_args = array(
            'base'               => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
            'format'             => '?page=%#%',
            'total'              => $clients_query->max_num_pages,
            'current'            => max( 1, get_query_var('paged') ),
            'show_all'           => False,
            'end_size'           => 1,
            'mid_size'           => 2,
            'prev_next'          => True,
            'prev_text'          => __('&lt;&lt; Previous'),
            'next_text'          => __('Next &gt;&gt;'),
            'type'               => 'plain',
            'add_args'           => False,
            'add_fragment'       => '',
            'before_page_number' => '',
            'after_page_number'  => ''
        );
        if( $pagination_option == 'yes' ){
            echo '<div class="cpt-pagination clear">'. paginate_links( $page_args ) .'</div>';    
        }
        }
        wp_reset_query();
?>
</div>
<?php 
}

/*=========================================================================================================*/
/**
 * Shortcode for portfolios
 */ 
 
add_shortcode( 'ap-portfolios', 'ap_portfolios_short' );
function ap_portfolios_short( $portfolios_atts ){
    $posts_per_page = 10;
    $post_order = 'DESC';
    $pagination_option = 'no';
    $category_slug = '';
    $section_title = 'Portfolios';
    foreach( $portfolios_atts as $key=>$value ){
        if( $key == 'posts_per_page' ){
            $posts_per_page = $value;
        } elseif( $key == 'title' ){
            $section_title = $value;
        } elseif( $key == 'order' ){
            $post_order = $value;
        } elseif( $key == 'pagination' ){
            $pagination_option = $value;
        } elseif( $key == 'cat_slug' ){
            $category_slug = $value;
        } else{ }
    }    
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $portfolios_args = array(
                        'post_type'=>'portfolios',
                        'post_status'=>'publish',
                        'posts_per_page'=>$posts_per_page,
                        'order'=>$post_order,
                        'meta_or_tax' => TRUE,
                        'paged' => $paged
                        );
    if( !empty( $category_slug ) ){
        $portfolios_args['tax_query'] = array(
                                           array(
                                                'taxonomy'  => 'portfolio_category',
                                                'field'     => 'slug',
                                                'terms' => $category_slug,
                                                'operator'  => 'IN'
                                                )
                                           );
    }
    $portfolios_query = new WP_Query( $portfolios_args );
?>
<div class="projects-section-wrapper clearfix">
    <h1 class="section-title"><?php echo esc_attr( $section_title ); ?></h1>
    <?php 
        if( $portfolios_query->have_posts() ){
            while( $portfolios_query->have_posts() ){
                $portfolios_query->the_post();
                $post_id = get_the_ID();
                $image_id = get_post_thumbnail_id();
                $image_path = wp_get_attachment_image_src( $image_id, 'large', true );
                $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                $project_custom_url = get_post_meta( $post_id, 'ap_cpt_project_custom_link', true );
                if( !empty( $project_custom_url ) ){
                    $permalink = esc_url( $project_custom_url );
                    $target = '_blank';
                } else{
                    $permalink = get_the_permalink();
                    $target = '_self';
                }
?>
        <div class="signle-project-wrap">
            <figure>
                <?php if( has_post_thumbnail() ){?>
                    <a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>"><img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" title="<?php the_title(); ?>" /><?php } ?></a>
            </figure>
            <h3 class="project-title"><a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>"><?php the_title();?></a></h3>
            <div class="project-desc"><?php the_excerpt(); ?></div>            
        </div>
<?php
            }
            $big = 999999999; // need an unlikely integer
            $page_args = array(
            'base'               => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
            'format'             => '?page=%#%',
            'total'              => $portfolios_query->max_num_pages,
            'current'            => max( 1, get_query_var('paged') ),
            'show_all'           => False,
            'end_size'           => 1,
            'mid_size'           => 2,
            'prev_next'          => True,
            'prev_text'          => __('&lt;&lt; Previous'),
            'next_text'          => __('Next &gt;&gt;'),
            'type'               => 'plain',
            'add_args'           => False,
            'add_fragment'       => '',
            'before_page_number' => '',
            'after_page_number'  => ''
        );
        if( $pagination_option == 'yes' ){
            echo '<div class="cpt-pagination clear">'. paginate_links( $page_args ) .'</div>';    
        }
        }
        wp_reset_query();
    ?>
</div>
<?php
}

/*=========================================================================================================*/
/**
 * Shortcode for Price Table
 */ 
 
add_shortcode( 'ap-price-table', 'ap_price_table_short' );
function ap_price_table_short( $price_table_atts ){
    $posts_per_page = 10;
    $post_order = 'DESC';
    $pagination_option = 'no';
    $section_title = __( 'Price Table', 'ap-cpt');
    foreach( $price_table_atts as $key=>$value ){
        if( $key == 'posts_per_page' ){
            $posts_per_page = $value;
        } elseif( $key == 'title' ){
            $section_title = $value;
        } elseif( $key == 'order' ){
            $post_order = $value;
        } elseif( $key == 'pagination' ){
            $pagination_option = $value;
        } else{ }
    }
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $price_table_args = array(
                        'post_type'=>'price-table',
                        'post_status'=>'publish',
                        'posts_per_page'=>$posts_per_page,
                        'order'=>$post_order,
                        'paged' => $paged
                        );
    $price_table_query = new WP_Query( $price_table_args );
?>
<div class="price-wrapper clearfix">
    <h1 class="section-title"><?php echo esc_attr( $section_title ); ?></h1>
<?php
    if( $price_table_query->have_posts() ) {
        while( $price_table_query->have_posts() ){
            $price_table_query->the_post();
            $post_id = get_the_ID();
            $table_tag = get_post_meta( $post_id, 'table_tag', true );
            $table_icon = get_post_meta( $post_id, 'table_icon', true );
            $table_price = get_post_meta( $post_id, 'table_price', true );
            $table_price_per = get_post_meta( $post_id, 'table_price_per', true );
            $table_button_link = get_post_meta( $post_id, 'table_button_link', true );
            $table_button_text = get_post_meta( $post_id, 'table_button_text', true );
?>
        <div class="apcpt-single-price-table-wrapper-inner">
            <div class="apcpt-table-title-price-outer">
                <div class="apcpt-table-title-price">
                    <h3 class="apcpt-table-title"><?php the_title(); ?></h3>
                    <?php if ( !empty( $table_tag ) ) { ?>
                        <span class="apcpt-table-tag-outer">
                            <span class="table-tag"><?php echo esc_attr( $table_tag ); ?></span>
                        </span>
                    <?php } ?>
                    <?php if( !empty( $table_icon ) ) { ?>
                        <div class="apcpt-table-icon"><i class="fa <?php echo esc_attr( $table_icon ); ?>"></i></div>
                    <?php } ?>
                    <div class="apcpt-table-price-wrapper">
                        <?php if ( !empty( $table_price ) ) { ?>
                            <span class="apcpt-table-currencty"><?php _e( '$', 'the-monday' ); ?></span>
                            <span class="apcpt-table-price"><?php echo esc_attr( $table_price ); ?></span>
                        <?php } ?>
                        <?php if ( !empty( $table_price_per ) ) { ?><span class="apcpt-table-price-per"><?php echo esc_attr( $table_price_per ); ?></span><?php } ?>
                    </div>
                </div>
            </div>
            <div class="apcpt-table-features-wrapper">
                <?php
                $table_feature = get_post_meta( $post_id, 'table_feature', true );
                if ( !empty( $table_feature ) ) {
                    foreach ( $table_feature as $key => $value ) {
                        ?>
                        <div class="signle-feature"><?php echo esc_attr( $value['pricing_feature'] ); ?></div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="apcpt-table-button">
                <a class="apcpt-table-button button-link" href="<?php
                   if ( !empty( $table_button_link ) ) {
                       echo esc_url( $table_button_link );
                   } else {
                       '#';
                   }
                   ?>" title="<?php the_title(); ?>">
                       <?php
                       if ( !empty( $table_button_text ) ) {
                           echo esc_attr( $table_button_text );
                       }
                       ?>
                </a>
            </div>
        </div>
    
<?php
            }
            
        }
        wp_reset_query();
?>
</div>
<?php 
}

add_filter('widget_text', 'do_shortcode');