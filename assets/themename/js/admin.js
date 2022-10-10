(function ($) {

    var ajaxurl = themename_admin.ajax_url;
    var themenameNonce = themename_admin.ajax_nonce;
    var custom_theme_file_frame;

    // Dismiss notice
    $('.custom-setup').click(function(){
        
        var data = {
            'action': 'themename_notice_dismiss',
            '_wpnonce': themenameNonce,
        };
 
        $.post(ajaxurl, data, function( response ) {

            $('.themename-notice').hide();
            
        });

    });

    // Getting Start action
    $('.install-active').click(function(){

        $(this).closest('.themename-notice').addClass('installing');

        var data = {
            'action': 'themename_install_plugins',
            '_wpnonce': themenameNonce,
        };
 
        $.post(ajaxurl, data, function( response ) {

            window.location.href = response;
            
        });

    });


    $('.theme-recommended-plugin .recommended-plugin-status').click(function(){
        
        var id = $(this).closest('.about-items-wrap').attr('id');

        $(this).addClass('activating-plugin')
        var PluginName = $(this).closest('.theme-recommended-plugin').find('h2').text();
        var PluginStatus = $(this).attr('plugin-status');
        var PluginFile = $(this).attr('plugin-file');
        var PluginFolder = $(this).attr('plugin-folder');
        var PluginSlug = $(this).attr('plugin-slug');
        var pluginClass = $(this).attr('plugin-class');

        var data = {
            'single': true,
            'PluginStatus': PluginStatus,
            'PluginFile': PluginFile,
            'PluginFolder': PluginFolder,
            'PluginSlug': PluginSlug,
            'PluginName': PluginName,
            'pluginClass': pluginClass,
            'action': 'themename_install_plugins',
            '_wpnonce': themenameNonce,
        };
 
        $.post(ajaxurl, data, function( response ) {
            
            var active = themename_admin.active
            var deactivate = themename_admin.deactivate
            $('#'+id+' .recommended-plugin-status').empty();

            if( response == 'Deactivated' ){
                
                $('#'+id+' .theme-recommended-plugin').removeClass('recommended-plugin-active');
                $('#'+id+' .recommended-plugin-status').removeClass('plugin-active');
                $('#'+id+' .recommended-plugin-status').addClass('plugin-deactivate');
                $('#'+id+' .recommended-plugin-status').html(active);
                $('#'+id+' .recommended-plugin-status').attr('plugin-status','deactivate');

            }else if( response == 'Activated' ){
                
                $('#'+id+' .theme-recommended-plugin').addClass('recommended-plugin-active');
                $('#'+id+' .recommended-plugin-status').removeClass('plugin-deactivate');
                $('#'+id+' .recommended-plugin-status').addClass('plugin-active');
                $('#'+id+' .recommended-plugin-status').html(deactivate);
                $('#'+id+' .recommended-plugin-status').attr('plugin-status','active');

            }else{
                
                $('#'+id+' .theme-recommended-plugin').removeClass('recommended-plugin-active');
                $('#'+id+' .recommended-plugin-status').removeClass('plugin-not-install');
                $('#'+id+' .recommended-plugin-status').addClass('plugin-active');
                $('#'+id+' .recommended-plugin-status').html(active);
                $('#'+id+' .recommended-plugin-status').attr('plugin-status','deactivate');

            }

            $('.recommended-plugin-status').removeClass('activating-plugin');
            
        });
    });

}(jQuery));