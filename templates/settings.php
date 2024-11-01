<h1><?php echo __('Default Settings', 'avpa'); ?></h1>

<form action="options.php" method="post">
    <?php settings_fields('avpa_plugin_group'); ?>
    <?php do_settings_sections('avpa_plugin_group'); ?>
    <table class="form-table">
        <tbody>
        <tr height="50">
            <th scope="row"><label for="poster"><?php echo __("Media Poster", 'avpa'); ?></label></th>
            <td><input class="regular-text" id="poster" name="poster" type="text"
                       value="<?php echo get_option('poster'); ?>"
                       placeholder="Image URL"/></td>
        </tr>

        <tr>
            <th scope="row"><label for="autoplay"><?php echo __("Auto Play", 'avpa'); ?>
                    <!-- <a href="#TB_inline?width=600&height=550&inlineId=formatted" class="thickbox"><?php echo __("Preview", 'avpa'); ?></a> -->
                </label></th>
            <td>Yes <input name="autoplay" id="autoplay" type="radio"
                       value="1" <?php checked('1', get_option('autoplay')); ?> />

                       No <input name="autoplay" id="autoplay" type="radio"
                       value="0" <?php checked('0', get_option('autoplay')); ?> />
                       </td>
        </tr>

        <tr>
            <th scope="row"><label for="controls"><?php echo __("Controls", 'avpa'); ?>
                    <!-- <a href="#TB_inline?width=600&height=550&inlineId=formatted" class="thickbox"><?php echo __("Preview", 'avpa'); ?></a> -->
                </label></th>
            <td>Yes <input name="controls" id="controls" type="radio"
                       value="1" <?php checked('1', get_option('controls')); ?> checked />
                       No <input name="controls" id="controls" type="radio"
                       value="0" <?php checked('0', get_option('controls')); ?> />

                       </td>
        </tr>

        <tr>
            <th scope="row"><label for="loop"><?php echo __("Loop", 'avpa'); ?>
                    <!-- <a href="#TB_inline?width=600&height=550&inlineId=formatted" class="thickbox"><?php echo __("Preview", 'avpa'); ?></a> -->
                </label></th>
            <td>Yes <input name="loop" id="loop" type="radio"
                       value="1" <?php checked('1', get_option('loop')); ?> />

                      No <input name="loop" id="loop" type="radio"
                       value="0" <?php checked('0', get_option('loop')); ?> />
                       
                       </td>
        </tr>

        <tr>
            <th scope="row"><label for="loop"><?php echo __("Theme(Pro)", 'avpa'); ?>
                    <!-- <a href="#TB_inline?width=600&height=550&inlineId=formatted" class="thickbox"><?php echo __("Preview", 'avpa'); ?></a> -->
                </label></th>
            <td>City <input name="theme" id="theme" type="radio"
                       value="city" <?php checked('city', get_option('theme')); ?> checked />

                       Fantasy <input name="theme" id="theme" type="radio"
                       value="fantasy" <?php checked('fantasy', get_option('theme')); ?> />
                       

                       Forest <input name="theme" id="theme" type="radio"
                       value="Forest" <?php checked('fantasy', get_option('theme')); ?> />

                       Sea <input name="theme" id="theme" type="radio"
                       value="Sea" <?php checked('sea', get_option('theme')); ?> />


                       </td>
        </tr>

        

        <tr>
            <td>
                <div class="col-sm-10"><?php submit_button(); ?></td>

        </tr>

        </tbody>


    </table>

</form>