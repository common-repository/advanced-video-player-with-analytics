function ajax_cal(whereYouAt, lengthOfVideo, webm, status='', player_selector, session){
        var custom_ajax = avpa_ajax.url;
        var nonce = avpa_ajax.nonce;

        jQuery.post(custom_ajax, {
        _ajax_nonce: nonce,
        action: "avpa_video_tracking_action",
        whereYouAt: whereYouAt,
        session: session,
        webm:webm,
        lengthOfVideo: lengthOfVideo,
        status: status
    }, function(data) {
        status = '';

        var obj = JSON.parse(data);
        if(obj.status == 'completed'){
            jQuery('#'+player_selector+'_html5_api').attr('data-session', obj.session_id);
            jQuery('#'+player_selector).attr('data-session', obj.session_id);

        }
    });

    }
