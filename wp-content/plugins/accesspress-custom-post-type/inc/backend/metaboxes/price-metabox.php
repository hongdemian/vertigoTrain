<?php
defined('ABSPATH') or die("No script kiddies please!");

/**
 * Add Pricing table's features 
 */

add_action('add_meta_boxes', 'ap_cpt_table_features_field');
function  ap_cpt_table_features_field() {
    add_meta_box(
         'ap_cpt_table_features', // $id
         __( 'Table Features', 'ap-cpt' ), // $title
         'ap_cpt_table_features_callback', // $callback
         'price-table', // $page
         'normal', // $context
         'high'
    ); // $priority
}

if( ! function_exists( 'ap_cpt_table_features_callback' ) ):
function ap_cpt_table_features_callback() {
    global $post ;
    wp_nonce_field( basename( __FILE__ ), 'ap_cpt_table_features_nonce' );
    
?>
    <div class="features-meta-section-wrapper">
        <div><h3><?php _e( 'Add Table Features', 'ap-cpt' )?></h3></div>
        <div class="table-features-wrapper">
            <?php
                $table_feature = get_post_meta( $post->ID, 'table_feature', true ); 
                $table_feature_count = get_post_meta( $post->ID, 'table_feature_count', true );
                $t_count = 0;
                if(!empty($table_feature)){
                foreach ($table_feature as $key => $value) {
                    $t_count++;
            ?>
                <div class="single-feature">
                    <div class="single-section-title clearfix">
                        <h3 class="feature-title"><?php _e( "Feature $t_count : ", 'ap-cpt' );?></h3>
                        <div class="delete-table-feature"><a href="javascript:void(0)" class="delete-feature button">Delete Feature</a></div>
                        <div class="feature-inputfield">
                            <input type="text" name="table_features[<?php echo $t_count ;?>][pricing_feature]" value="<?php echo esc_attr( $value[ 'pricing_feature' ] ); ?>" />
                        </div>
                    </div>
                </div>
            <?php
                }
                }
            ?>
        </div>
        <input id="table_features_count" type="hidden" name="table_feature_count" value="<?php echo $t_count; ?>" />
        <span class="delete-button table-features"><a href="javascript:void(0)" class="docopy-table-feature button">Add Table Feature</a></span>
    </div>
<?php
}
endif;

function ap_cpt_table_fetures_save_post( $post_id ) { 
    global  $post;
    
    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'ap_cpt_table_features_nonce' ] ) || !wp_verify_nonce( $_POST[ 'ap_cpt_table_features_nonce' ], basename( __FILE__ ) ) )
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
    
    $table_pricing_feature = get_post_meta( $post->ID, 'table_features_pricing_feature', true );
    $table_feature_count = get_post_meta( $post->ID, 'table_feature_count', true );
    
    $stz_table_pricing_features =  $_POST['table_features'];
    
    $stz_table_feature_count = sanitize_text_field( $_POST[ 'table_feature_count' ] );
    
    update_post_meta($post_id, 'table_feature', $stz_table_pricing_features);
    
    //update data for Table features
    if ( $stz_table_feature_count && '' == $stz_table_feature_count ){
        add_post_meta( $post_id, 'table_feature_count', $stz_table_feature_count );
    }elseif ($stz_table_feature_count && $stz_table_feature_count != $table_pricing_feature) {  
        update_post_meta($post_id, 'table_feature_count', $stz_table_feature_count);  
    } elseif ('' == $stz_table_feature_count && $table_pricing_feature) {  
        delete_post_meta($post_id,'table_feature_count');  
    }
}
add_action('save_post', 'ap_cpt_table_fetures_save_post');

/**
 * Meta box for Price table post type 
 */

add_action('add_meta_boxes', 'ap_cpt_table_price_field');
function  ap_cpt_table_price_field() {
    add_meta_box(
         'ap_cpt_table_price', // $id
         __( 'Table Price', 'ap-cpt' ), // $title
         'ap_cpt_table_price_callback', // $callback
         'price-table', // $page
         'normal', // $context
         'high'
    ); // $priority
}

if( !function_exists( 'ap_cpt_table_price_callback' ) ):
function ap_cpt_table_price_callback() {
    global $post ;
    wp_nonce_field( basename( __FILE__ ), 'ap_cpt_table_price_nonce' );
    $table_price = get_post_meta( $post->ID, 'table_price', true );
    $table_price_per = get_post_meta( $post->ID, 'table_price_per', true );
?>
    <div class="price-meta-section-wrapper">
        <div><h3><?php _e( 'Add Table Price', 'ap-cpt' );?></h3></div>
        <div class="table-price-wrapper">
            <div class="sigle-price clearfix">
                <label class="price-title" for="pt-<?php echo $post->ID ;?>"><?php _e( 'Table Price ( $ )', 'ap-cpt' );?></label>
                <span class="lable-seperator"> : </span>
                <input type="number" id="pt-<?php echo $post->ID ;?>" name="table_price" value="<?php echo $table_price ; ?>" />
            </div>
            <div class="single-priceper clearfix">
                <label class="priceper-title" for="ppt-<?php echo $post->ID ;?>"><?php _e( 'Table Price per', 'ap-cpt' );?></label>
                <span class="lable-seperator"> : </span>
                <input type="text" id="ppt-<?php echo $post->ID ;?>" name="table_price_per" value="<?php echo $table_price_per; ?>" />
            </div>
        </div>
    </div>
<?php
}
endif;

function ap_cpt_table_price_save_post( $post_id ) { 
    global  $post;
    
    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'ap_cpt_table_price_nonce' ] ) || !wp_verify_nonce( $_POST[ 'ap_cpt_table_price_nonce' ], basename( __FILE__ ) ) )
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
    
    $table_price = get_post_meta( $post->ID, 'table_price', true );
    $table_price_per = get_post_meta( $post->ID, 'table_price_per', true );
    
    $stz_table_price = sanitize_text_field( $_POST[ 'table_price' ] );
    $stz_table_price_per = sanitize_text_field( $_POST[ 'table_price_per' ] );
    
    //update data for Table Price
    if ( $stz_table_price && '' == $stz_table_price ){
        add_post_meta( $post_id, 'table_price', $stz_table_price );
    }elseif ($stz_table_price && $stz_table_price != $table_price) {  
        update_post_meta($post_id, 'table_price', $stz_table_price);  
    } elseif ('' == $stz_table_price && $table_price) {  
        delete_post_meta($post_id,'table_price');  
    }
    
    //update data for Table Price Per
    if ( $stz_table_price_per && '' == $stz_table_price_per ){
        add_post_meta( $post_id, 'table_price_per', $stz_table_price_per );
    }elseif ($stz_table_price_per && $stz_table_price_per != $table_price_per) {  
        update_post_meta($post_id, 'table_price_per', $stz_table_price_per);  
    } elseif ('' == $stz_table_price_per && $table_price_per) {  
        delete_post_meta($post_id,'table_price_per');  
    }
}
add_action('save_post', 'ap_cpt_table_price_save_post');

/**
 * Pricing table extra fields 
 */

add_action('add_meta_boxes', 'ap_cpt_table_extra_field');
function  ap_cpt_table_extra_field() {
    add_meta_box(
         'ap_cpt_table_extra', // $id
         __( 'Table Extra Fields', 'ap-cpt' ), // $title
         'ap_cpt_table_extra_callback', // $callback
         'price-table', // $page
         'normal', // $context
         'high'
    ); // $priority
}
if( !function_exists( 'ap_cpt_table_extra_callback' ) ):
function ap_cpt_table_extra_callback() {
    global $post ;
    wp_nonce_field( basename( __FILE__ ), 'ap_cpt_table_extra_nonce' );
    $ap_cpt_price_table_icon = get_post_meta( $post->ID, 'table_icon', true );
    $table_tag = get_post_meta( $post->ID, 'table_tag', true );
    $table_button_link = get_post_meta( $post->ID, 'table_button_link', true );
    $table_button_text = get_post_meta( $post->ID, 'table_button_text', true );
?>
    <div class="table-extra-section-wrapper">
        <div><h3><?php _e( 'Add Table Extra Fields', 'ap-cpt' );?></h3></div>
        <div class="table-extra-wrapper">
            <div class="single-tag clearfix">
                <label class="extra-title" for="et-<?php echo $post->ID ;?>"><?php _e( 'Table Tag', 'ap-cpt' );?></label>
                <span class="lable-seperator"> : </span>
                <input type="text" id="et-<?php echo $post->ID ;?>" name="table_tag" value="<?php echo $table_tag ; ?>" />
            </div><!-- .single-button-text -->
            <div class="single-button-link clearfix">
                <label class="extra-title" for="ebl-<?php echo $post->ID ;?>"><?php _e( 'Button link', 'ap-cpt' );?></label>
                <span class="lable-seperator"> : </span>
                <input type="text" id="ebl-<?php echo $post->ID ;?>" name="table_button_link" value="<?php echo $table_button_link; ?>" />
            </div><!-- .single-button-text -->
            <div class="single-button-text clearfix">
                <label class="extra-title" for="ebt-<?php echo $post->ID ;?>"><?php _e( 'Button text', 'ap-cpt' );?></label>
                <span class="lable-seperator"> : </span>
                <input type="text" id="ebt-<?php echo $post->ID ;?>" name="table_button_text" value="<?php echo $table_button_text; ?>" />
            </div><!-- .single-button-text -->
            <div class="single-button-text clearfix">
                <div class="table-single-field">
                    <h4><span class="section-title"><?php _e( 'Price Table Icon', 'ap-cpt' ); ?></span></h4>
                    <span class="section-desc"><em><?php _e( 'Choose icon from list', 'ap-cpt' ); ?></em></span>
                </div>
                <div class="ap-cpt-icons-wrapper">
                    <div class="ap-cpt-select-icon">
                        <?php 
                            if( !empty( $ap_cpt_price_table_icon ) ) {
                                echo '<li class="fa '.$ap_cpt_price_table_icon.'"></li>';
                            }
                        ?>
                    </div>
                    <input class="hidden-icon-input" name="table_icon" type="hidden" id="ap_cpt_price_table_icon_field" value="<?php echo $ap_cpt_price_table_icon; ?>" />
                    <div class="ap-cpt-icon-chooser">
                        <ul class="ap-cpt-icons">
                            <?php 
                                $icon_class_array = CPT_Class::ap_cpt_fontawesome_icons();
                                foreach( $icon_class_array as $count => $class ) {
                                    if( $ap_cpt_price_table_icon == $class ) {
                                        echo '<li class="selected"><i class="fa '. $class .'"></i></li>';
                                    } else {
                                        echo '<li><i class="fa '. $class .'"></i></li>';
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div><!-- .single-button-text -->
                </div><!-- .ap-cpt-icons-wrapper -->
            <!-- <div class="single-tag clearfix">
                <label class="extra-title" for="et-<?php echo $post->ID ;?>"><?php _e( 'Table icon', 'ap-cpt' );?></label>
                <span class="lable-seperator"> : </span>
                <input type="text" id="et-<?php echo $post->ID ;?>" name="table_icon" value="<?php echo $table_icon ; ?>" />
                <em><?php _e( 'Add font awesome icon', 'ap-cpt' );?></em>
            </div> -->
        </div>
    </div>
<?php
}
endif;

function ap_cpt_table_extra_save_post( $post_id ) { 
    global  $post;
    
    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'ap_cpt_table_extra_nonce' ] ) || !wp_verify_nonce( $_POST[ 'ap_cpt_table_extra_nonce' ], basename( __FILE__ ) ) )
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
    
    $table_icon = get_post_meta( $post->ID, 'table_tag', true );
    $table_tag = get_post_meta( $post->ID, 'table_tag', true );
    $table_button_text = get_post_meta( $post->ID, 'table_button_text', true );
    $table_button_link = get_post_meta( $post->ID, 'table_button_link', true );
    
    $stz_table_icon = sanitize_text_field( $_POST[ 'table_icon' ] );
    $stz_table_tag = sanitize_text_field( $_POST[ 'table_tag' ] );
    $stz_table_button_text = sanitize_text_field( $_POST[ 'table_button_text' ] );
    $stz_table_button_link = esc_url( $_POST[ 'table_button_link' ] );
    
    //update data for Table icon
    if ( $stz_table_icon && '' == $stz_table_icon ){
        add_post_meta( $post_id, 'table_icon', $stz_table_icon );
    }elseif ($stz_table_icon && $stz_table_icon != $table_icon) {  
        update_post_meta($post_id, 'table_icon', $stz_table_icon);  
    } elseif ('' == $stz_table_icon && $table_icon) {  
        delete_post_meta($post_id,'table_icon');  
    }

    //update data for Table tag
    if ( $stz_table_tag && '' == $stz_table_tag ){
        add_post_meta( $post_id, 'table_tag', $stz_table_tag );
    }elseif ($stz_table_tag && $stz_table_tag != $table_tag) {  
        update_post_meta($post_id, 'table_tag', $stz_table_tag);  
    } elseif ('' == $stz_table_tag && $table_tag) {  
        delete_post_meta($post_id,'table_tag');  
    }
    
    //update data for Table button text
    if ( $stz_table_button_text && '' == $stz_table_button_text ){
        add_post_meta( $post_id, 'table_button_text', $stz_table_button_text );
    }elseif ($stz_table_button_text && $stz_table_button_text != $table_button_text) {  
        update_post_meta($post_id, 'table_button_text', $stz_table_button_text);  
    } elseif ('' == $stz_table_button_text && $table_button_text) {  
        delete_post_meta($post_id,'table_button_text');  
    }
    
    //update data for Table button Link
    if ( $stz_table_button_link && '' == $stz_table_button_link ){
        add_post_meta( $post_id, 'table_button_link', $stz_table_button_link );
    }elseif ($stz_table_button_link && $stz_table_button_link != $table_button_link) {  
        update_post_meta($post_id, 'table_button_link', $stz_table_button_link);  
    } elseif ('' == $stz_table_button_link && $table_button_link) {  
        delete_post_meta($post_id,'table_button_link');  
    }
}
add_action('save_post', 'ap_cpt_table_extra_save_post');