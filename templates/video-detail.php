<?php
$post_id = $_REQUEST['id'];

$post_data = get_post($post_id, 'ARRAY_A');

if(!$post_data){
    die('No video exist');   
}
 $post_meta = get_post_meta($post_id); 
 if(empty($post_meta)){
    die('No video analytics available');
 }
 $video_analytics = [];
 foreach ($post_meta as $key => $value ) {
    //if differnt keys
    if(strpos($key, '__') == false){
        continue;
    }

    $session_arr = explode('__',$key);
    $session = end($session_arr);

    //user id
    if(strpos($key, 'avp_user_id') !== false){
        if($value[0] == 0){
            $display_name = 'No logged user'; 
        }else{
            $user = get_user_by( 'id', $value[0] ); 
            $display_name = $user->display_name; 
        }
        
        $video_analytics[$session]['user_id'] =   $display_name;    
    }
    //watched
    if(strpos($key, 'avp_watch_time') !== false){
        $video_analytics[$session]['watched'] =   $value[0];    
    }
    //duration
    if(strpos($key, 'avp_duration') !== false){
        $video_analytics[$session]['duration'] =   $value[0];    
    }
    //avp_watch_status
    if(strpos($key, 'avp_watch_status') !== false){
        $video_analytics[$session]['status'] =   $value[0];    
    }
  unset($key);  
  unset($value);  
    
}
krsort($video_analytics);
?>
<div class="videoAnalyticesWrapper">
    <div class="VideoAnalyticesContainer">
        <h1><?php echo $post_data['post_title']; ?></h1>
        <p><a href='?page=video_analytices'>Back</a></p>
        <?php 
        echo '<table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
            <td>User Name</td>
            <td>Watched(seconds)</td>
            <td>Total Video time(seconds)</td>
            <td>Status</td>
            <td>date</td>
            </tr>';
        foreach ($video_analytics as $key => $value ) {
           
            echo '<tr><td>'.$value['user_id'].'</td>';
            echo '<td>'.$value['watched'].'</td>';
            echo '<td>'.$value['duration'].'</td>';
            echo '<td>'.$value['status'].'</td>';
            echo '<td>'.date('d-m-Y H:i:s',$key).'</td>';
            
        }
        echo '</table>'; 
        ?>
    </div>
 </div>