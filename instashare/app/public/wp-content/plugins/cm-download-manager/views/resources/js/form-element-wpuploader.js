(function($){
    
    var ajaxurl = $('input#CMDM_AddDownloadForm_ajaxurl').val();
    $(document).ready(function(){

    })
    /*
     * to upload screenshot
     */
    .on( 'click', '.cmdm-upload-image-button', function (e) {
        e.preventDefault();
        var send_attachment = wp.media.editor.send.attachment;
        var button_el = $(this);
        var input_el = $(button_el).next('input');
        var wrapper = $(this).closest('.cmdm-wp-uploader-wrapper');
        var list_el = $(wrapper).find('ul');
        var screenshots_v2 = $.parseJSON( input_el.val() );

        wp.media.editor.send.attachment = function(props, attachment) {
            screenshots_v2.push(attachment.id);
            input_el.val( JSON.stringify(screenshots_v2) );
            $(list_el).append('<li><img class="cmdm-thumbnail" id="' + attachment.id + '" src="' + attachment.url + '" /><button type="button" class="cmdm-remove-image-button button" id="' + attachment.id + '" >×</button></li>');
        }

        wp.media.editor.open(button_el);
        return false;    
    })
    

    /*
     * to delete screenshot
     */
    .on( 'click', '.cmdm-remove-image-button', function (e) {
        e.preventDefault();
        var id = Number($(this).attr('id'));
        var wrapper = $(this).closest('.cmdm-wp-uploader-wrapper');
        var item_el = $(this).parent('li');
        var input_el = $(wrapper).find('input');
        var screenshots_v2 = $.parseJSON( $(input_el).val() );

        var index = screenshots_v2.indexOf(id);
        if (index > -1) {
            screenshots_v2.splice(index, 1);
        }
        $(input_el).val( JSON.stringify(screenshots_v2) );

        $(item_el).remove();
        return false;
    })
    ;

})(jQuery);