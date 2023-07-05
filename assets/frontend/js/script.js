
var is_Responsive = false;
var is_SmartDevice = false;
if (/Android|webOS|iPhone|iPod|iPad|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    is_SmartDevice = true;
}


var range = 768;
//for getting begining values..
var windowH = $(window).height();
var windowW = $(window).width();


if (windowW <= range) {
    is_Responsive = true;


    $(document).ready(function () {


        // Make ColorBox responsive
        $.colorbox.settings.maxWidth = '95%';
        $.colorbox.settings.maxHeight = '95%';

        // ColorBox resize function
        var resizeTimer;

        function resizeColorBox() {
            if (resizeTimer) clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                if ($('#cboxOverlay').is(':visible')) {
                    $.colorbox.load(true);
                }
            }, 300);
        }

        // Resize ColorBox when resizing window or changing mobile device orientation
        $(window).resize(resizeColorBox);
        window.addEventListener("orientationchange", resizeColorBox, false);

    });

}


/* donation script Mir*/
$(document).ready(function () {


    $('#honormessage').on('input', function (e) {
        $('.honorMessage').html($(this).val());

    });

    $('#donating_amount').on('input', function (e) {
        $('.amountHonor').html($(this).val());

    });

    $('#fromname').on('input', function (e) {
        $('.fromnameHonor').html($(this).val());
        $('.fromName').html($(this).val());

    });

    $('#honorofname').on('input', function (e) {

        var checked = $('input[name=sendTo]:checked').val();

        if (checked != "recipient") {
            $('.sendtoname').html($(this).val());
            $('.sendtoname2').html($(this).val());
            $('.honorName').html($(this).val());
        }

    });

    $('#recipientName').on('input', function (e) {

        var checked = $('input[name=sendTo]:checked').val();

        if (checked == "recipient") {
            $('.sendtoname2').html($(this).val());
        }

    });

    $('input[name=sendTo]').on('change', function () {

        $('.honorName').html($('#honorofname').val());

        if (!$(this).is(':checked')) {
            $('.sendtoname2').html($('#honorofname').val());
        }
        else {
            $('.sendtoname2').html($('#recipientName').val());
        }
    });

    $('select[name=sendType]').change(function () {
        if (this.value == 'schedule') {
            $('.scheduleEcard').show();
        }
        else {
            $('.scheduleEcard').hide();
        }
    });

    $('#isEmpMatch').change(function () {
        if ($(this).is(':checked')) {
            $('.isEmpMatch').fadeIn();
        }
        else {
            $('.isEmpMatch').fadeOut();
        }
    });

    $('.notinlist').on('click', function () {

        if ($(this).hasClass('showlist')) {

            $('input#donation_empnames').hide();
            $('select[name="donation_empnames"]').show();

            $(this).removeClass('showlist');
            $(this).html($(this).attr("data-notinlist"));

        } else {

            $('input#donation_empnames').show();
            $('select[name="donation_empnames"]').hide();

            $(this).addClass('showlist');
            $(this).html($(this).attr("data-showlist"));

        }

    });

    $('select[name="donation_empnames"]').on('change', function () {
        $('#donation_empnames').val($(this).val());
    });

    if ($('.isEmpMatch').hasClass('has_error')) {
        $('#isEmpMatch').prop('checked', true);
        $('.isEmpMatch').fadeIn();
    }


    /*Tab changer Donate start*/
    $('.tabchangerDonate > li > .tabmeta').click(function () {
        var currentTab = $(this).next('.sameheight');
        $('.sameheight').slideUp('fast');
        currentTab.slideDown('fast');
        //$('html, body').animate({scrollTop: $('.sameheight').offset().top  }, 'slow');
        $('.tabchangerDonate > li > .tabmeta').removeClass('activetab');
        $(this).addClass('activetab');
        $(this).next().slideDown('100', function () {
            GetheightFUnc();
        });
    });


    GetheightFUnc();

    $('.donatebg').parent('.right_area').addClass("DonateBackground");
    /*Tab canger Donate end*/

    $("#comments").hide();

    $('a.item.link').each(function (index, element) {
        if ($(this).attr('href') == 'https://imicanada.org/assets/files_new/imicanada/ImamiaMedicsInternationalCanadaMembershipForm.pdf') {
            $(this).siblings('div.slider-bottom-strip').show();
        }
    });
    //$("#payment-type").show();
    //$("#onWillPopup").hide();

    $('#language-dropdown').change(function (e) {
        e.preventDefault();
        _waiting_screen("show");

        var this_site = "ajaxmethods/set_language/";
        var url = base_url + this_site + $(this).val();


        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {

                response = JSON.parse(response);
                if (response.success) {
                    location.reload();
                }

            }

        });
    });


    // Donation New Page - 2022
    if($('.donate_form_continer').length > 0){
        var acc = document.getElementsByClassName("d_accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {

                $('.d_accordion').removeClass('active');
                $('.panel').hide();


                /* Toggle between adding and removing the "active" class,
                to highlight the button that controls the panel */
                this.classList.toggle("active");

                /* Toggle between hiding and showing the active panel */
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }

                    var heightone = $(this).closest('.fields-contianer').height() + 180;
                    $(".donate-form-container").animate({ height: heightone });
            });
        }

        var options = document.getElementsByClassName("d_option");
        for(var o = 0; o < options.length; o++) {
            options[o].addEventListener('click', function(e) {

                $('.d_option').removeClass('active');
                $(this).addClass('active');

                // this.parentElement.previousElementSibling.innerHTML = this.dataset.display;
                // $('#selected-cause').html(this.dataset.display);
                $('#donation_projects').val(this.dataset.value);
                $('#review-cause').html(this.dataset.display);
                /* alert(e.target.dataset.value);  */
                if($(this).data('value') == '47' || $(this).data('value') == '56'){
                    // let valueDp = $(this).data('value');
                    if( $(this).next('input').length == '0' ){
                        $('#dp_user_input').remove();
                        $(this).after('<input type="text" class="dp_user_input" name="dp_donor_comment" id="dp_user_input"/>');
                    }
                    
                    return false;
                } 
                var closest = $(this).parent().closest('.form-section'); 
                $(closest).next().children('.step-title').trigger('click');
            })
        }

        $('.num_box_style li').on('click',function(){
            $(this).siblings().removeClass('active_checked_box');
            $(this).siblings().find('.pre_amount').prop("checked", false);

            $(this).addClass('active_checked_box');
            // console.log($(this).find('.pre_amount'));
            $(this).find('.pre_amount').prop("checked", true);

            $("#donate_amount").val($(this).find('.pre_amount').val());
            if($("#custom_amount").val() == ""){
                $("#review-amount").html($(this).find('.pre_amount').val());
            }
        });

        $('.step-title').on('click',function(e){

			var parentDiv       = $(this).parent();
            var causefield      = $('#donation_projects').val();
            var causeEmpty      = ($(parentDiv).hasClass("step-cause") == false && causefield == "" ) ? true : false;
            
            if( $(parentDiv).hasClass("step-completed") || causeEmpty == true ){
                if(causeEmpty){
                    $('#donation-err-msg').show();
                }
                e.preventDefault();
                return;
            }

            if($('#donation-err-msg').is(':visible')){
                $('#donation-err-msg').hide();
            }

            // if( $(parentDiv).hasClass('completetab') || $(parentDiv).prev().hasClass('activetab') ){
                $('.fields-contianer').fadeOut();
                $('.donate-form-container > .form-section').removeClass('activetab');
                parentDiv.addClass('activetab');
                parentDiv.prevAll().addClass('completetab');	
                parentDiv.nextAll().removeClass('completetab');	
                
                var currentTab  = $(this).next('.fields-contianer');
                currentTab.fadeIn('100', function(){
                    var heightone = $(this).height() + 180;
                    $(".donate-form-container").animate({ height: heightone });
                });
            // } else {
            //     e.preventDefault();
            // }           
             
        });

        $("#nexttab").click(function(){
            var closest = $(this).parent().closest('.form-section'); 
            $(closest).next().children('.step-title').trigger('click');
            // console.log(closest);
        });  

        $("#custom_amount").change(function(){
            // alert($(this).val());
            // $("#custom_amount").on('change', function(){
            $("#review-amount").html($(this).val());
        });

        $(".fields-contianer").each(function( index ) {
            if( $(this).has('.form_error').length ){
                var ancestor = $(this).parent().closest('.form-section'); 
                // console.log($(ancestor).children('.step-title'));
                $(ancestor).children('.step-title').trigger('click');                
                return false;
            }
        });

        $('.donate_form_continer form').on('keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if ( $('.donate-form-container > .step-checkout').hasClass('activetab') === false && keyCode === 13) { 
                e.preventDefault();
                var $focused = $(':focus');
                var closest = $($focused).parent().closest('.form-section'); 
                $(closest).next().children('.step-title').trigger('click');
                return false;
            }
        });
    }

});

function donationType() {

    var donationType = $("#donationid").val();

    if (donationType == "gift_of_securities") {

        $("#comments").show();
        $("#payment-type").hide();
    }

    if (donationType == "financial_support") {

        $("#comments").hide();
        $("#payment-type").show();
        //  	 $('#comments').removeAttr('required');

    }

    if (donationType == "request_in_wills") {
        $("#comments").hide();
        $("#payment-type").hide();
        $('#myModal').modal('toggle');
        //  $('#comments').removeAttr('required');
    }


}

function donateBtn() {

    $('#donation').modal('toggle');
    $("#payment-type").show();
}

function giveByWill() {

    $('#myModal').modal('toggle');

}

function isCheckBoxcheked(isChecked) {
    if (isChecked.checked) {

        $("#emailForm").modal('toggle');

    } else {

        //$("#emailForm").modal('dismiss');
    }
}

function giveHonor() {
    $("#emailForm").modal('toggle');
}

/* end donation script Mir*/


function eventInterest(id) {
    //alert("sdfad");
    var id = id;
    $("#eventjoining").modal('toggle');
    $("#eventid").val(id);
}

function submit_with_hash(form_name, hash_name, button_click, returnthis) {
    $("form[name='" + form_name + "']").attr("action", $("form[name='" + form_name + "']").attr("action") + "#" + hash_name);

    if (returnthis) {
        return;
    }

    if (button_click == null) {
        button_click = false;
    }

    if (button_click) {
        console.log($(button_click));
        $(button_click).click();
    }
    else {
        $("form[name='" + form_name + "']").submit();
    }
}


function _runtimePopup(mode, url) {
    var TMP_width = false;
    var TMP_height = false;
    if (is_Responsive) {
        TMP_width = "100%";
        TMP_height = "100%";
    }


    if ((mode == "!!")) {

        if (!TMP_width) {
            TMP_width = "40%";
            TMP_height = "50%";
        }

        $.colorbox({ href: url, iframe: true, width: TMP_width, height: TMP_height });
        return;
    }
    else if (mode == "highlights_readmore") {

        if (!TMP_width) {
            TMP_width = "50%";
            TMP_height = "50%";
        }

        $.colorbox({
            href: url, inline: true, width: TMP_width, height: TMP_height, onComplete: function () {
                $.colorbox.resize();
            }
        });
        return;
    }
    else if ((mode == "modalImage")) {

        $.colorbox({ href: url, photo: true });
        return;
    }
    else if ((mode == "modalVideo")) {

        if (!TMP_width) {
            TMP_width = "640";
            TMP_height = "390";
        }

        $.colorbox({ href: url, iframe: true, innerWidth: TMP_width, innerHeight: TMP_height });
        return;
    }


}


function toggleMenu(that) {

    if (!$(that).siblings('ul').is(":visible")) {
        $(that).siblings('ul').slideDown();
        $(that).children('span').addClass('minus');
    }
    else {
        $(that).siblings('ul').slideUp();
        $(that).children('span').removeClass('minus');
    }
}

function readMoreEllipseWithEllipse() {
    if ($(window).width() < range - 1 && !$('.global_sec3 .fiftySec2 .trimText').hasClass('expended')) {

        $('.global_sec3 .fiftySec2 .trimText').dotdotdot({
            ellipsis: '...',
            watch: true,
            wrap: 'letter',
            height: parseInt($('.global_sec3 .fiftySec2 .trimText').css('line-height'), 10) * 3, // this is the number of lines
            lastCharacter: {
                remove: [' ', ',', ';', '.', '!', '?'],
                noEllipsis: []
            },
            after: "a.read-more"
        });

    }
    else {
        $('a.read-more').parent().trigger("destroy");
    }
}


function hideElement(findInput, openInput, these_value_will_always_disbaled, is_clicked, additional_oper = false) {
    if (is_clicked == null) {
        is_clicked = false;
    }

    if (is_clicked) {
        $(openInput).show();
        if (additional_oper) {
            $(additional_oper).hide();
        }
    }

    if (is_post) {
        if ($(findInput).length > 0) {
            $(openInput).show();
        }
        else {
            $(openInput).hide();
        }
    }


    var _split = these_value_will_always_disbaled.split(",");


    $(findInput).each(function () {

        var _this = $(this);
        for (var i = 0; i < _split.length; i++) {
            if ($(this).val() == _split[i]) {
                $(openInput).hide();
                if (additional_oper) {
                    $(additional_oper).show();
                }
            } else {
                if (additional_oper) {
                    $("input#paypal").prop("checked", true).trigger("change");
                }
            }
        }
    });
}


function closeDisabled(findInput, openInput, these_value_will_always_disbaled, is_clicked) {
    if (is_clicked == null) {
        is_clicked = false;
    }

    if (is_clicked) {
        $(openInput).attr("disabled", false);
    }

    if (is_post) {
        if ($(findInput).length > 0) {
            $(openInput).attr("disabled", false);
        }
        else {
            $(openInput).attr("disabled", true);
        }
    }


    var _split = these_value_will_always_disbaled.split(",");


    $(findInput).each(function () {

        var _this = $(this);
        for (var i = 0; i < _split.length; i++) {
            if ($(this).val() == _split[i]) {
                $(openInput).attr("disabled", true);
            }
        }
    });
}


$(document).ready(function () {

    $('.viewReplies').click(function () {

        if ($(this).html() == 'View Replies') {
            $(this).html('Hide Replies')
        } else {
            $(this).html('View Replies')
        }

        $(this).parent().parent().next().slideToggle();
    })

    $('#commentcounter').click(function () {
        $('.comments-list').slideToggle();
    })

    $('.actions').hide();
    $('.actions_wrap').delegate('.dropdown', 'click', function () {
        //console.log($(this));
        //	$('.actions').hide();
        $(this).next().slideToggle();
    })

    closeDisabled('input[name=\'mode_of_contact\']:checked', 'input[name=\'contact_number\']', '', false);
    closeDisabled('input[name=\'medical_physical_status\']:checked', 'textarea[name=\'medical_physical_reason\']', '0', false);

    hideElement('input[name=\'donation_mode\']:checked', '.hideElement', 'onetime', false);


    if ($('.selectize').length > 0) {
        $('.selectize').selectize({
            persist: false,
            createOnBlur: true,
            create: true
        });
    }


    /*if ( $( findInput ).length > 0 )
    {
        $(".jQuery_openContactNumber input[type='radio']").click(function(){

            $("input[name='contact_number']").attr("disabled", false);

        });

        if ( is_post && $(".jQuery_openContactNumber  input[type='radio']:checked").length > 0)
        {
            $("input[name='contact_number']").attr("disabled", false);
        }
    }
    */

    if (controller == "account/profilesettings/") {
        try {
            $("input[type='checkbox']:not(.simple), input[type='radio']:not(.simple)").iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        }
        catch (e) {

        }
    }

    $(".custom_dropdown select").change(function () {

        var _t = $(this).find("option:selected").text();
        var _span = $(this).closest("div.custom_dropdown").find("span.fakeSelect");
        if (_span.length > 0) {
            _span.html(_t);
        }
        else {
            alert("something went wrong with SELECT box");
        }

    });

    $(".custom_dropdown select").change();


    /*$('#fakeSelectContaier select').each(function(){
        var selectedValue = $(this).children("option:selected").text();
        if( selectedValue == "" ){
            $(this).siblings('.fakeSelect').html("Please Select")
        }else{
            $(this).siblings('.fakeSelect').html(selectedValue)
        }
    })

    $("#fakeSelectContaier select").change(function(){
        $('#fakeSelectContaier select').each(function(){
            var selectedValue = $(this).children("option:selected").text();
            if( selectedValue == "" ){
                $(this).siblings('.fakeSelect').html("Please Select")
            }else{
                $(this).siblings('.fakeSelect').html(selectedValue)
            }
        })
    })
    */


    if ($(".three_images_slider").length > 0) {
        $(".three_images_slider").divas({
            slideTransitionClass: "divas-slide-transition-left",
            titleTransitionClass: "divas-title-transition-left",
            titleTransitionParameter: "left",
            titleTransitionStartValue: "-999px",
            titleTransitionStopValue: "0px",
            wingsOverlayColor: "rgba(0,0,0,0.6)",
            mainImageWidth: "60%",
            imagesToPreload: 3
        });
    }


    if ($('.global_sec3 .fiftySec2 .trimText').length > 0) {
        $('.global_sec3 .fiftySec2 .trimText').dotdotdot({
            ellipsis: '...',
            watch: true,
            wrap: 'letter',
            height: parseInt($('.global_sec3 .fiftySec2 .trimText').css('line-height'), 10) * 3, // this is the number of lines
            lastCharacter: {
                remove: [' ', ',', ';', '.', '!', '?'],
                noEllipsis: []
            },
            after: "a.read-more"
        });
    }


    if ($('#world-map').length > 0) {
        $('#world-map').travelmap({
            theme: 'custom-blue',
            divid: "world-map",

            panControl: true,
            scrollwheel: false,
            draggable: false,
            zoom: 1,
            height: 400
        });
    }

    //chapter master page.
    if ($('#world-map2').length > 0) {
        $('#world-map2').travelmap({
            theme: 'custom-blue',
            divid: "world-map",

            panControl: true,
            scrollwheel: false,
            /*draggable: false,*/
            disableDoubleClickZoom: true,
            minZoom: 1,
            zoom: 2,
            height: 400
        });
    }


    //chapter detail page.
    if ($('#world-map3').length > 0) {
        $('#world-map3').travelmap({
            theme: 'custom-blue',
            divid: "world-map",

            panControl: true,
            scrollwheel: false,
            /*draggable: false,*/
            disableDoubleClickZoom: true,
            minZoom: 1,
            zoom: 2,
            height: 400
        });
    }


    readMoreEllipseWithEllipse();

    //set default mobile styles.
    //mobile_version( windowW,  range,  is_Responsive);


    $(".error_style .alert a.close").click(function () {

        $(".error_style").slideUp("slow");

    });


    if ("imagelinkchange") {

        var _find_link = "../../../";
        var _link_length = 9;

        $("img").each(function () {


            if ($(this).attr("src")) {
                if ($(this).attr("src").substr(0, _link_length) == _find_link) {
                    $(this).attr("src", base_url + $(this).attr("src").substr(_link_length))
                }
            }

        });

        $("a").each(function () {


            if ($(this).attr("href")) {
                if ($(this).attr("href").substr(0, _link_length) == _find_link) {
                    $(this).attr("href", base_url + $(this).attr("href").substr(_link_length))
                }
            }

        });
    }


    //image popup (frontend)
    $(".modelImage").colorbox({ rel: "sqaure" });
    $('a.gallery').colorbox();
    $('.timepicker').timepicker();
    $(".numericonly").keydown(function (e) {

        evt = e || window.event;
        if (!evt.ctrlKey && !evt.metaKey && !evt.altKey) {
            var charCode = (typeof evt.which == "undefined") ? evt.keyCode : evt.which;

            if (charCode && !/\d/.test(String.fromCharCode(charCode))) {



                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }


            }
        }


    });


    $('.ellipseReadMore').on('click', function (event) {
        event.preventDefault();
        $(this).siblings('.trimText').trigger("destroy");
        $(this).siblings('.trimText').addClass('expended');
        $(this).remove();
    });

    $('nav li:has(ul)').doubleTapToGo();

    $('.header_nav li').each(function () {

        if ($(this).children('ul').length > 0) {
            $(this).append('<span class="chidlBtn" onclick="toggleMenu(this)"><span></span></span>')
        }
    })


    $('.mobile_menu_open_btn').click(function () {
        $('.head_sec2').removeClass('hide_main_menu')
    })


    $('.mobile_menu_btn').click(function () {
        $('.head_sec2').addClass('hide_main_menu')
    })


    $(".main_slider .owl-carousel").owlCarousel({
        navigation: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true,
        autoPlay: true,
        rtl: $('body').attr('dir') === "RTL" ? true : false
    });


    var owl = $(".evn_his_slider");
    if (owl.length > 0) {
        owl.owlCarousel({
            items: 4, //10 items above 1000px browser width
            itemsDesktop: [1200, 3], //5 items between 1000px and 901px
            itemsDesktopSmall: [900, 2], // betweem 900px and 601px
            itemsTablet: [600, 1], //2 items between 600 and 0
            itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option
        });


        // Custom Navigation Events
        $(".evn_his .nextBtn").click(function () {
            owl.trigger('owl.next');
        })


        $(".evn_his .prevBtn").click(function () {
            owl.trigger('owl.prev');
        })


    }


    $('.footer_sec1 .sec1_1 div h3').click(function () {

        //if 767 less than or equal to window-width
        if ($(window).width() < range) {
            $(this).siblings('ul').slideToggle('fast');
            $(this).parent().toggleClass('active');

        }
    })


    /*
    3 types of datepicker
    - .datepicker (only shows datepicker)
    - .datepickerimage (shows datepicker with calendar image)
    - .data-datemode (shows with start-end date)
    */


    if ($(".datepicker").length > 0) {
        var this_datepicker = $(".datepicker").datepicker({


            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true

        });


        if ($("input[name='date_of_birth']").length > 0) {
            this_datepicker.datepicker('option', { yearRange: '1930:2030' });
        }

        if ($("input[name='last_date_of_entry']").length > 0) {
            this_datepicker.datepicker('option', { maxDate: 0 });
        }
    }

    if ($(".datepickerimage").length > 0) {
        $(".datepickerimage").datepicker({


            dateFormat: "dd-mm-yy",
            showOn: "both",
            buttonImage: base_url + "images/buttons/1411562983_calendar_2.png",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true
        });
    }


    if ($("input[data-datemode='start']").length > 0 && $("input[data-datemode='end']").length > 0) {


        var start_Date = $("input[data-datemode='start']").datepicker({


            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 2,
            onClose: function (selectedDate) {
                $("input[data-datemode='end']").datepicker("option", "minDate", selectedDate);

            },

            onSelect: function (tmpdate) {
            }
        });


        var end_Date = $("input[data-datemode='end']").datepicker({


            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 2,
            onClose: function (selectedDate) {

                $("input[data-datemode='start']").datepicker("option", "maxDate", selectedDate);
            },

            onSelect: function (tmpdate) {
            }
        });


        //start date must be equal or less than current date. conference/imi-8th-international-conference/registration/screen/3.html
        if ($("input[data-currdate='1']").length > 0) {
            start_Date.datepicker('option', {
                maxDate: 0,
                onClose: function (selectedDate) {
                    $("input[data-datemode='end']").datepicker("option", "minDate", selectedDate);

                }
            });


            end_Date.datepicker('option', {
                minDate: 0,
                onClose: function (selectedDate) {

                    $("input[data-datemode='start']").datepicker("option", "maxDate", 0);
                }
            });
        }

    }

});

// Forum setIds Script  

function setIds(id) {

    var commentid = $(id).parent().attr('data-id');
    $('#parentid').val(commentid);
    var commenteduser = $('#display_replyuser' + commentid).val();
    $('#comt').html("Reply to " + commenteduser + "'s  Comment").css('color', '');

}//end of setIds


/**/

function setForumid(id) {

    $("#forumid").val(id);
    $("#id").val("");
    $("#edit").val("");
    $("#topic_name").val("");
    $("#topic_description").val("");

}

function setTopicid(id) {

    $("#topicid").val(id);
    $("#id").val("");
    $("#edit").val("");
    $("#post_name").val("");
    $("#post_description").val("");

}

/*function setEditTopicid(topicid,postid,post_name,description){
    $("#topicid").val(topicid);
    $("#id").val(postid);
    $("#edit").val("edit");
    $("#post_name").val(post_name);
    $("#post_description").val(description);
}*/


/*function setEditForumid(forumid,topicid,topic_name,description){
    $("#forumid").val(forumid);
    $("#id").val(topicid);
    $("#edit").val("edit");
    $("#topic_name").val(topic_name);
    $("#topic_description").val(description);
}
*/
document.onkeydown = function (evt) {
    //alert("alert");
    var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
    if (keyCode == 13) {
        //	alert("alert");

        $("#comment").submit();
    }
}


function postFormvalidation() {

    var post_name = $('#post_name').val();
    var post_description = $('#post_description').val();
    var color = 'red';
    if (post_name == "" || post_description == "") {
        if (post_name == "" && post_description == "") {

            document.getElementById("post_description").style.borderColor = "red";
            document.getElementById("post_name").style.borderColor = "red";

            $('#error').text("Fields are requried.").css('color', color)

        } else {

            if (post_name == "") {
                document.getElementById("post_name").style.borderColor = "red";
                $('#error').text("Post name is requried.").css('color', color)

            } else {
                document.getElementById("post_name").style.borderColor = "";
            }

            if (post_description == "") {
                document.getElementById("post_description").style.borderColor = "red";
                $('#error').text("Description is requried.").css('color', color)

            } else {
                document.getElementById("post_description").style.borderColor = "";
            }
        }
        return false;
    } else {
        document.getElementById("post_name").style.borderColor = "";
        document.getElementById("post_description").style.borderColor = "";
        $('#error').text("").css('color', color)


        $("form[name='post_form']").submit();
    }
}


function postTopicValidation() {

    var topic_name = $('#topic_name').val();
    var topic_description = $('#topic_description').val();
    var color = 'red';
    if (topic_name == "" || topic_description == "") {
        if (topic_name == "" && topic_description == "") {

            document.getElementById("topic_description").style.borderColor = "red";
            document.getElementById("topic_name").style.borderColor = "red";

            $('#error').text("Fields are requried.").css('color', color)

        } else {

            if (topic_name == "") {
                document.getElementById("topic_name").style.borderColor = "red";
                $('#error').text("Topic name is requried.").css('color', color)

            } else {
                document.getElementById("topic_name").style.borderColor = "";
            }

            if (topic_description == "") {
                document.getElementById("topic_description").style.borderColor = "red";
                $('#error').text("Description is requried.").css('color', color)

            } else {
                document.getElementById("topic_description").style.borderColor = "";
            }
        }
        return false;
    } else {

        $("form[name='topic_form']").submit();
    }
}


function commentFormvalidation() {

    var comment = $('#comment').val();
    var color = 'red';
    if (comment == "") {
        document.getElementById("comment").style.borderColor = "red";
        $('#comt').text("Comment is requried.").css('color', color)

        return false;
    } else {

        $("form[name='commentsform']").submit();
    }
}

function memberShipValidation() {

    var validation = false;
    var color = 'red';


    if ($('input[name=prefered-office-address]:checked').val() == "") {
        document.getElementById("prefered-home-address").style.borderColor = "red";
        $('.prefered-address').text("Prefered address is requried.").css('color', color);
        validation = false;
    } else {
        validation = true;

    }
    if ($('input[name=prefered-phone]:checked').val() == "") {

        document.getElementById("prefered-phone").style.borderColor = "red";
        $('.prefered-phone').text("Prefered phone is requried.").css('color', color);
        validation = false;

    } else {
        validation = true;

    }

    if ($('input[name=membership]:checked').val() == "") {

        document.getElementById("membership").style.borderColor = "red";
        $('.membership').text("Membership is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }

    if ($('input[name=payment-type]:checked').val() == "") {

        document.getElementById("payment-type").style.borderColor = "red";
        $('.payment-type').text("Payment type is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }


    if ($('#password').val() != "" && $('#cpassword').val() != "") {

        if ($('#password').val() != $('#cpassword').val()) {

            document.getElementById("cpassword").style.borderColor = "red";
            $('.cpassword').text("Password not match .").css('color', color);
            validation = false;

        } else {

            validation = true;

        }

    } else {

        if ($('#cpassword').val() == "") {
            document.getElementById("cpassword").style.borderColor = "red";

            $('.cpassword').text("Confirm password is required .").css('color', color);
            validation = false;
        }

        if ($('#password').val() == "") {

            document.getElementById("password").style.borderColor = "red";
            $('.password').text("Password is required.").css('color', color);

            validation = false;

        }
    }


    if ($('#first-name').val() == "") {

        document.getElementById("first-name").style.borderColor = "red";
        $('.first-name').text("First name is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }

    if ($('#middle-name').val() == "") {

        document.getElementById("middle-name").style.borderColor = "red";
        $('.middle-name').text("Middle name is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }

    if ($('#last-name').val() == "") {

        document.getElementById("last-name").style.borderColor = "red";
        $('.last-name').text("Last name is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }
    if ($('#spacialtiy').val() == "") {
        document.getElementById("spacialtiy").style.borderColor = "red";
        $('.spacialtiy').text("spacialtiy  is requried.").css('color', color);
        validation = false;
    } else {
        validation = true;
    }
    if ($('#address').val() == "") {

        document.getElementById("address").style.borderColor = "red";
        $('.address').text("Address is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }
    if ($('#city').val() == "") {

        document.getElementById("city").style.borderColor = "red";
        $('.city').text("City is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }
    if ($('#state').val() == "") {

        document.getElementById("state").style.borderColor = "red";
        $('.state').text("State is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }

    /* if($('#country').val()==""){

          document.getElementById("country").style.borderColor = "red";
       $('.country').text("Country is requried.").css('color', color);
        validation=false;

    }else{

        validation=true;

    }*/

    if ($('#zip-code').val() == "") {

        document.getElementById("zip-code").style.borderColor = "red";
        $('.zip-code').text("Zip  Code is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }

    if ($('#contact-home').val() == "") {

        document.getElementById("contact-home").style.borderColor = "red";
        $('.contact-home').text("Contact Home is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }
    if ($('#cell').val() == "") {

        document.getElementById("cell").style.borderColor = "red";
        $('.cell').text("Cell is requried.").css('color', color);
        validation = false;

    } else {
        validation = true;
    }
    if ($('#email').val() == "") {

        document.getElementById("email").style.borderColor = "red";
        $('.email').text("Address is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }
    if ($('#company-name').val() == "") {

        document.getElementById("company-name").style.borderColor = "red";
        $('.company-name').text("Company Name is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }

    if ($('#title').val() == "") {

        document.getElementById("title").style.borderColor = "red";
        $('.title').text("Title Name is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;
    }

    if ($('#office-address').val() == "") {

        document.getElementById("office-address").style.borderColor = "red";
        $('.office-address').text("Office address is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }

    if ($('#personal-city').val() == "") {

        document.getElementById("personal-city").style.borderColor = "red";
        $('.personal-city').text("Personal information city is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }

    if ($('#personal-state').val() == "") {

        document.getElementById("personal-state").style.borderColor = "red";
        $('.personal-state').text("Personal information state is requried.").css('color', color);
        validation = false;

    } else {

        validation = true;

    }
    /* if($('#personal-country').val()==""){

           document.getElementById("personal-country").style.borderColor = "red";
        $('.personal-country').text("Personal information country is requried.").css('color', color);

     }else{

         validation=true;

     }*/

    if ($('#personal-zip-code').val() == "") {

        document.getElementById("personal-zip-code").style.borderColor = "red";
        $('.personal-zip-code').text("Personal information zip-code is requried.").css('color', color);

    } else {

        validation = true;

    }
    if ($('#office-phone').val() == "") {

        document.getElementById("office-phone").style.borderColor = "red";
        $('.office-phone').text("Personal information Office phone is requried.").css('color', color);

    } else {

        validation = true;

    }
    if ($('#office-fax').val() == "") {

        document.getElementById("office-fax").style.borderColor = "red";
        $('.office-fax').text("Personal information Office fax is requried.").css('color', color);
        validation = false;

    } else {
        validation = true;
    }

    if ($('#enroll').val() == "") {

        document.getElementById("enroll").style.borderColor = "red";
        $('.enroll').text("Enroll is requried.").css('color', color);
        validation = false;
    } else {

        validation = true;

    }
    if ($('#ccv').val() == "") {

        document.getElementById("ccv").style.borderColor = "red";
        $('.ccv').text("CSV is requried.").css('color', color);
        validation = false;
    } else {

        validation = true;

    }
    if ($('#expiration').val() == "") {

        document.getElementById("expiration").style.borderColor = "red";
        $('.expiration').text("Expiration is requried.").css('color', color);
        validation = false;
    } else {

        validation = true;

    }
    if ($('#card-number').val() == "") {

        document.getElementById("card-number").style.borderColor = "red";
        $('.card-number').text("Card Number is requried.").css('color', color);
        validation = false;
    } else {

        validation = true;

    }
    if ($('#donation').val() == "") {

        document.getElementById("donation").style.borderColor = "red";
        $('.donation').text("Donation is requried.").css('color', color);
        validation = false;
    } else {

        validation = true;

    }

    if ($('#signature').val() == "") {

        document.getElementById("signature").style.borderColor = "red";
        $('.signature').text("Signature is requried.").css('color', color);
        validation = false;
    } else {

        validation = true;

    }

    if ($('#date').val() == "") {

        document.getElementById("date").style.borderColor = "red";
        $('.date').text("Date is requried.").css('color', color);
        validation = false;
    } else {

        validation = true;

    }

    return validation;
    /*
     if(validation==false){

         return validation;

       }else{

            $("form[name='membershipForm']").submit();
        }*/

}


$('[data-fancybox]').fancybox({
    youtube: {
        controls: 0,
        showinfo: 0
    },
    vimeo: {
        color: 'f00'
    }
});


function GetheightFUnc() {
    var heightone = $('.sameheight:visible').height() + 180;

    console.log($('.sameheight:visible').height());

    $(".tabchangerDonate").animate({ height: heightone });
}

function DonategotosTep2(e) {
    var honor = $('input[name="honorto"]').val();
    var fromname = $('input[name="fromname"]').val();

    if (honor == "") {
        $('.honorerror').html('This field is required');
    }

    if (fromname == "") {
        $('.honorfromerror').html('This field is required');
    }

    if (fromname != "" && honor != "") {

        $(e).parent('div').next().fadeIn();
        $(e).parent('div').fadeOut();


    }

    setTimeout(function () {
        GetheightFUnc();
    }, 1000);

}

function DonategotosTep3(e) {
    var email = $('input[name="recipientEmail"]').val();
    var re = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

    if (email == "") {

        $('.honoremailerror').html('This field is required');
    } else if (!email.match(re)) {

        $('.honoremailerror').html('Invalid Email');
    } else {

        var checked = $('input[name=sendTo]:checked').val();

        if (checked == "honoree") {
            $('.sendtoname2').html($('#honorofname').val());
        } else {
            $('.sendtoname2').html($('#recipientName').val());
        }

        $(e).parent('div').next().fadeIn();
        $(e).parent('div').fadeOut();

    }

    setTimeout(function () {
        GetheightFUnc();
    }, 1000);

}

function DonategotosTep4(e) {

    $('.honorName').html($('#honorofname').val());
    $('.honorMessage').html("Message: " + $('#honormessage').val());
    $('.fromName').html($('input[name="fromname"]').val());

    $(e).parent('div').next().fadeIn();
    $(e).parent('div').fadeOut();

    setTimeout(function () {
        GetheightFUnc();
    }, 1000);

}

function DonategotosTepPrev(e) {

    $(e).parent('div').prev().fadeIn();
    $(e).parent('div').fadeOut();

    setTimeout(function () {
        GetheightFUnc();
    }, 1000);

}


$(document).ready(function () {

    $(document).on('change', 'select[name="home_country"] , select[name="honor_home_country"]', function () {
        countryID = $(this).val();
        var this_site = "ajaxmethods/get_country_states/";
        var url = base_url + this_site + countryID;
        $.ajax({
            url,
            type: 'POST',
            dataType: 'json',
            success(response) {
                if (response.status) {
                    $("select[name='home_state'], select[name='honor_home_state']").html(response.html);
                }
            }
        }).done(function(){
            var selected_home_state = $('select[name="home_state"]').parent("label").attr("data-selected");
            

            $('select[name="home_state"] option').each(function(){
               
                var this_val = $(this).val();
                if(selected_home_state == this_val){
                    $(this).attr("selected","selected");
                }
            });

            var home_state =  $('select[name="home_state"]').val();
            if(home_state){
                $('select[name="home_state"]').trigger("change");
            }

           
        });
    })
    $(document).on('change', 'select[name="home_state"], select[name="honor_home_state"]', function () {
        stateID = $(this).val();
        var this_site = "ajaxmethods/get_state_cities/";
        var url = base_url + this_site + stateID;
        $.ajax({
            url,
            type: 'POST',
            dataType: 'json',
            success(response) {
                if (response.status) {
                    $("select[name='home_city'], select[name='honor_home_city']").html(response.html);
                }
            }
        }).done(function(){
            var selected_home_city = $('select[name="home_city"]').parent("label").attr("data-selected");
            $('select[name="home_city"] option').each(function(){
                var this_val = $(this).val();
                if(selected_home_city == this_val){
                    $(this).attr("selected","selected");
                }
            });
        });
    })
    $('.switch-toggle').on('click', function (e) {
        id = $(this).data('view-screen');
        $(id).closest('.donate-div-view').children('div').hide();
        $(id).show();
        $(this).parent().children().show();
        $(this).hide();
    });
    var home_country =  $('select[name="home_country"]').val();
    if(home_country){
        $('select[name="home_country"]').trigger("change");
        
    }
    $('.giving-to-imi').on('click', function (e, exists=false) {
        code = $(this).data('currency-code');
        countryID = $(this).data('country-id');
        paypalEmail = $(this).data('paypal-email');
        belongs_country = $(this).data('belongs-country');
        if (countryID == "223") {
            $('input[type="radio"][value="card"]').removeAttr('disabled');
            $('.nlabel-cc').css({"visibility":"visible","order": "0"});
            $('#curr_symbol').html('$');
        } else {
            $('input[type="radio"][value="card"]').attr('disabled', true);
            $('.nlabel-cc').css({"visibility":"hidden", "order": "1"});

            $('input[type="radio"][value="paypal"]').prop("checked", true);
            $('.card-details').hide();
            $('.honor-card-details').hide();
            $('#curr_symbol').html('C$');
        }
        if (locationID != countryID) {
            country = $('select[name="home_country"] option[value="' + locationID + '"]').eq(0).text();
            chapter = $(this).clone().children().remove().end().text();
            console.log(country);
            if(exists == false){
                swal(`Based on your location, we found that you are from ${country} and wants to make a donation to  ${chapter}. If you proceed with this payment, you cannot avail the tax benefit of your country`);
            }
        }

        $(this).closest('.country-listing-donation').find('.giving-to-imi').removeClass('active-tab-donation');
        $(this).addClass('active-tab-donation');
        $(this).closest('.donate-content-section').find('.hundred').find('.active-paypal-code').html(code);
        $(this).closest('.donate-content-section').find('.hundred').find('.active-input-paypal-code').val(code);
        $(this).closest('.donate-content-section').find('.hundred').find('.active-paypal-email').val(paypalEmail);
        $(this).closest('.donate-content-section').find('.hundred').find('.active-belongs-country').val(belongs_country);
    })
    if (!($('.active-tab-donation').length)) {
        //$('.giving-to-imi[data-country-id="223"]').click();
        // $('.giving-to-imi[data-country-id="223"]').trigger('click', true);
        $('.giving-to-imi:first-child').trigger('click', true);
    }


    var currency_code = $('.country-listing-donation').attr("data-post-country");

    $('.giving-to-imi[data-currency-code="'+currency_code+'"]').trigger('click', true);
})
