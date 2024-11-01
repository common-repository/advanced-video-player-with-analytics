<?php
/*
Plugin Name: Advanced Video Player with Analytics
Version: 1
Plugin URI:
Author: sony7596, mrseankumar25, miraclewebssoft
Author URI: https://www.miraclewebsoft.com
Description: Advanced Video Player with analytics it support youtube mp4, webm, ogv formarts. 
Text Domain: avpa
*/

if (!defined('ABSPATH')) {
    exit;
}

define('ADVANCED_VIDEO_PLAYER_VERSION', 1);
define('AVPA_VIDEOJS_VERSION', '7.6.4');
define('AVPA_PLUGIN_URL',  plugins_url('', __FILE__));

if (!class_exists('advancedVideoPlayerAnalytics')) {

    class advancedVideoPlayerAnalytics
    {

        public function __construct()
        {
            $this->avpa_includes();
        }

        public function avpa_includes()
        {
            if (is_admin()) {
                add_filter('plugin_action_links', 'avpa_action_links', 10, 2);
            }

            add_action('admin_menu', 'avpa_add_options_menu');
            add_action('wp_enqueue_scripts', 'avpa_enqueue_scripts');
            add_action('wp_head', 'avpa_header');
            add_shortcode('avpa', 'avpa_embed_handler');
            add_action('wp_ajax_avpa_video_tracking_action', 'avpa_video_tracking_action');
            add_action('wp_ajax_nopriv_avpa_video_tracking_action', 'avpa_video_tracking_action');
            add_action('init', 'avpa_custom_post_type');
            add_filter('widget_text', 'do_shortcode');
            add_filter('the_excerpt', 'do_shortcode', 11);
            add_filter('the_content', 'do_shortcode', 11);
        }
    }

    $GLOBALS['advancedVideoPlayerAnalytics'] = new advancedVideoPlayerAnalytics();
}

function avpa_action_links($links, $file)
{
    if ($file == plugin_basename(dirname(__FILE__) . '/videojs-html5-player.php')) {
        $links[] = '<a href="options-general.php?page=avpa">' . __('Settings', 'avpa') . '</a>';
    }
    return $links;
}


function avpa_add_options_menu()
{
    if (is_admin()) {
        if (is_admin()) {
            add_options_page(__('Avpa Settings', 'avpa'), __('Advanced Video Player with Analytics', 'avpa'), 'manage_options', 'avpa', 'avpa_options_page');
    
            /**
             * Creating Setting
             */
            add_action('admin_init', 'avpa_settings_options');
    
            /**
             * Enqueue Assets
             */
            wp_enqueue_style("VideoAnalyticesStyle", plugins_url('', __FILE__) . "/assets/admin.css");
            wp_enqueue_script('media-upload');
            wp_enqueue_media();
            wp_enqueue_script("VideoAnalyticesScript", plugins_url('', __FILE__) . "/assets/admin.js", '', '', true);
    
            /**
             * Creating Plugin Pgae
             */
            add_menu_page( 'AVPA', 'AVPA', 'manage_options', 'video_analytices', 'avpa_adminMediaCPTIndex', 'dashicons-admin-media', 85 );
            add_submenu_page(
                null, 
                'Video detail',
                'Video detail', 
                'manage_options', 
                'video-detail-page', 
                'avpa_video_detail_callback'
               );
        }
    }
}

function avpa_options_page()
{
    echo 'homepage';
}

function avpa_enqueue_scripts()
{

}

function avpa_header()
{
    if (!is_admin()) {
        $config = ' ';
        echo $config;
    }
}

function avpa_embed_handler($atts)
{
  
    wp_enqueue_script('jquery');
    wp_register_style('videoCSS', AVPA_PLUGIN_URL . '/videojs/video-js.min.css');
    wp_enqueue_style('videoCSS');
  
    wp_register_script('videojs', AVPA_PLUGIN_URL . '/videojs/video.min.js', array('jquery'), AVPA_VIDEOJS_VERSION, true);
    wp_enqueue_script('videojs');

    wp_register_script('youtubejs', AVPA_PLUGIN_URL . '/videojs/youtube.min.js', array('jquery'), 1, true);
    wp_enqueue_script('youtubejs');
    
    wp_register_script('avpa-ajax-script', AVPA_PLUGIN_URL . '/js/avpa-ajax-script.js', array('jquery'), 1, true);
    
    wp_localize_script( 'avpa-ajax-script', 'avpa_ajax', array(
        'url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce('avpa-ajax-nonce'),
    ) );
    
    wp_enqueue_script('avpa-ajax-script');

    extract(shortcode_atts(array(
        'src' => '',
        'webm' => '',
        'ogv' => '',
        'width' => '',
        'height' => '',
        'controls' => '',
        'preload' => 'auto',
        'autoplay' => '0',
        'loop' => '',
        'muted' => '',
        'poster' => '',
        'class' => '',
        'theme' => '',
    ), $atts));
    if (empty($src)) {
        return __('you need to specify the src of the video file', 'avpa');
    }
    $src_raw = $src;
    //src
    $src = '<source src="' . $src . '" type="video/mp4" />';
    if (!empty($webm)) {
        $webm_src = '<source src="' . $webm . '" type="video/webm" />';
        $src = $src . $webm_src;
    }
    if (!empty($ogv)) {
        $ogv = '<source src="' . $ogv . '" type="video/ogg" />';
        $src = $src . $ogv;
    }


    //controls
    $controls = $controls == true ? ' controls' : '';
    if(empty($controls)){
        $controls = (get_option('controls') == 0)?'': ' controls';
    }

    //preload
    if ($preload == "metadata") {
        $preload = ' preload="metadata"';
    } else if ($preload == "none") {
        $preload = ' preload="none"';
    } else {
        $preload = ' preload="auto"';
    }
    //autoplay
    $autoplay_option = '';
    // if($autoplay == true){
    //     $autoplay_option == ' autoplay';
    // }
   
    // if($autoplay == 0 && !$autoplay_option){
    //     $autoplay_option = (get_option('autoplay') == 1)?' autoplay': ' ';
    // }

    
    //loop
    $loop = $loop == true ? ' loop' : '';
    if(empty($loop)){
        $loop = (get_option('loop') == 1)?' loop': '';
    }

    //muted
    $muted = $muted == true ? " muted" : '';
    //poster
    $poster = $poster? $poster: '';
    if (empty($poster)) {
        $poster = (get_option('poster') == '')?'': get_option('poster');
    }
    
    // if(apva_checkRemoteFile($poster)){
        
    //     $poster = ' poster="' . $poster . '"';
    // }else{
    //     $poster = '';  
    // }
    
    // Theme
    $themeClass = $theme != '' ? $theme : 'city';

    //player id genration
    $resp = avpa_generate_video_id($src_raw);
    $post_id = $resp['post_id'];

    //playsinline
    $playsinline = ' playsinline';

    $player = "avpa_" . $post_id;
    $session = $resp['session_id'];

      //custom style
      $style = '';
      if (!empty($width)) {
          $style .="<style>#{$player} {
                width:{$width}px;
          }</style>";
     }else{
        $style ="<style>#{$player} {
                width:100%;
        }</style>"; 
     }


  
       //width
       if ($width) {
          $width = ' width="' . $width . '"';
      } else {
          $width = "";
      }
      //height
      if ($height) {
          $height = ' height="' . $height . '"';
      } else {
        $style .="<style>#{$player} {
            height:auto;
        }</style>"; 
      }


    $script = "<script>
    jQuery(document).ready(function($) {
        var player_id = '{$player}'
        var player_selector = $('#'+player_id);
        var session = player_selector.data('session');
        var status = '';

            var myPlayer = videojs(player_id);
            var webm = myPlayer.currentSrc();
            myPlayer.on('play', function() {
                var lengthOfVideo = myPlayer.duration();
                var whereYouAt = myPlayer.currentTime();
                ajax_cal(whereYouAt, lengthOfVideo, webm, status, player_selector, session);
            });

            myPlayer.on('pause', function() {
                var lengthOfVideo = myPlayer.duration();
                var whereYouAt = myPlayer.currentTime();
                ajax_cal(whereYouAt, lengthOfVideo, webm, status, player_selector, session);
            });

            myPlayer.on('ended', function() {
                var lengthOfVideo = myPlayer.duration();
                var whereYouAt = myPlayer.currentTime();
                status = 'completed';
                ajax_cal(whereYouAt, lengthOfVideo, webm, status, player_selector, session);

            });
            
    });
    </script>";
   
    switch($webm){
        case 'youtube':
            $output = <<<_HTML
                <video id="$player" 
                class="video-avpa video-js vjs-default-skin vjs-big-play-centered" 
                {$controls}{$preload}{$autoplay_option}{$loop}{$muted}{$poster}{$playsinline}{$width}{$height}
                data-session={$session} 
                data-analytics={$post_id}
                data-setup='{"fluid": true, "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "{$src_raw}"}] }'
                ></video>
                $script
                $style
_HTML;
        break;
        case 'vimeo':
            $output = <<<_HTML
                <video id="$player" 
                class="video-avpa video-js vjs-default-skin vjs-big-play-centered" 
                {$controls}{$preload}{$autoplay_option}{$loop}{$muted}{$poster}{$playsinline}{$width}{$height} 
                data-session={$session} data-analytics={$post_id} 
                data-setup='{ "techOrder": ["vimeo"], "sources": [{ "type": "video/vimeo", "src": "https://vimeo.com/99275308"}], "vimeo": { "color": "#fbc51b"} }'></video>
                $script
                $style
_HTML;
        break;
        default:
            $output = <<<_HTML
                <video id="$player" 
                class="video-avpa video-js vjs-theme-{$themeClass} vjs-big-play-centered"
                {$controls}{$preload}{$autoplay_option}{$loop}{$muted}{$poster}{$playsinline}{$width}{$height} 
                data-setup='{"fluid": true}' 
                data-session={$session} 
                data-analytics={$post_id}>$src</video>
                $script
                $style
_HTML;
    }
    
    return $output;
}

function avpa_video_tracking_action()
{
    // nonce check for an extra layer of security, the function will exit if it fails
    if (!wp_verify_nonce($_REQUEST['_ajax_nonce'], "avpa-ajax-nonce")) {
        exit("Woof Woof Woof");
    }

    $lengthOfVideo = sanitize_text_field($_REQUEST["lengthOfVideo"]);
    $whereYouAt = sanitize_text_field($_REQUEST["whereYouAt"]);
    $session = sanitize_text_field($_REQUEST["session"]);
    $webm = esc_url_raw($_REQUEST["webm"]);
    $status = sanitize_text_field($_REQUEST["status"]);

    $resp = avpa_generate_video_id($webm, $whereYouAt, $lengthOfVideo, $status, $session);
    if (isset($resp['status'])) {
        echo json_encode(['status' => $resp['status'], 'session_id' => $resp['session_id']], true);
        die();
    }
    echo 1;
    die();

}

function avpa_custom_post_type()
{
    register_post_type('avpa_vidoes',
        array(
            'labels' => array(
                'name' => __('Videos Analytics', 'textdomain'),
                'singular_name' => __('Video Analytics', 'textdomain'),
            ),
            'public' => false,
            'has_archive' => true,
            //'show_ui' => false
        )
    );

}

function avpa_generate_video_id($video_url, $watching_at = '', $duration = '', $status = '', $session_id = '')
{

    //0 if user not logged
    $watching_user = get_current_user_id();
    $title = esc_html($video_url);
    $post_type = 'avpa_vidoes';

    //check user watching status
    if (!$session_id) {
        $session_id = strtotime(date('Y-m-d H:i:s'));
    }

    //check video exists
    $post = get_page_by_title($title, 'ARRAY_A', $post_type);

    if (!isset($post['ID'])) {
        $post_arr = array(
            'post_title' => $title,
            'post_content' => 'Video Tracking',
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_type' => $post_type,

        );
        $post_id = wp_insert_post($post_arr);

    } else {

        $post_id = $post['ID'];
    }

    if ($watching_at) {
        //update or create meta
        //checking user watch session
        update_post_meta($post_id, 'avp_user_id__' . $watching_user . '__' . $session_id, $watching_user);
        update_post_meta($post_id, 'avp_watch_time__' . $watching_user . '__' . $session_id, $watching_at);
        update_post_meta($post_id, 'avp_duration__' . $watching_user . '__' . $session_id, $duration);
        update_post_meta($post_id, 'avp_watch_status__' . $watching_user . '__' . $session_id, $status);
        update_post_meta($post_id, 'avp_watching_time__' . $watching_user . '__' . $session_id, date('Y-m-d H:i:s'));

    }

    $return = ['session_id' => $session_id, 'post_id' => $post_id];

    if ($status == 'completed') {
        $session_id = strtotime(date('Y-m-d H:i:s'));
        $return['session_id'] = $session_id;
        $return['status'] = 'completed';
    }

    return $return;
}


function avpa_adminMediaCPTIndex() {
    return require_once(plugin_dir_path(__FILE__) . "/admin.php");
}
function avpa_ManagerApi($input) {
    $output = get_option('videoFields');
    if(isset($_POST['remove_post'])):
        unset($output[$_POST['remove_post']]);
        return $output;
    endif;
    if(count($output) == 0):
        $output[$input['meidaId']] = $input;
        return $output;
    endif;

    if($input['optionType'] === "add"):
        if(array_key_exists($input['meidaId'], $output)):
            $it = end($output);
            $input['meidaId'] = $it['meidaId'] + 1;
        endif;
    else:
        $input['optionType'] = 'add';
    endif;

    if($output != ""):
        foreach($output as $key => $val):
            if($input['meidaId'] === $key):
                $output[$key] = $input;
            else:
                $output[$input['meidaId']] = $input;
            endif;
        endforeach;
    endif;
    return $output;
}
function avpa_SectionsApi() {}

function avpaTheme($args) {
    $name = $args['label_for'];
    $optionName = $args['optionName'];

    ?>
    <select name="<?php echo $optionName . "[$name]"; ?>">
        <?php
            foreach($args['options'] as $key => $value):
                ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php
            endforeach;
        ?>
    </select>
    <?php
}

function avpa_video_detail_callback(){
  return require_once(plugin_dir_path(__FILE__) . "/templates/video-detail.php");  
}

function avpa_settings_options()
    {
        //register our settings
        register_setting('avpa_plugin_group', 'poster');
        register_setting('avpa_plugin_group', 'autoplay');
        register_setting('avpa_plugin_group', 'controls');
        register_setting('avpa_plugin_group', 'loop');
        register_setting('avpa_plugin_group', 'theme');


    }
    function apva_checkRemoteFile($url)
    {
        $response = wp_remote_get($url);
     
        if($response['response']['code'] == 200)
        {
            return true;
        }
        else
        {
            return false;
        }
}
