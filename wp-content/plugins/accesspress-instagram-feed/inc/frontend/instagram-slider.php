<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
global $apif_settings, $insta;
    $apif_settings = get_option( 'apif_settings' );
    $username = $apif_settings['username']; // your username
    $access_token = $apif_settings['access_token'];
    $image_like = $apif_settings['active'];
    $count = 10; // number of images to show
    require_once('instagram.php');
    if($username == '' && $access_token ==''){
        $response = array('meta'=>array('error_message'=>'Username and access token field is empty. Please configure.'));

    }else if($username == ''){
        $response = array('meta'=>array('error_message'=>'Username field is empty.'));

    }else if ($access_token == ''){
        $response = array('meta'=>array('error_message'=>'Access token field is empty.'));
    }else{
        $response = $insta->userMedia();
    }

    if($response == NULL){
        $response = array('meta'=>array('error_message'=>'Username field is empty.'));
    }

    $ins_media_slider = $response;
    ?>
        <?php
        $j = 0;
        if(isset($ins_media_slider['meta']['error_message'])){
            ?>
               <h1 class="widget-title-insta"><span><?php echo $ins_media_slider['meta']['error_message']; ?></span></h1> 
            <?php
        }else if (is_array($ins_media_slider['data']) || is_object($ins_media_slider['data'])) { ?>
            <div id="owl-demo" class="owl-carousel">
                <?php
                foreach ($ins_media_slider['data'] as $vm):
                    if ($count == $j) {
                        break;
                    }
                    $j++;
                    $imgslider = $vm['images']['standard_resolution']['url'];
                    $img_alt = $vm['caption']['text'];
                    ?>
                    <div class="item">
                        <img src="<?php echo esc_url($imgslider); ?>" alt='<?php echo esc_attr( $img_alt ); ?>'/>
                        <?php if ($image_like == '1') : ?>
                            <!-- Image like cound section start -->
                            <span class="instagram_like_count">
                                <p class="instagram_imge_like">
                                    <span class="insta like_image">
                                        <i class="fa fa-heart-o fa-2x"></i>
                                    </span>
                                    <span class="count"><?php echo $likes = $vm['likes']['count']; ?></span>
                                </p>
                            </span>
                            <!-- Image like cound section end -->
                        <?php endif; ?>
                    </div>

                <?php
                endforeach;
                ?>
            </div>
        <?php
        }
        ?>
