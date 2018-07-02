<?php
defined('ABSPATH') or die("No script kiddies please!");
/**
 * Meta box for Testimonials post type 
 */
 
 add_action('add_meta_boxes', 'ap_cpt_testimonials_author_info_field');
function  ap_cpt_testimonials_author_info_field() {
    add_meta_box(
         'ap_cpt_testimonial_author_info', // $id
         __( "author Info", 'ap-cpt' ), // $title
         'ap_cpt_testimonials_author_info_callback', // $callback
         'testimonials', // $page
         'normal', // $context
         'high'
    ); // $priority
}
if( ! function_exists( 'ap_cpt_testimonials_author_info_callback' ) ):
function ap_cpt_testimonials_author_info_callback() {
    global $post ;
    wp_nonce_field( basename( __FILE__ ), 'ap_cpt_testimonials_author_info_nonce' );
    $ap_cpt_author_position = get_post_meta( $post->ID, 'ap_cpt_author_position', true );
    $ap_cpt_author_company = get_post_meta( $post->ID, 'ap_cpt_author_company', true );
?>
    <div class="author-info-wrapper">
        <div class="single-field-wrap">
            <h4><span class="section-title"><?php _e( 'Designation', 'ap-cpt' );?></span></h4>
            <span class="section-inputfield"><input type="text" name="ap_cpt_author_position" value="<?php if( !empty( $ap_cpt_author_position ) ){ echo $ap_cpt_author_position ; }?>" /></span>
        </div>
        <div class="single-field-wrap">
            <h4><span class="section-title"><?php _e( 'Company', 'ap-cpt' );?></span></h4>
            <span class="section-inputfield"><input type="text" name="ap_cpt_author_company" value="<?php if( !empty( $ap_cpt_author_company ) ){ echo $ap_cpt_author_company ; }?>" /></span>
        </div>
    </div>
<?php
}
endif;
function ap_cpt_testimonials_info_save_post( $post_id ) { 
    global  $post;
    
    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'ap_cpt_testimonials_author_info_nonce' ] ) || !wp_verify_nonce( $_POST[ 'ap_cpt_testimonials_author_info_nonce' ], basename( __FILE__ ) ) )
        return;

    // Stop WP from clearing custom fields on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
        return;
        
    if ( 'page' == $_POST[ 'post_type' ] ) {  
        if (!current_user_can( 'edit_page', $post_id ) )  
            return $post_id;  
    } elseif (!current_user_can( 'edit_post', $post_id ) ) {  
            return $post_id;  
    }
    
    $ap_cpt_author_position = get_post_meta( $post->ID, 'ap_cpt_author_position', true );
    $stz_author_position = sanitize_text_field($_POST['ap_cpt_author_position']);
    
    $ap_cpt_author_company = get_post_meta( $post->ID, 'ap_cpt_author_company', true );
    $stz_author_company = sanitize_text_field($_POST['ap_cpt_author_company']);
    
    //update author's position
    if ( $stz_author_position && '' == $stz_author_position ){
        add_post_meta( $post_id, 'ap_cpt_author_position', $stz_author_position );
    }elseif ($stz_author_position && $stz_author_position != $ap_cpt_author_position) {  
        update_post_meta($post_id, 'ap_cpt_author_position', $stz_author_position);  
    } elseif ('' == $stz_author_position && $ap_cpt_author_position) {  
        delete_post_meta($post_id,'ap_cpt_author_position', $ap_cpt_author_position);  
    }
    
    //update author's company
    if ( $stz_author_company && '' == $stz_author_company ){
        add_post_meta( $post_id, 'ap_cpt_author_company', $stz_author_company );
    }elseif ($stz_author_company && $stz_author_company != $ap_cpt_author_company) {  
        update_post_meta($post_id, 'ap_cpt_author_company', $stz_author_company);  
    } elseif ('' == $stz_author_company && $ap_cpt_author_company) {  
        delete_post_meta($post_id,'ap_cpt_author_company', $ap_cpt_author_company);  
    }
    
}
add_action('save_post', 'ap_cpt_testimonials_info_save_post');