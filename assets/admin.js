jQuery(function($) {
    jQuery('.VideoAnalyticesTabLinks').on('click', function(e) {
        e.preventDefault();
        const thisParent = jQuery(this).parent().data('tab');
        const trgt = jQuery(this).index();

        jQuery(this).addClass('active').siblings().removeClass('active');
        jQuery(thisParent).find('.VideoAnalyticesTabWrapper').slideUp('slow');
        jQuery(thisParent).find('.VideoAnalyticesTabWrapper').eq(trgt).slideDown('slow');
    });

    jQuery('.VideoAnalyticesTabLinks').each(function(index, el) {
        if(jQuery(this).hasClass('active')) {
            jQuery(this).trigger('click');
        }
    });

    jQuery('#get-shortcode').on('change', function() {
        let errormsg = '';
        let videoErr = '';
        let posterErr = '';
        if(jQuery('#mediaUri').val() == '') {
            videoErr = 'Please select a video';
        } else {
            videoErr = '';
        }
        if(jQuery('#posterUri').val() == '') {
            posterErr = 'Please select a poster image';
        } else {
            posterErr = '';
        }

        errormsg += videoErr;
        errormsg += posterErr !== '' ? ". " + posterErr : '';

        jQuery('#errMsg').text(errormsg);

        if(jQuery('#mediaUri').val() != '' && jQuery('#posterUri').val()) {
            let data = jQuery(this).serializeArray();
            let uri = '';
            let posterUri = '';
            let autoplay = '';
            let controls = '';
            let loop = '';
            let selectTheme = '';

            data.forEach(function(field) {
                if(field.name == 'videoFields[mediaUri]') {
                    uri = ` src="${field.value}"`;
                } else if(field.name == 'videoFields[posterUri]') {
                    posterUri = ` poster="${field.value}"`;
                } else if(field.name == 'videoFields[autoplay]') {
                    autoplay = ' autoplay="true"';
                } else if(field.name == 'videoFields[controls]') {
                    controls = ' controls="true"';
                } else if(field.name == 'videoFields[loop]') {
                    loop = ' loop="true"';
                } else if(field.name == 'videoFields[muted]') {
                    selectTheme = ` muted="${field.value}"`;
                } else if(field.name == 'videoFields[selectTheme]') {
                    selectTheme = ` theme="${field.value}"`;
                }
            });
            jQuery('#video_analytices_shortcode').val(`[video_analytices_shortcode${uri}${posterUri}${autoplay}${controls}${loop}${selectTheme}]`);
        }
    });

    jQuery(document).on('click', '#add_video_analytices', function(event) {
        event.preventDefault();

        var thisVal = jQuery(this).val(),
            file = wp.media.frames.file_frame = wp.media({
                title: 'Select Media',
                library: {
                    type: "video"
                },
                button: {
                    text: thisVal
                },
                multipal: false
            });

        file.on('select', function() {
            var vTrack = file.state().get('selection').first().toJSON();
            jQuery('#mediaUri').val(vTrack.url);
        });

        file.open();
    });
    jQuery(document).on('click', '#add_poster', function(event) {
        event.preventDefault();

        var thisVal = jQuery(this).val(),
            file = wp.media.frames.file_frame = wp.media({
                title: 'Select Media',
                library: {
                    type: "image"
                },
                button: {
                    text: thisVal
                },
                multipal: false
            });

        file.on('select', function() {
            var vTrack = file.state().get('selection').first().toJSON();
            jQuery('#posterUri').val(vTrack.url);
        });

        file.open();
    });
    jQuery(document).on('click', '#setting_add_poster', function(event) {
        event.preventDefault();

        var thisVal = jQuery(this).val(),
            file = wp.media.frames.file_frame = wp.media({
                title: 'Select Media',
                library: {
                    type: "image"
                },
                button: {
                    text: thisVal
                },
                multipal: false
            });

        file.on('select', function() {
            var vTrack = file.state().get('selection').first().toJSON();
            jQuery('#setting_posterUri').val(vTrack.url);
        });

        file.open();
    });
});