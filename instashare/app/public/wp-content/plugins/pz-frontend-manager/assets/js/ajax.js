jQuery(document).ready(function ($) {
    var type        = pzfmAjaxhandler.pzfmGetTypeLogin;
    var ccode       = pzfmAjaxhandler.countrycode;
    var pzfmAlert   = pzfmAjaxhandler.pzfmAlert;
    var utils       = pzfmAjaxhandler.utils;
    var pzfmGetTypeBannerDashbiard = pzfmAjaxhandler.pzfmGetTypeBannerDashbiard;

    if($('.gsfd-role-editor').length != 0){
	 	 $('.gsfd-role-editor').repeater({
			show: function() {
				$(this).slideDown();
			},
			hide: function(deleteElement) {
				$(this).slideUp(deleteElement);
			}
		});  
	}
   $(".gsfd-role-editor button.btn-pzfm").click(function(){
        $(".user-role-items .form-control.role-slug").each(function(){
            if(!$(this).val()){
                $(this).removeAttr('disabled');
            }
        });
    });
	$.fn.hasAttr = function(name) {  
       return this.attr(name) !== undefined;
    };
    $(".user-role-items .role-input-checkbox").click(function(){
        if(jQuery(this).hasAttr('checked')) {
            $(this).removeAttr('checked');
        } else {
            $(this).attr('checked','checked');
            $(this).val('1');
        }
    });
   
    $('body').delegate('.phone .iti__country-list li', 'click', function (e) {
        e.preventDefault();
        var ncode = $('.phone .iti__selected-dial-code').text();
        var fieldHTML = '<input type="hidden" name="phone-code" value="'+ncode+'">';
        $('#phone').html(fieldHTML);
    });
    // Confirm password match 
    $('#registration-section').on('click', '#reg_button', function( e ){
        e.preventDefault();
        const currElem = $(this);
        const currForm = currElem.closest('form');
        const rpassword = currForm.find('[name="reg_pass"]').val();
        const cpassword = currForm.find('[name="confirm_pass"]').val();
        currForm.find('#password-error').remove();
        if( !rpassword.length || !cpassword.length){
            currElem.closest('div').prepend( `<div id="password-error" class="alert alert-danger p-2">Password required</div>` );
            return
        }
        if( !rpassword.length || rpassword !== cpassword ){
            currElem.closest('div').prepend( `<div id="password-error" class="alert alert-danger p-2">Password not matched</div>` );
            return;
        }
        currForm.find('[type="submit"]').trigger('click');
    })
    if ( $( '#pzfm-body-wrap' ).hasClass( 'pzfm-profile' ) || $( '#phone' ).hasClass( 'phone' ) ) { 
        var input = document.querySelector( "#phone" );
        errorMsg = document.querySelector( "#error-msg" ),
        validMsg = document.querySelector( "#valid-msg" );
        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
        // initialise plugin
        var iti = window.intlTelInput(input, {
            utilsScript: utils,
            preferredCountries: [ccode],
            separateDialCode:true,
            geoIpLookup:null,
            initialCountry:'',
        });
        var reset = function() {
            input.classList.remove( "error" );
            errorMsg.innerHTML = "";
            errorMsg.classList.add( "hide" );
            validMsg.classList.add( "hide" );
        };
        // on blur: validate
        input.addEventListener( 'blur', function() {
            reset();
            if ( input.value.trim() ) {
                if ( iti.isValidNumber() ) {
                    validMsg.classList.remove( "hide" );
                    $( '#reg_button' ).prop( 'disabled', false );
                } else {
                    input.classList.add( "error" );
                    var errorCode = iti.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove( "hide" );
                    $( '#reg_button' ).prop( 'disabled', true );
                }
            }
        });
        
        input.addEventListener( 'change', reset );
        input.addEventListener( 'keyup', reset );

        var ncode = $('.phone .iti__selected-dial-code').text();
        var fieldHTML = '<input type="hidden" name="phone-code" value="'+ncode+'">';
        $('#phone').html(fieldHTML);
    }
    if (pzfmAlert == 1) {
        setTimeout(function () {
            jQuery("#toastBasic").toast("show");
        }, 100);
    }
    // Alert Notification template
    const alertNotification = ( message, className) => {
        const template = `
                <div style="position: absolute; top: 1rem; right: 1rem; z-index: 999999;">
                    <div class="toast show" id="toastBasic" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header ${className}">
                            <label class="text-white mb-0"><i class="mr-2 fa fas fa-bell text-white"></i>${message}</label>
                            <button class="ml-2 mb-1 close text-white" type="button" data-bs-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                </div>
                `;
        $('body').append( template );
        setTimeout(function () {
            $('body').find("#toastBasic").remove();
        }, 5000 );
    }
    function uploadSettingsImage(wrapper, holder, parent) {
        var mediaUploader;
        var inputName   = parent.find(holder).attr('name');
        var imageField  = parent.find('input[name="' + inputName + '"]');
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        mediaUploader.on('select', function( response ) {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $(wrapper).find('.pz-image-placeholder').remove();
            $(wrapper).prepend(`
                <img class="pz-image-placeholder thumbnail upload-image" src="${attachment.url}" alt="img" data-upload="background_image" width="100%">
            `);
            $(wrapper).find(imageField).val(attachment.url);
            $(wrapper).find(parent).find('#remove-background').css('display', 'inline-block');
        });
        mediaUploader.open();
    }
    
    $('body').delegate('.pzfm-select-banner', 'change', function (e) {
        e.preventDefault();
        var selValue = $(this).val();
        gbsdBannerSlider(selValue);
    });
    // Upload site dashboard logo
    $('.upload-logo-wrapper').on('click', '.upload-image', function(e) {
        e.preventDefault();
        var buttonSelf = $(this);
        var parentContainer = buttonSelf.parent();
        uploadSettingsImage('.upload-logo-wrapper', '.upload-logo-holder', parentContainer);
    });
    // Upload login banner image
    $('.upload-background-wrapper').on('click', '.upload-image', function (e) {
        e.preventDefault();
        var buttonSelf      = $(this);
        var parentContainer = buttonSelf.parent();
        uploadSettingsImage('.upload-background-wrapper', '.upload-background-holder', parentContainer);
    });

    function pzfmRemoveBgImage(type) {
        $.ajax({
            url: pzfmAjaxhandler.ajaxurl,
            type: 'post',
            data: {
                action: 'pzfm_bg_images_remove',
                type: type
            },
            beforeSend: function () {
                $('.generate-password-wrap').append('<div class="gen-loader-wrap"><div id="genloader"></div></div>');
            },
            success: function () {
                $('#genloader').remove();
                location.reload();
            }
        });
    }

    function gbsdfBgLogin(value) {

        $.ajax({
            url: pzfmAjaxhandler.ajaxurl,
            type: 'post',
            data: {
                action: 'pzfm_background_login',
                type: value
            },
            beforeSend: function () {
                $('.gbsdf-content-wrap').append('<div class="gen-loader-wrap"><div id="genloader"></div></div>');
            },
            success: function (response) {
                $('.gbsdf-content-wrap').html(response);
                $('body').on('click', '.image-wrapper',  function(e) {
                    e.preventDefault();
                    var buttonSelf = $(this);
                    var parentContainer = buttonSelf.parent();
                    uploadSettingsImage('.image-wrapper', '.upload-image-holder', parentContainer);
                });
                /* REMOVE BG IMAGE */
                $('body').delegate('#remove-background-image, #remove-logo', 'click', function (e) {
                    e.preventDefault();
                    var type = $(this).attr('data-type');
                    pzfmRemoveBgImage(type);
                });
                $('.pzfm-bg-slider-wrap').repeater({
                    initEmpty: true,
                    show: function() {
                        $(this).slideDown();
                    },
                    hide: function(deleteElement) {
                        $(this).slideUp(deleteElement);
                    }
                });
                $('#genloader').remove();
            }
        });
    }
    
    function removeItems(dataID, dataType) {
        $.ajax({
            url: pzfmAjaxhandler.ajaxurl,
            type: 'post',
            data: {
                action: 'pzfm_remove_item',
                dataID: dataID,
                dataType: dataType
            },
            beforeSend: function () {
                $('.pzfm_table').append('<div class="gen-loader-wrap"><div id="genloader"></div></div>');
            },
            success: function (response) {
                window.location.href = response.url+"&pzfm-alert=1&status="+response.status+'&message='+response.message;
            }
        });
    }

    $('body').delegate('.contact-remove-btn, .user-remove-btn', 'click', function (e) {
        e.preventDefault();
        var dataID = $(this).attr('data-id');
        if (confirm(pzfmAjaxhandler.confirmDeletion)) {
            removeItems(dataID, 'user')
        }
    });
    // Delete single post
    $('body').on( 'click', '.pzfm-delete-post-btn',  function (e) {
        e.preventDefault();
        const parentRow   = $(this).closest('tr');
        const dataID      = parentRow.attr("data-id");
        if (confirm(pzfmAjaxhandler.confirmDeletion)) {
            removeItems(dataID, 'post');
        }
    });
    // Delete Bulk posts
    $('body').on( 'click', '.pzfm-post-bulk_action',  function (e) {
        e.preventDefault();

        const parentWrapper = $(this).closest('div.card');
        const actionType    = $(this).closest('.row').find('[name="pzfm-bulk-actions"]').val();

        if( actionType != 'delete' ){
            alert( pzfmAjaxhandler.noAction);
            return;
        }

        let selPosts = [];
        parentWrapper.find('table tbody tr').each( function(){
            const value = $(this).find('input.bulk-select-checkbox:checked').val();
            if( !value ) return;
            selPosts.push(value)
        });
        if( !selPosts.length ){
            alert( pzfmAjaxhandler.errorDeletion)
            return;
        }
        if (confirm(pzfmAjaxhandler.confirmDeletion)) {
            removeItems(selPosts, 'post');
        }
    });
    $('body').on( 'click', '.pzfm-tax-bulk_action', function (e) {
        e.preventDefault();
        var dataID = [];
        var dataType = $(this).attr('data-type');
        const actionType    = $(this).closest('.row').find('[name="pzfm-bulk-actions"]').val();

        if( actionType != 'delete' ){
            alert( pzfmAjaxhandler.noAction);
            return;
        }

        $('.bulk-select-checkbox:checked').each(function () {
            dataID.push($(this).val());
        });

        if( dataID.length == 0 ){
            alert( pzfmAjaxhandler.errorDeletion);
            return;
        }
        if (confirm(pzfmAjaxhandler.confirmDeletion)) {
            removeItems(dataID, dataType);
        }
    });

    $('body').delegate('.cat-remove-btn', 'click', function (e) {
        e.preventDefault();
        var dataID = $(this).attr('data-id');
        var dataType = $(this).attr('data-type');
        if (confirm(pzfmAjaxhandler.confirmDeletion)) {
            removeItems(dataID, dataType );
        }
    });

    $('body').delegate('.tag-remove-btn', 'click', function (e) {
        e.preventDefault();
        var dataID = $(this).attr('data-id');
        if (confirm(pzfmAjaxhandler.confirmDeletion)) {
            removeItems(dataID, 'post_tag')
        }
    });

    $('body').delegate('.btn-activation', 'click', function (e) {
        e.preventDefault();
        var userID = $(this).attr('data-id');
        var type = $(this).attr('data-type');
        $.ajax({
            url: pzfmAjaxhandler.ajaxurl,
            type: 'post',
            data: {
                action: 'pzfm_user_activation_action',
                userID: userID,
                type: type
            },
            beforeSend: function () {
                $('.pzfm-account-action-wrap').append('<div class="gen-loader-wrap"><div id="genloader"></div></div>');
            },
            success: function () {
                if (type == 'activate') {
                    $('.btn-activation').removeClass('btn-success');
                    $('.btn-activation').addClass('btn-danger');
                    $('.btn-activation').attr('data-type', 'deactivate');
                    $('.btn-activation').text('Deactivate User');
                } else {
                    $('.btn-activation').removeClass('btn-danger');
                    $('.btn-activation').addClass('btn-success');
                    $('.btn-activation').attr('data-type', 'activate');
                    $('.btn-activation').text('Activate User');
                }
                $('.gen-loader-wrap').remove();
            }
        });
    });
    $('body').delegate('.pzfm-category-edit', 'click', function (e) {
        e.preventDefault();
        var dataID = $(this).attr('data-id');

        $.ajax({
            url: pzfmAjaxhandler.ajaxurl,
            type: 'post',
            data: {
                action: 'pzfm_get_categories',
                term_id: dataID
            },
            beforeSend: function () {
                $('body').append('<div class="gen-loader-wrap"><div id="genloader"></div></div>');
            },
            success: function ( response ) {
                $('.gen-loader-wrap').remove();
                $('.pzfm-modal-form #editCategoryModalLabel').html(response.name);
                $('.pzfm-modal-form #name').val(response.name);
                $('.pzfm-modal-form #slug').val(response.slug);
                $('.pzfm-modal-form #parent').val(response.parent).change();
                $('.pzfm-modal-form #description').val(response.description);
                $('.pzfm-modal-form #current-term-id').val(response.term_id);
                let myModal = new bootstrap.Modal(document.getElementById('pzfmCategoryFormModal'), {});
                myModal.show();
            }
        });
    });
    $('body').delegate('.pzfm-save-cat', 'click', function (e) {
        e.preventDefault();
        const currElem = $(this);
        const parentWrapper = currElem.closest('#pzfm-post_category_form, #pzfmCategoryFormModal');
        var data_type   = currElem.attr('date-type');
        var name        = parentWrapper.find('input[name="name"]').val();
        var slug        = parentWrapper.find('input[name="slug"]').val();
        var parent      = parentWrapper.find('select[name="parent"]').val();
        var description = parentWrapper.find('textarea[name="description"]').val();
        var term_id     = parentWrapper.find('input[name="action"]').val();

        if(! $.trim(name).length){
            const label = parentWrapper.find('.name label').text();
            alert( `Category name is requred.` );
            return;
        }

        $.ajax({
            url: pzfmAjaxhandler.ajaxurl,
            type: 'post',
            data: {
                action: 'pzfm_save_categories',
                data_type: data_type,
                name: name,
                slug: slug,
                parent: parent,
                description: description,
                term_id: term_id
            },
            beforeSend: function () {
                currElem.append('<div class="gen-loader-wrap"><div id="genloader"></div></div>');
            },
            success: function ( response ) {
                window.location.href = response.url+"&pzfm-alert=1&status="+response.status+'&message='+response.message;
            }
        });
    });

    $('body').delegate('.pzfm-save-tag', 'click', function (e) {
        e.preventDefault();
        const currElem  = $(this);

        const parentWrapper = currElem.closest('#pzfm-post_tag_form, #pzfmTagFormModal');
        var data_type   = currElem.attr('date-type');
        var name        = parentWrapper.find('input[name="name"]').val();
        var slug        = parentWrapper.find('input[name="slug"]').val();
        var description = parentWrapper.find('textarea[name="description"]').val();
        var term_id     = parentWrapper.find('input[name="action"]').val();

        $.ajax({
            url: pzfmAjaxhandler.ajaxurl,
            type: 'post',
            data: {
                action: 'pzfm_save_tag',
                data_type: data_type,
                name: name,
                slug: slug,
                description: description,
                term_id: term_id
            },
            beforeSend: function () {
                currElem.append('<div class="gen-loader-wrap"><div id="genloader"></div></div>');
            },
            success: function ( response ) {
                window.location.href = response.url+"&pzfm-alert=1&status="+response.status+'&message='+response.message;
            }
        });
    });
    $('body').delegate('.pzfm-tag-edit', 'click', function (e) {
        e.preventDefault();
        var dataID = $(this).attr('data-id');

        $.ajax({
            url: pzfmAjaxhandler.ajaxurl,
            type: 'post',
            data: {
                action: 'pzfm_get_tag',
                term_id: dataID
            },
            beforeSend: function () {
                $('body').append('<div class="gen-loader-wrap"><div id="genloader"></div></div>');
            },
            success: function ( response ) {
                $('.gen-loader-wrap').remove();
                $('.pzfm-modal-form #editTagModalLabel').html(response.name);
                $('.pzfm-modal-form #name').val(response.name);
                $('.pzfm-modal-form #slug').val(response.slug);
                $('.pzfm-modal-form #description').val(response.description);
                $('.pzfm-modal-form #current-term-id').val(response.term_id);
                let myModal = new bootstrap.Modal(document.getElementById('pzfmTagFormModal'), {});
                myModal.show();
            }
        });
    });
    function processUserRequest(dataID, dataType) {
        $.ajax({
            url: pzfmAjaxhandler.ajaxurl,
            type: 'post',
            data: {
                action: 'pzfm_user_request_action',
                dataID: dataID,
                dataType: dataType
            },
            beforeSend: function () {
                $('.table-responsive-sm').append('<div class="gen-loader-wrap"><div id="genloader"></div></div>');
            },
            success: function ( response ) {
                window.location.href = response.url+"&pzfm-alert=1&status="+response.status+'&message='+response.message;
            }
        });
    }
    // Users bulk actions
    $('body').on('click', '.pzfm-users-bulk_action', function (e) {
        e.preventDefault();
        const actionType    = $(this).closest('.row').find('[name="pzfm-bulk-actions"]').val();
        let confirmationMessage = pzfmAjaxhandler.confirmDeletion;
        if( actionType == 'activate' ){
            confirmationMessage = pzfmAjaxhandler.confirmActivate;
        }else if( actionType == 'deactivate' ){
            confirmationMessage = pzfmAjaxhandler.confirmDeactivate;
        }
        if( !actionType ){
            alert( pzfmAjaxhandler.noAction);
            return;
        }
        var dataID = [];
        $('.bulk-select-checkbox:checked').each(function () {
            dataID.push($(this).val());
        });
        if( dataID.length == 0 ){
            alert( pzfmAjaxhandler.errorDeletion);
            return;
        }
        if ( ! confirm(confirmationMessage)) {
            return;
        }
        processUserRequest(dataID, actionType);
    });
});