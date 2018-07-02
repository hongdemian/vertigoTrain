<?php
defined('ABSPATH') or die("No script kiddies please!");

/**
 * Meta box for Featured Product post type 
 */
 
add_action('add_meta_boxes', 'ap_cpt_product_features_field');
function  ap_cpt_product_features_field() {
    add_meta_box(
         'ap_cpt_product_features', // $id
         __( 'Product Features', 'ap-cpt' ), // $title
         'ap_cpt_product_features_callback', // $callback
         'products', // $page
         'normal', // $context
         'high'
    ); // $priority
}

if( ! function_exists( 'ap_cpt_product_features_callback' ) ):
function ap_cpt_product_features_callback() {
    global $post ;
    wp_nonce_field( basename( __FILE__ ), 'ap_cpt_product_features_nonce' );
    
?>
    <div class="product-meta-section-wrapper">
        <div><h3><?php _e( 'Add Product Features', 'ap-cpt' )?></h3></div>
        <div class="product-features-wrapper">
            <?php
                $product_feature = get_post_meta( $post->ID, 'product_feature', true ); 
                $product_feature_count = get_post_meta( $post->ID, 'product_feature_count', true );
                $f_count = 0;
                if(!empty($product_feature)){
                foreach ($product_feature as $key => $value) {
                    $f_count++;
            ?>
            <div class="single-feature">
                <div class="single-section-wrap clearfix">
                    <h3 class="wrapper-title"><?php _e( "Product Feature $f_count", 'ap-cpt' );?></h3>
                    <span class="delete-select-feature"><a href="javascript:void(0)" class="delete-single-feature button">Delete Feature</a></span>
                </div>
                <div class="features-single-field">
                    <h4><span class="section-title"><?php _e( 'Feature Name', 'ap-cpt' );?></span></h4>
                    <span class="section-inputfield"><input type="text" name="product_features[<?php echo $f_count ;?>][feature_name]" value="<?php echo $value[ 'feature_name' ]; ?>" /></span>
                    <h4><span class="section-title"><?php _e( 'Feature Description', 'ap-cpt' );?></span></h4>
                    <span class="section-textarea"><textarea name="product_features[<?php echo $f_count ;?>][feature_description]" rows="7" cols="60"><?php echo $value[ 'feature_description' ]; ?></textarea></span>
                    <h4><span class="section-title"><?php _e( 'Feature Icon', 'ap-cpt' );?></span></h4>
                    <span class="section-desc"><em><?php _e( 'Choose icon from list', 'ap-cpt' ); ?></em></span>
                    <div class="ap-cpt-icons-wrapper">
                        <div class="ap-cpt-select-icon">
                            <?php 
                                if( !empty( $value[ 'feature_icon' ] ) ) {
                                    echo '<li class="fa '.$value[ 'feature_icon' ].'"></li>';
                                }
                            ?>
                        </div>
                        <input class="hidden-icon-input" name="product_features[<?php echo $f_count ;?>][feature_icon]" type="hidden" id="ap_cpt_feature_icon_field" value="<?php echo $value[ 'feature_icon' ]; ?>" />
                        <div class="ap-cpt-icon-chooser">
                            <ul class="ap-cpt-icons">
                                <?php 
                                    $icon_class_array = CPT_Class::ap_cpt_fontawesome_icons();
                                    foreach( $icon_class_array as $count => $class ) {
                                        if( $value[ 'feature_icon' ] == $class ) {
                                            echo '<li class="selected"><i class="fa '. $class .'"></i></li>';
                                        } else {
                                            echo '<li><i class="fa '. $class .'"></i></li>';
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                    </div><!-- .ap-cpt-icons-wrapper -->
                </div>
            </div>
            <?php 
                    }
                }
            ?>
        </div>
        <input id="post_features_count" type="hidden" name="product_features_count" value="<?php echo $f_count; ?>" />
        <span class="delete-button product-features"><a href="javascript:void(0)" class="docopy-product-feature button">Add Product Feature</a></span>
    </div>
<?php
}
endif;
function ap_cpt_product_fetures_save_post( $post_id ) { 
    global  $post;
    
    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'ap_cpt_product_features_nonce' ] ) || !wp_verify_nonce( $_POST[ 'ap_cpt_product_features_nonce' ], basename( __FILE__ ) ) )
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
$ap_cpt_allowed_textarea = array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
    );

$stz_product_features =  $_POST['product_features'];
update_post_meta($post_id, 'product_feature', $stz_product_features);

}
add_action('save_post', 'ap_cpt_product_fetures_save_post');