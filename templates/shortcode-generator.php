<form id="get-shortcode" method="post" action="options.php">
    
    <h3>Youtube Video embed Shortcode</h3>
    <p><code>[avpa webm='youtube' src="https://www.youtube.com/watch?v=hc6mN739BJc"]</code></p>
     
    <h3>Mp4 Video embed Shortcode</h3>
    <p><code>[avpa src="path/video.mp4"]</code></p>

    <h3>Video embed with Poster Shortcode</h3>
    <p><code>[avpa src="path/video.mp4" poster="path/image.png"]</code></p>

    <h3>WebM</h3>
	<p><code>[avpa src="path/video.mp4" webm="path/video.webm"]</code></p>

	<h3>Ogv</h3>
	<p><code>[avpa src="path/video.mp4" webm="path/video.webm" ogv="path/video.ogv"]</code></p>

	<h3>Width</h3>
	<p><code>[avpa src="path/video.mp4" width="480"]</code></p>


    <h3>Autoplay Enable</h3>
    <p><code>[avpa src="path/video.mp4"  autoplay="true"]</code></p>
    
    <h3>Repeat (Loop)</h3>
    <p><code>[avpa src="path/video.mp4"  loop="true"]</code></p>

   <h3>Muted</h3>
    <p><code>[avpa src="path/video.mp4" muted="true"]</code></p>
    
    <h3>Contols</h3>
	<p><code>[avpa src="path/video.mp4" controls="ture"]</code></p>

	
	
	
    <?php
        /* settings_fields("video_analytices_cpt");
        do_settings_sections("video_analytices");
        ?>
        <input type="text" id="video_analytices_shortcode" onfocus="this.select();" readonly="readonly" class="large-text code">
        <?php */
        // submit_button();
    ?>
</form>