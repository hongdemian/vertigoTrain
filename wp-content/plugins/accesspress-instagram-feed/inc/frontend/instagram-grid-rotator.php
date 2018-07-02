<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
    global $apif_settings, $insta;
    $apif_settings = get_option( 'apif_settings' );
    $username = !empty($apif_settings['username']) ? $apif_settings['username'] : ''; // your username
    $access_token = !empty($apif_settings['access_token']) ? $apif_settings['access_token'] : '';
    $layout = $apif_settings['instagram_mosaic'];
    $image_like = $apif_settings['active'];
    $count = 7; // number of images to show
    require_once('instagram.php');
    // $ins_media = $insta->userMedia();
    $rand_no = rand();
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

    $ins_media = $response;
?>

<script type="text/javascript">
    jQuery(document).ready(function($){
            $( '.ri-grid-<?php echo $rand_no; ?>' ).gridrotator({
                rows : '2',
                columns : '5',
                maxStep : 2,
                interval : 2000,
                preventClick : false,
                w1024 : {
                    rows : '2',
                    columns : '5'
                },
                w768 : {
                    rows : '2',
                    columns : '5'
                },
                w480 : {
                    rows : '2',
                    columns : '5'
                },
                w320 : {
                    rows : '2',
                    columns : '5'
                },
                w240 : {
                    rows : '2',
                    columns : '5'
                }
            });

        });
</script>
        <?php
        if(isset($ins_media['meta']['error_message'])){
            ?>
               <h1 class="widget-title-insta"><span><?php echo $ins_media['meta']['error_message']; ?></span></h1>
            <?php
        }else if (is_array($ins_media['data']) || is_object($ins_media['data'])) { ?>
            <div class="ri-grid ri-grid-<?php echo $rand_no; ?> apif-ri-grid">
                <img class="ri-loading-image" src="<?php echo APIF_IMAGE_DIR. '/ripple.gif'; ?>"/>
                <ul>
                    <?php
                    foreach ($ins_media['data'] as $vm):
                    $img = $vm['images']['standard_resolution']['url'];
                    $image_url = APIF_IMAGE_DIR . '/image-square.png';
                    $image = $vm['images']['standard_resolution']['url'];

                    $link = $vm["link"];
                    $flow_icon = APIF_IMAGE_DIR . '/sc-icon.png';
                    ?>
                    <li><a href="<?php echo $link ?>" target="_blank"><img src="<?php echo esc_url($image); ?>" alt='<?php echo strip_tags(substr($vm['caption']['text'], 0, 20)); ?>'></a></li>
                    <?php
                    endforeach; ?>
                </ul>
            </div>
        <?php } ?>