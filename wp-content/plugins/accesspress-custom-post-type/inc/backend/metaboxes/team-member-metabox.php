<?php
defined('ABSPATH') or die("No script kiddies please!");

/**
 * Meta box for Team Member post type 
 */

add_action('add_meta_boxes', 'ap_cpt_members_info_field');
function  ap_cpt_members_info_field() {
    add_meta_box(
         'ap_cpt_members_info', // $id
         __( "Member's Info", 'ap-cpt' ), // $title
         'ap_cpt_members_info_callback', // $callback
         'team-members', // $page
         'normal', // $context
         'high'
    ); // $priority
}

if( ! function_exists( 'ap_cpt_members_info_callback' ) ):
function ap_cpt_members_info_callback() {
    global $post ;
    wp_nonce_field( basename( __FILE__ ), 'ap_cpt_members_info_nonce' );
    $ap_cpt_member_position = get_post_meta( $post->ID, 'ap_cpt_member_position', true );
    $ap_cpt_member_fb_link = get_post_meta( $post->ID, 'ap_cpt_member_fb_link', true );
    $ap_cpt_member_tw_link = get_post_meta( $post->ID, 'ap_cpt_member_tw_link', true );
    $ap_cpt_member_gp_link = get_post_meta( $post->ID, 'ap_cpt_member_gp_link', true );
    $ap_cpt_member_lnk_link = get_post_meta( $post->ID, 'ap_cpt_member_lnk_link', true );
?>
    <div class="member-info-wrapper">
        <div class="single-field-wrap">
            <h4><span class="section-title"><?php _e( 'Position', 'ap-cpt' );?></span></h4>
            <span class="section-inputfield"><input type="text" name="ap_cpt_member_position" value="<?php if( !empty( $ap_cpt_member_position ) ){ echo $ap_cpt_member_position ; }?>" /></span>
        </div>
        <div class="single-field-wrap">
            <h4><span class="section-title"><?php _e( 'Facebook', 'ap-cpt' );?></span></h4>
            <span class="section-inputfield"><input type="text" name="ap_cpt_member_fb_link" value="<?php if( !empty( $ap_cpt_member_fb_link ) ){ echo $ap_cpt_member_fb_link ; }?>" /></span>
        </div>
        <div class="single-field-wrap">
            <h4><span class="section-title"><?php _e( 'Twitter', 'ap-cpt' );?></span></h4>
            <span class="section-inputfield"><input type="text" name="ap_cpt_member_tw_link" value="<?php if( !empty( $ap_cpt_member_tw_link ) ){ echo $ap_cpt_member_tw_link ; }?>" /></span>
        </div>
        <div class="single-field-wrap">
            <h4><span class="section-title"><?php _e( 'Google Plus', 'ap-cpt' );?></span></h4>
            <span class="section-inputfield"><input type="text" name="ap_cpt_member_gp_link" value="<?php if( !empty( $ap_cpt_member_gp_link ) ){ echo $ap_cpt_member_gp_link ; }?>" /></span>
        </div>
        <div class="single-field-wrap">
            <h4><span class="section-title"><?php _e( 'LinkedIn', 'ap-cpt' );?></span></h4>
            <span class="section-inputfield"><input type="text" name="ap_cpt_member_lnk_link" value="<?php if( !empty( $ap_cpt_member_lnk_link ) ){ echo $ap_cpt_member_lnk_link ; }?>" /></span>
        </div>
    </div>
<?php
}
endif;
function ap_cpt_members_info_save_post( $post_id ) { 
    global  $post;
    
    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'ap_cpt_members_info_nonce' ] ) || !wp_verify_nonce( $_POST[ 'ap_cpt_members_info_nonce' ], basename( __FILE__ ) ) )
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
    
    $ap_cpt_member_position = get_post_meta( $post->ID, 'ap_cpt_member_position', true );
    $stz_member_position = sanitize_text_field($_POST['ap_cpt_member_position']);
    
    $ap_cpt_member_fb_link = get_post_meta( $post->ID, 'ap_cpt_member_fb_link', true );
    $stz_member_fb_link = esc_url($_POST['ap_cpt_member_fb_link']);
    
    $ap_cpt_member_tw_link = get_post_meta( $post->ID, 'ap_cpt_member_tw_link', true );
    $stz_member_tw_link = esc_url($_POST['ap_cpt_member_tw_link']);
    
    $ap_cpt_member_gp_link = get_post_meta( $post->ID, 'ap_cpt_member_gp_link', true );
    $stz_member_gp_link = esc_url($_POST['ap_cpt_member_gp_link']);
    
    $ap_cpt_member_lnk_link = get_post_meta( $post->ID, 'ap_cpt_member_lnk_link', true );
    $stz_member_lnk_link = esc_url($_POST['ap_cpt_member_lnk_link']);
    
    //update member's position
    if ( $stz_member_position && '' == $stz_member_position ){
        add_post_meta( $post_id, 'ap_cpt_member_position', $stz_member_position );
    }elseif ($stz_member_position && $stz_member_position != $ap_cpt_member_position) {  
        update_post_meta($post_id, 'ap_cpt_member_position', $stz_member_position);  
    } elseif ('' == $stz_member_position && $ap_cpt_member_position) {  
        delete_post_meta($post_id,'ap_cpt_member_position', $ap_cpt_member_position);  
    }
    
    //update member's facebook link
    if ( $stz_member_fb_link && '' == $stz_member_fb_link ){
        add_post_meta( $post_id, 'ap_cpt_member_fb_link', $stz_member_fb_link );
    }elseif ($stz_member_fb_link && $stz_member_fb_link != $ap_cpt_member_fb_link) {  
        update_post_meta($post_id, 'ap_cpt_member_fb_link', $stz_member_fb_link);  
    } elseif ('' == $stz_member_fb_link && $ap_cpt_member_fb_link) {  
        delete_post_meta($post_id,'ap_cpt_member_fb_link', $ap_cpt_member_fb_link);  
    }
    
    //update member's twitter link
    if ( $stz_member_tw_link && '' == $stz_member_tw_link ){
        add_post_meta( $post_id, 'ap_cpt_member_tw_link', $stz_member_tw_link );
    }elseif ($stz_member_tw_link && $stz_member_tw_link != $ap_cpt_member_tw_link) {  
        update_post_meta($post_id, 'ap_cpt_member_tw_link', $stz_member_tw_link);  
    } elseif ('' == $stz_member_tw_link && $ap_cpt_member_tw_link) {  
        delete_post_meta($post_id,'ap_cpt_member_tw_link', $ap_cpt_member_tw_link);  
    }
    
    //update member's google plus link
    if ( $stz_member_gp_link && '' == $stz_member_gp_link ){
        add_post_meta( $post_id, 'ap_cpt_member_gp_link', $stz_member_gp_link );
    }elseif ($stz_member_gp_link && $stz_member_gp_link != $ap_cpt_member_gp_link) {  
        update_post_meta($post_id, 'ap_cpt_member_gp_link', $stz_member_gp_link);  
    } elseif ('' == $stz_member_gp_link && $ap_cpt_member_gp_link) {  
        delete_post_meta($post_id,'ap_cpt_member_gp_link', $ap_cpt_member_gp_link);  
    }
    
    //update member's LinkedIn link
    if ( $stz_member_lnk_link && '' == $stz_member_lnk_link ){
        add_post_meta( $post_id, 'ap_cpt_member_lnk_link', $stz_member_lnk_link );
    }elseif ($stz_member_lnk_link && $stz_member_lnk_link != $ap_cpt_member_lnk_link) {  
        update_post_meta($post_id, 'ap_cpt_member_lnk_link', $stz_member_lnk_link);  
    } elseif ('' == $stz_member_lnk_link && $ap_cpt_member_lnk_link) {  
        delete_post_meta($post_id,'ap_cpt_member_lnk_link', $ap_cpt_member_lnk_link);  
    }
    
}
add_action('save_post', 'ap_cpt_members_info_save_post');