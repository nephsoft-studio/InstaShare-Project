jQuery(document).ready(function($) {
    const currentRoles = pzfmAjaxhandler.currentRoles;
    const ajaxURL      = pzfmAjaxhandler.ajaxurl;

    $("#pzfm-loader").hide();
    $('.pzfm-show-popup-loader').click(function(e){
        $("#pzfm-loader").fadeIn();
    });
    $('.media-sidebar input#attachment-details-alt-text, .media-sidebar textarea').removeAttr('readonly');
    $('body').delegate('#pzfm-enable-user-password', 'change', function(e) {
        if($('#pzfm-enable-user-password').is(":checked")){
            $('.pzfm-password-fields').show();
        }else{
            $('.pzfm-password-fields').hide();
        }
    });

    $("#pzfm-main-form").submit(function (e) {
        e.preventDefault();
        $('.pzfm-action-wrap .loader-wrapper').show();
        $('.pzfm-action-wrap .pzfm-btn-col').hide();
        e.currentTarget.submit();
    });
    $("#loginform").submit(function (e) {
        e.preventDefault();
        $('.pzfm-action-wrap .loader-wrapper').show();
        $('.pzfm-action-wrap .login-btn, .pzfm-action-wrap .register-btn').hide();
        e.currentTarget.submit();
    });
    
    $('body').delegate('.pzfm-settings-nav .nav-item', 'click', function (e) {
        e.preventDefault();
        $(this).each(function() {
            var tab_value = $(this).attr('data-tab');
            if( tab_value == 'general-settings'){
                var get_tab_value = '';
            }else{
                var get_tab_value = tab_value;  
            }
            $('.tab-page').val(get_tab_value);
        });
    });

    $('body').on('click', '.toastClose', function(){
        $(this).closest('.toast').remove();
    });

    /** Save Misc on publish post section */
    const publishWrapper = $('#pzfm-publish_card');
    publishWrapper.on('click', '.edit-post-status', function( e ){
        e.preventDefault();
        $(this).addClass('d-none');
        publishWrapper.find('#post-status-select').removeClass('d-none');
    });
    publishWrapper.on('click', '.cancel-post-status', function( e ){
        e.preventDefault();
        $(this).closest('div').addClass('d-none');
        publishWrapper.find('.edit-post-status').removeClass('d-none');
    });
    publishWrapper.on('click', '.save-post-status', function( e ){
        e.preventDefault();
        const statusValue = publishWrapper.find('select[name="post_status"]').val();
        const statusLabel = publishWrapper.find('select[name="post_status"] option:selected').text();
        $('select option:selected').text();
        publishWrapper.find('#pzfm-btn-publishing-actions [type="submit"]').attr('name', `pzfm_${statusValue}_post`).val(`Save as ${statusLabel}`)
        publishWrapper.find('#post-status-display').text(statusLabel);
        $(this).closest('div').addClass('d-none');
        publishWrapper.find('.edit-post-status').removeClass('d-none');
    });

    /** Save visibility post section */
    let visibilityUpdate = '';
    const checkVisibilityActive = () => {
        const activeSel = publishWrapper.find('[name="visibility"]:checked').val();
        publishWrapper.find('#sticky-span, #password-span').addClass('d-none');
        if( activeSel == 'public' ){
            publishWrapper.find('#sticky-span').removeClass('d-none');
        }
        if( activeSel == 'password' ){
            publishWrapper.find('#password-span').removeClass('d-none');
        }
    }
    publishWrapper.on('click', '.edit-visibility', function( e ){
        e.preventDefault();
        $(this).addClass('d-none');
        publishWrapper.find('#post-visibility-select').removeClass('d-none');
        checkVisibilityActive();
    });
    publishWrapper.on('click', '.cancel-post-visibility', function( e ){
        e.preventDefault();
        publishWrapper.find('.edit-visibility').removeClass('d-none');
        publishWrapper.find('#post-visibility-select').addClass('d-none');
        checkVisibilityActive();
    });
    publishWrapper.on('click', '[name="visibility"]', function(){
        checkVisibilityActive();
        visibilityUpdate = 1;
        publishWrapper.find('[name="sticky"]').prop('checked', false );
    });
    publishWrapper.on('click', '[name="sticky"]', function(){
        visibilityUpdate = 1;
    });
    publishWrapper.on('click', '.save-post-visibility', function(e){
        e.preventDefault();
        checkVisibilityActive();
        const activeID = publishWrapper.find('[name="visibility"]:checked').attr('id');
        const sticky   = publishWrapper.find('[name="sticky"]').is(":checked");
        publishWrapper.find('#post-visibility-display').text( publishWrapper.find(`label[for="${activeID}"]`).text() );
        publishWrapper.find('.edit-visibility').removeClass('d-none');
        publishWrapper.find('#post-visibility-select').addClass('d-none');
        publishWrapper.find('[name="hidden_visibility_status"]').val(visibilityUpdate);
    });

    /** Time Stamp div */
    $timestampdiv = $('#timestampdiv');
    updateText = function() {

        if ( ! $timestampdiv.length )
            return true;

        var attemptedDate, originalDate, currentDate, publishOn, postStatus = $('#post_status'),
            optPublish = $('option[value="publish"]', postStatus), aa = $('#aa').val(),
            mm = $('#mm').val(), jj = $('#jj').val(), hh = $('#hh').val(), mn = $('#mn').val();

        attemptedDate = new Date( aa, mm - 1, jj, hh, mn );
        originalDate = new Date(
            $('#hidden_aa').val(),
            $('#hidden_mm').val() -1,
            $('#hidden_jj').val(),
            $('#hidden_hh').val(),
            $('#hidden_mn').val()
        );
        currentDate = new Date(
            $('#cur_aa').val(),
            $('#cur_mm').val() -1,
            $('#cur_jj').val(),
            $('#cur_hh').val(),
            $('#cur_mn').val()
        );

        // Catch unexpected date problems.
        if (
            attemptedDate.getFullYear() != aa ||
            (1 + attemptedDate.getMonth()) != mm ||
            attemptedDate.getDate() != jj ||
            attemptedDate.getMinutes() != mn
        ) {
            $timestampdiv.find('.timestamp-wrap').addClass('form-invalid');
            return false;
        } else {
            $timestampdiv.find('.timestamp-wrap').removeClass('form-invalid');
        }
        if ( originalDate.toUTCString() == attemptedDate.toUTCString() ) {
            return false;
        }
        // Dec 30, 2022 at 09:14 
        const dateTimeHTML = `${$( 'option[value="' + mm + '"]', '#mm' ).attr( 'data-text' )} ${parseInt( jj, 10 )}, ${aa} at ${( '00' + hh ).slice( -2 )}:${( '00' + mn ).slice( -2 )}`;
        publishWrapper.find('#timestamp b').text(dateTimeHTML);

        return true;
    };
    publishWrapper.on('click', '.edit-timestamp', function( e ){
        e.preventDefault();
        $(this).addClass('d-none');
        publishWrapper.find('#timestampdiv').removeClass('d-none');
    });
    publishWrapper.on('click', '.cancel-timestamp', function( e ){
        e.preventDefault();
        publishWrapper.find('.edit-timestamp').removeClass('d-none');
        publishWrapper.find('#timestampdiv').addClass('d-none');
    });
    publishWrapper.on('click', '.save-timestamp', function( e ){
        e.preventDefault();
        publishWrapper.find('.edit-timestamp').removeClass('d-none');
        publishWrapper.find('#timestampdiv').addClass('d-none');
        publishWrapper.find('[name="hidden_currtime_update"]').val(1);
        updateText();

    });

     /* *   UPLOAD AVATAR SCRIPT * */
     $('#pzfm-avatar-wrapper').on('click', '#pzfm-change-avatar, #close-upload-avatar', function(e){
        e.preventDefault();
        $('#user-avatar, #upload-avatar-wrapper').toggle();
        $('input[type="hidden"][name="pzfm_user_avatar"]').val(e.target.result);
    });
    $('#pzfm-avatar-wrapper').on('click', '#pzfm-change-avatar', function(e){
        e.preventDefault();
        $('.actionSave').css({"display": "none"});
    });
    $('#pzfm-avatar-wrapper').on('click', '#close-upload-avatar', function(e){
        e.preventDefault();
        $('.actionUpload').css({"display": "block"});
        $('.actionSave').css({"display": "none"});
    });
    $('.main-photo-container').on('click', '.photo-container', function(e){
        e.preventDefault();
        $('#updateAvatarModal').css({'display':'block'});
    });
    $uploadCrop = $('#upload-avatar').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        boundary: {
            width: 232,
            height: 232
        },
        url:pzfmAjaxhandler.avatarPlaceholder
    });
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#upload-avatar').croppie('bind', {
                    url: e.target.result
                });
                $('.actionUpload').toggle();
                $('.actionSave').toggle();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#upload-avatar-wrapper').on('change', '.actionUpload', function () { readFile(this); });
    $('a.actionSave').on('click', function(e){
        e.preventDefault();
        const currElem  = $(this)
        var uploadValue = $('#upload-avatar-wrapper #upload.actionUpload').val();
        if( !uploadValue ){
            alert('NO file to upload found!');
            return false;
        }
        $uploadCrop.croppie( 'result', { type: 'base64', size: { width: 200, height: 200  }
        }).then(function (resp) {
            // Check id update or add new user
            const userID = $('[name="user_id"]').length ? $('[name="user_id"]').val() : null;
            $.ajax({
                type:"POST",
                data:{
                    action:'pzfm_upload_avatar',
                    imageData: resp,
                    userID: userID
                },
                url : pzfmAjaxhandler.ajaxurl,
                beforeSend:function(){
                    //** Proccessing
                },
                success:function( response ){
                    if( !userID ){
                        $('[name="pzfm_avatar_id"]').val(response.id);
                    }
                    $('.actionUpload').toggle();
                    $('.actionSave').toggle();
                    $('#close-upload-avatar').remove()
                }
            });
        });
    });
    /* *  END UPLOAD AVATAR SCRIPT  * */

    /* Password Generator */
    const randString = (id) => {
        var dataSet = $(id).attr('data-character-set').split(',');  
        var possible = '';
        if($.inArray('a-z', dataSet) >= 0){
        possible += 'abcdefghijklmnopqrstuvwxyz';
        }
        if($.inArray('A-Z', dataSet) >= 0){
        possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if($.inArray('0-9', dataSet) >= 0){
        possible += '0123456789';
        }
        if($.inArray('#', dataSet) >= 0){
        possible += '![]{}()%&*$#^<>~@|';
        }
        var text = '';
        for(var i=0; i < $(id).attr('data-size'); i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    }

    $('#pzfm-gen_newpass').on( 'click', function(){
        const parentElem = $(this).closest('div');
        const field      = parentElem.find('input[rel="gp"]');
        field.closest('div').removeClass('d-none').css({'display':'block'});
        field.val(randString(field));
    });
    /* End Password Generator */
    
    /* AJAX FUNCTION */
    function loadGraphYear(year) {
        $.ajax({
            url: pzfmAjaxhandler.ajaxurl,
            type: 'post',
            data: {
                action: 'gbsdf_ajax_years',
                year: year,
            },
            beforeSend: function() {
                $('.gcp-cards-wrap').append('<div class="spinner-border text-success"></div>');
                $('.gcp-cards-wrap').addClass("add-loading");
            },
            success: function(response) {
                var response = JSON.parse(response);
                var get_month_sale = response.gbsdf_get_month_sale;
                if ($('#gbsdfchartmaingraph').hasClass("chart-wrap")) {
                    var ctxgraph = document.getElementById('mygraph').getContext('2d');
                    var data = {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        fontColor: '#ffffff',
                        datasets: [{
                            label: 'Current Sales',
                            backgroundColor: '#ffffff',
                            fontColor: '#ffffff',
                            data: get_month_sale
                        }]
                    };

                    var myBarChart = new Chart(ctxgraph, {
                        type: 'bar',
                        data: data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            barValueSpacing: 20,
                            scaleFontColor: '#ffffff',
                            legend: {
                                labels: {
                                    fontColor: '#ffffff'
                                }
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        min: 0,
                                        fontColor: '#ffffff',
                                    },
                                    gridLines: {
                                        color: "#ffffff"
                                    }
                                }],
                                xAxes: [{
                                    ticks: {
                                        min: 0,
                                        fontColor: '#ffffff',
                                    },
                                    gridLines: {
                                        color: "#ffffff"
                                    }
                                }]
                            }
                        }
                    });
                }
                $('.gcp-cards-wrap .spinner-border').remove();
                $('.gcp-cards-wrap').removeClass("add-loading");
            }
        });
    }
    
    /* AJAX DROPDOWN YEAR */
    $('body').delegate('.gcp-get-years', 'change', function (e) {
        e.preventDefault();
        var year = $(this).val();
        loadGraphYear(year);
    });
    $(".pzfm-select-field").select2({
        placeholder: pzfmAjaxhandler.select2Placeholder
    });
    $(".pzfm-select-tags-field").select2({
        tags: true
    });
    $('[name="country"].pzfm-select-field').val(pzfmAjaxhandler.countryoption).trigger('change');

    $('input.disabled, select.disabled ').attr('disabled', true);
    $('#bulk-select-all').click(function() {
        if ($(this).is(':checked')) {
            $('.bulk-select-checkbox').prop('checked', true);
        } else {
            $('.bulk-select-checkbox').prop('checked', false);
        }
    });
    $("select#user_role").select2({
        placeholder: pzfmAjaxhandler.select2Placeholder
    });
    $('.pzfm-repeater').repeater({
        show: function() {
            $(this).slideDown();
            $('.select2-container').remove();
            $('select').select2({
                width: '100%',
                placeholder: "-- Select Product Here --",
                allowClear: true
            });
        },
        hide: function(deleteElement) {
            var productMinus = 0;
            var productmQuantity = $(this).find('.product-quantity').val();
            var productmPrice = $(this).find('.product-item-selection option:selected').attr('data-price');
            productMinus = parseFloat(productmQuantity) * parseFloat(productmPrice);
            var productTotal = 0;
            $('.product-item').each(function() {
                var productQuantity = $(this).find('.product-quantity').val();
                var productPrice = $(this).find('.product-item-selection option:selected').attr('data-price');
                productTotal += parseFloat(productQuantity) * parseFloat(productPrice);
                $(this).find('.product-sub-total').val(int_val(productTotal).toFixed(2));
            });
            var total = productTotal - productMinus;
            $('.pzfm-repeater .order-total').val(int_val(total).toFixed(2));
            $(this).slideUp(deleteElement);
        }
    });
    $('body').delegate('.product-quantity', 'click keyup', function() {
        var productTotal = 0;
        $('.product-item').each(function() {
            var productQuantity = $(this).find('.product-quantity').val();
            var productPrice = $(this).find('.product-item-selection option:selected').attr('data-price');
            productsubTotal = parseFloat(productQuantity) * parseFloat(productPrice);
            productTotal += parseFloat(productQuantity) * parseFloat(productPrice);
            $(this).find('.product-sub-total').val(int_val(productsubTotal).toFixed(2));
        });
        $('.pzfm-repeater .order-total').val(int_val(productTotal).toFixed(2));
    });
    $('body').delegate('.product-item-selection', 'change', function() {
        var productTotal = 0;
        var productselectedPrice = $(this).find('option:selected').attr('data-price');
        $(this).parent().parent().find('.product-price').val(productselectedPrice);
        $('.product-item').each(function() {
            var productQuantity = $(this).find('.product-quantity').val();
            var productPrice = $(this).find('.product-item-selection option:selected').attr('data-price');
            productsubTotal = parseFloat(productQuantity) * parseFloat(productPrice);
            productTotal += parseFloat(productQuantity) * parseFloat(productPrice);
            $(this).find('.product-sub-total').val(int_val(productsubTotal).toFixed(2));
        });
        $('.pzfm-repeater .order-total').val(int_val(productTotal).toFixed(2));
    });

    $('.pzfm-ac-repeater').repeater({
        show: function() {
            $(this).slideDown();
        },
        hide: function(deleteElement) {
            var chargeMinus = 0;
            var chargeTotal = 0;
            var chargeQuantity = $(this).find('.charge-quantity').val();
            var chargeAmount = $(this).find('.charge-amount').val();
            chargeMinus = parseFloat(chargeQuantity) * parseFloat(chargeAmount);
            $('.charges-item').each(function() {
                var chargeQuantity = $(this).find('.charge-quantity').val();
                var chargeAmount = $(this).find('.charge-amount').val();
                chargesubTotal = parseFloat(chargeQuantity) * parseFloat(chargeAmount);
                chargeTotal += parseFloat(chargeQuantity) * parseFloat(chargeAmount);
                $(this).find('.charge-sub-total').val(int_val(chargesubTotal).toFixed(2));
            });
            var total = chargeTotal - chargeMinus;
            $('.pzfm-ac-repeater .charge-total').val(int_val(total).toFixed(2));
            $(this).slideUp(deleteElement);
        }
    });
    $('.pzfm-gallery').repeater({
        show: function() {
            $(this).slideDown();
        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });
    $('body').delegate('.charge-quantity, .charge-amount', 'click keyup', function() {
        var chargeTotal = 0;
        $('.charges-item').each(function() {
            var chargeQuantity = $(this).find('.charge-quantity').val();
            var chargeAmount = $(this).find('.charge-amount').val();
            chargesubTotal = parseFloat(chargeQuantity) * parseFloat(chargeAmount);
            chargeTotal += parseFloat(chargeQuantity) * parseFloat(chargeAmount);
            $(this).find('.charge-sub-total').val(int_val(chargesubTotal).toFixed(2));
        });
        $('.pzfm-ac-repeater .charge-total').val(int_val(chargeTotal).toFixed(2));
    });

    $('.dashboard-pp').click(function(e){
        e.stopPropagation();
        $('#pzfm-imageUpload').get(0).click();
    });
    
    $('.dashboard-pc').click(function(e){
        e.stopPropagation();
        $('#pzfm-imageUploadCover').get(0).click();
    });
    
    $("#pzfm-imageUpload").change(function() {
        fasterPreview(this);
    });
    $("#pzfm-imageUploadCover").change(function() {
        fasterPreviewCover(this);
    });
    function fasterPreview(uploader) {
        if (uploader.files && uploader.files[0]) {
            $(".dashboard-pp").css("background-image", 'url("' + window.URL.createObjectURL(uploader.files[0]) + '")');
        }
    }
    function fasterPreviewCover(uploader) {
        if (uploader.files && uploader.files[0]) {
            $(".dashboard-pc").css("background-image", 'url("' + window.URL.createObjectURL(uploader.files[0]) + '")');
        }
    }


    $("#pzfm-imageUpload").change(function() {
        fasterPreview(this);
    });

    $('#personal_to_billing').change(function() {
        if (this.checked) {
            $('#_billing_first_name, #_billing_last_name, #_billing_email, #_billing_phone').attr('readonly', true);
        } else {
            $('#_billing_first_name, #_billing_last_name, #_billing_email, #_billing_phone').attr('readonly', false);
        }
    });

	$(".login-page #confirm_pass").keyup(function() {
        var currentField = $(this);
        var confirm_pass = currentField.val();
        var reg_pass = $(".login-page #reg_pass").val();
        currentField.parent().parent().find("label .pzfm-reg-error-message").remove();
        currentField.parent().parent().removeClass("pzfm-reg-error");
        currentField.parent().parent().parent().find('input[type="submit"]').prop("disabled", false);

        if (confirm_pass !== reg_pass && confirm_pass.length > 0) {
            currentField.focus();
            currentField.parent().parent().addClass("pzfm-reg-error");
            currentField.parent().parent().find("label").append(' <span class="pzfm-reg-error-message"> - Password doesn\'t match</span>');
            currentField.parents().parent().eq(3).find('input[type="submit"]').prop("disabled", true);
        } else {
            currentField.parents().parent().eq(3).find('input[type="submit"]').prop("disabled", false);
        }
    });
	
	// Password Icon 	
	$( "input[type='password']" ).parent().css('position', 'relative');
	$( "input[type='password']" ).after( '<i class="pzfm-pass-icon fa fa-eye-slash" aria-hidden="true"></i>' );
	
	$(".pzfm-pass-icon").on('click', function(e) {
		e.preventDefault();
		var input = $(this).parent().children('input');
		var type = input.attr('type') === 'password' ? 'text' : 'password';

		if ( input.attr('type') === 'password' ) {
			input.attr('type', 'text');
			$(this).addClass( "fa-eye" ).removeClass( "fa-eye-slash" );
		} else {
			input.attr('type', 'password');
			$(this).addClass( "fa-eye-slash" ).removeClass( "fa-eye" );
		}
	});

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    function int_val(value_int) {
        number = value_int;
        number = number || 0;
        return number;
    }
    $('body').delegate('.remove-image', 'click', function (e) {
        e.preventDefault();
        $('.upload-image').attr('src', $('#default-product-image').val() );
        $('.upload-product-holder, .upload-post-holder, .upload-slider-holder, .upload-image-holder').val('');
    });
    // Featured image 
    $('#pzfm-featured-image_card').on('click', '.pzfm-remove-featured_image', function( e ){
        e.preventDefault();
        const imgPlaceholder = `<img class="thumbnail upload-image mw-100" src="${pzfmAjaxhandler.featuredImgPlaceholder}" alt="img" data-upload="product_image">`;
        $('#pzfm-featured-image_card').find('.thumbnail').remove();
        $('#pzfm-featured-image_card').find('.post-image-wrapper').prepend(imgPlaceholder);
        $('#pzfm-featured-image_card').find('[name="post_image"]').val('');
        $(this).remove();
    });
    $('body').on('click', '.product-image-wrapper, .post-image-wrapper, .slider-image-wrapper, .gallery-image-wrapper, .image-wrapper',  function(e) {
        $(document).ajaxComplete(function(){
            $(".attachment-preview").click(function(){
            setTimeout(function(){  
                $('.media-modal-content').find('.media-sidebar input#attachment-details-alt-text, .media-sidebar textarea').removeAttr('readonly');
            }, 1000);
            }); 
        });
        e.preventDefault();
        var buttonSelf = $(this);
        var parentContainer = buttonSelf.parent();
        //uploadSettingsImage('.product-image-wrapper', '.upload-product-holder', parentContainer);
        var mediaUploader;
        var inputName = parentContainer.find('.upload-product-holder, .upload-post-holder, .upload-slider-holder, .upload-image-holder').attr('name');
        var imageField = parentContainer.find('input[name="' + inputName + '"]');
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.mediaUploader = wp.media({
            title: pzfmAjaxhandler.chooseImage,
            button: {
                text: pzfmAjaxhandler.chooseImage
            },
            multiple: false,
             title: pzfmAjaxhandler.selectImages,
            library: {
                type: 'image'
            },
            button: {
                text: pzfmAjaxhandler.insertSelection
            }
        });
        mediaUploader.on('select', function() {
            $(document).ajaxComplete(function(){
                $(".attachment-preview").click(function(){
                  $('.media-sidebar input#attachment-details-alt-text, .media-sidebar textarea').removeAttr('readonly');
                });
            });
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
            $('.product-image-wrapper, .post-image-wrapper, .slider-image-wrapper, .gallery-image-wrapper, .image-wrapper').find(imageField).parent().find('img').attr('src', attachment.url);
            $('.product-image-wrapper, .post-image-wrapper, .slider-image-wrapper, .gallery-image-wrapper, .image-wrapper').find(imageField).val(attachment.id);
            $('.product-image-wrapper, .post-image-wrapper, .slider-image-wrapper, .gallery-image-wrapper, .image-wrapper').find(parentContainer).find('#remove-background').css('display', 'inline-block');
            // Add remove link 
            parentContainer.find('.pzfm-remove-featured_image').remove();
            parentContainer.append(
                `<a href="#" class="pzfm-remove-featured_image text-sm text-danger">${pzfmAjaxhandler.removeFeaturedImage}</a>`
            );
        });
        mediaUploader.open();
    });
    // if( $( "#pzfm-body-wrap" ).hasClass( "pzfm-dashboard-wrap" ) ){
    //     $('[data-toggle="tooltip"]').tooltip();
    // }
    // Slider
    if( $( "#pzfm-slider-wrap" ).hasClass( "login-sldr-mode" ) ){
        $('.login-sldr-mode').slick({
            accessibility: false,
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 7000,
            arrows: false,
            fade: false,
        });
    }
    $('.anncemnt-sldr-mode').slick({
        accessibility: false,
        fade: true,
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: false,
        autoplay: true,
        autoplaySpeed: 3500,
        arrows: false,
    });
    $('.anncment-img').each(function(index, value) {
        if (index > 4) {
            $(this).hide()
        }
    });

    $('body').delegate('#sidebarToggle', 'click', function(e) {
        e.preventDefault();
        $('ul#accordionSidebar li span').toggle();
    });
    if ($(window).width() < 480) {
        ('body').removeClass('sidebar-toggled');
    }

    //Color Picker
    $('#color-picker').spectrum({
        type: "component",
        togglePaletteOnly: true,
        hideAfterPaletteSelect: true
    });

    $('#personal_to_billing').click(function() {
        if($(this).is(':checked')) {
            $('#_billing_first_name').val($('#first_name').val());
            $('#_billing_last_name').val($('#last_name').val());
            $('#_billing_email').val($('#email').val());
            $('#_billing_phone').val($('#phone').val());
        } else {
            $('#_billing_first_name').val($('').val());
            $('#_billing_last_name').val($('').val());
            $('#_billing_email').val($('').val());
            $('#_billing_phone').val($('').val());
        }
    });
    //$(window).load(function() {
        if($('#personal_to_billing').length != 0) {
            if($('#personal_to_billing:checked')) {
                $('#_billing_first_name').attr("readonly", "readonly");
                $('#_billing_last_name').attr("readonly", "readonly");
                $('#_billing_email').attr("readonly", "readonly");
                $('#_billing_phone').attr("readonly", "readonly");
            }
        }
    //});
    //Copy Button
      $('body').delegate('.pzfm-copy', 'click', function (e) {
        e.preventDefault();
        var text = $(this).attr('data-url');
        var copyHex = document.createElement('input');
        copyHex.value = text
        document.body.appendChild(copyHex);
        copyHex.select();
        document.execCommand('copy');
        copyHex.remove();
    });
      
    /* SIDEBAR ACTIVE SIDEBAR */
    var active_sidebar_section = $('#accordionSidebar .collapse .nav-item.active').parent().attr('id');
    $('#'+active_sidebar_section).addClass('show');

    if($( "#pzfm-social-media" ).hasClass( "pzfm-social-media-wrap" )){
        $('#pzfm-social-media').repeater({
            initEmpty: false,
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            },
           
        })
        $('#pzfm-social-media tbody tr:first-child').find('[data-repeater-delete]').click();
        $('body').on('click', '.icon-image-wrapper',  function(e) {
            $(document).ajaxComplete(function(){
                $(".attachment-preview").click(function(){
                setTimeout(function(){  
                    $('.media-modal-content').find('.media-sidebar input#attachment-details-alt-text, .media-sidebar textarea').removeAttr('readonly');
                }, 1000);
                }); 
            });
            e.preventDefault();
            var buttonSelf = $(this);
            var parentContainer = buttonSelf.parent();
            //uploadSettingsImage('.product-image-wrapper', '.upload-product-holder', parentContainer);
            var mediaUploader;
            var inputName = parentContainer.find('.upload-image-holder').attr('name');
            var imageField = parentContainer.find('input[name="' + inputName + '"]');
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            mediaUploader = wp.media.frames.mediaUploader = wp.media({
                title: pzfmAjaxhandler.chooseImage,
                button: {
                    text: pzfmAjaxhandler.chooseImage
                },
                multiple: false,
                 title: pzfmAjaxhandler.selectImages,
                library: {
                    type: 'image'
                },
                button: {
                    text: pzfmAjaxhandler.insertSelection
                }
            });
            mediaUploader.on('select', function() {
                $(document).ajaxComplete(function(){
                    $(".attachment-preview").click(function(){
                      $('.media-sidebar input#attachment-details-alt-text, .media-sidebar textarea').removeAttr('readonly');
                    });
                });
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
                $('.icon-image-wrapper').find(imageField).parent().find('img').attr('src', attachment.url);
                $('.icon-image-wrapper').find(imageField).val(attachment.id);
                
            });
            mediaUploader.open();
        });
    }
    
});