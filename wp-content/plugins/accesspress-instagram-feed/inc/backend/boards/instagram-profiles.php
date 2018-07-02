<?php defined( 'ABSPATH' ) or die( "No script kiddies please!" ); ?>
<div class="apsc-boards-tabs" id="apsc-board-social-profile-settings">
    <div class="apsc-tab-wrapper">
        <!--Instagram-->
        <div class="apsc-option-outer-wrapper">
            <h4><?php _e('Instagram Feed', 'accesspress-instagram-feed') ?></h4>
            <div class="apsc-option-extra">
                <div class="apsc-option-inner-wrapper">
                    <label for='instagram_username'><?php _e('Instagram Username', 'accesspress-instagram-feed'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="instagram[username]" id='instagram_username' value="<?php echo esc_attr($apif_settings['username']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please enter the instagram username', 'accesspress-instagram-feed'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label for='instagram_user_id'><?php _e('Instagram User ID(Optional)', 'accesspress-instagram-feed'); ?></label>
                    <div class="apsc-option-field">
                        <input type="text" name="instagram[user_id]" id='instagram_user_id' value="<?php  echo esc_attr($apif_settings['user_id']);?>"/>
                        <div class="apsc-option-note"><?php _e('Please get your instagram user id from the below access token input field, after receiving access token. The first numbers before . is your instagram user id', 'accesspress-instagram-feed'); ?></div>
                    </div>
                </div>
                <div class="apsc-option-inner-wrapper">
                    <label for='instagram_access_token'><?php _e('Instagram Access Token', 'accesspress-instagram-feed'); ?></label>
                    <div class="apsc-option-field">
                        <?php
                            if(isset($_GET['access_token'])){
                                $access_token = $_GET['access_token'];
                            }else if(isset($apif_settings['access_token']) && $apif_settings['access_token'] !=''){
                                $access_token = $apif_settings['access_token'];
                            }else{
                                $access_token = '';
                            }
                        ?>
                        <input type="text" name="instagram[access_token]" id='instagram_access_token' value="<?php echo esc_attr($access_token); ?>"/>
                        <div class="apsc-option-note">
                        <?php _e('Please enter the instagram Access Token.You can get this by clicking the below link. If new access token not received in the above Instagram access token field, please copy the access token from the url above after access_token=', 'accesspress-instagram-feed'); ?>
                        <?php _e("Please don't forget to click save button.", 'accesspress-instagram-feed'); ?>
                        <?php $new_url = urlencode(admin_url('admin.php?page=if-instagram-feed')) . '&response_type=token'; ?>
                        <div id="login_with_instagram">
                                <a href="https://api.instagram.com/oauth/authorize/?client_id=54da896cf80343ecb0e356ac5479d9ec&scope=basic+public_content&redirect_uri=http://api.web-dorado.com/instagram/?return_url=<?php echo $new_url;?>">Get Access Token</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Instagram-->
    </div>
</div>
