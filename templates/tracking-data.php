<h2>Tracking data</h2>
<div class='row'>
<?php
$query = array('posts_per_page' => 30, 'post_type' => 'avpa_vidoes');
    $data = new WP_Query($query);
 
    // The Loop
    if ($data->have_posts()) {
        echo '<table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
            <td>Video</td>
            <td>Path</td>
            <td>Video reports</td>
            </tr>';
        while ($data->have_posts()) {
            $data->the_post();
            if (strpos(get_the_title(), 'youtube') !== false) {
            
            echo '<tr style="height:300px; width:300px !important"><td>'.
             do_shortcode('[avpa src="'.get_the_title().'" autoplay="false" webm="youtube" width="300" height="300" ]')
             .'</td>';
            }else{
                echo '<tr style="height:300px; width:300px !important"><td>'.
                do_shortcode('[avpa src="'.get_the_title().'" autoplay="false" width="300" height="300" ]')
                .'</td>'; 
            }

            echo '<td>'.get_the_title().'</td>';
            echo '<td><a href="?page=video-detail-page&id='.get_the_ID().'">View</a></td></tr>';
        }
        echo '</table>';
    } else {
        // no posts found
    }
    /* Restore original Post Data */
    wp_reset_postdata();
?>
</div>
<style>
video{
    width: 300px;
    height: 200px;
}
</style>