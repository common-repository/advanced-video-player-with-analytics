<?php
/**
 * @package VideoJs
 */

include_once plugin_dir_path(__FILE__) . '/Variables.php';

?>

<div class="videoAnalyticesWrapper">
    <div class="VideoAnalyticesContainer">
        <h1><?php echo $Plugin_Name; ?></h1>

        <ul class="VideoAnalyticesTabLinksContainer" data-tab="#tabContainer">
            <li class="VideoAnalyticesTabLinks active">
                <a href="javascript:void(0)">Tracking data</a>
            </li>
            <li class="VideoAnalyticesTabLinks">
                <a href="javascript:void(0)">Shortcode Generator</a>
            </li>
            <li class="VideoAnalyticesTabLinks">
                <a href="javascript:void(0)">Settings</a>
            </li>
            
        </ul>

        <div id="tabContainer" class="VideoAnalyticesTabContainer">
            <div class="VideoAnalyticesTabWrapper" id="tab3">
                <?php include_once plugin_dir_path(__FILE__) . '/templates/tracking-data.php'; ?>
            </div>
            <div class="VideoAnalyticesTabWrapper" id="tab1">
                <?php include_once plugin_dir_path(__FILE__) . '/templates/shortcode-generator.php'; ?>
            </div>
            <div class="VideoAnalyticesTabWrapper" id="tab2">
                <?php include_once plugin_dir_path(__FILE__) . '/templates/settings.php'; ?>
            </div>
           
        </div>
    </div>
</div>