// JavaScript Document
(function ($) {

    jQuery.fn.extend({

        wordCountLimit: function (options) {

            var defaults = {
                maxlength: '250',
                divClassName: ""
            };

            var o = $.extend(defaults, options);
            $("." + o.divClassName).html(o.maxlength);


            var _elem_this = this;
            this.on('keyup', function (event) {

                n = _elem_this.val().length;
                n = o.maxlength - n;
                $("." + o.divClassName).html(n);

            });

            this.trigger("keyup");
        }

    });

    $(document).on('ready', function () {

        if ($('#countries-list').length > 0) {
            $('#countries-list').selectize();
        }

        $('input.parent[type="checkbox"]').on('ifChanged', function (e) {
            var id = $(this).attr('id').match(/\d+/);
            if (this.checked) {
                $('input.child-' + id).iCheck('check')
            } else {
                $('input.child-' + id).iCheck('uncheck')
            }
        });

        $('input[name="medical_physical_status"]').on('ifChecked', function (e) {
            if ($(this).val() == 1) {
                $('textarea[name="medical_physical_reason"]').attr('disabled', false);
            } else {
                $('textarea[name="medical_physical_reason"]').attr('disabled', true);
            }
        });

        restrict_not_allowed_operations();

        if ($('.imi_selectize').length > 0) {
            $('.imi_selectize').selectize({
                persist: false,
                createOnBlur: true,
                create: true
            });
        }
    });

    $(document).ajaxComplete(function () {
        restrict_not_allowed_operations();
    });

    function restrict_not_allowed_operations() {
        if (typeof operations !== "undefined") {
            $notallow_operations = JSON.parse(operations);
            $notallow_operations.forEach(function (e) {
                if ($('[data-operationid="' + e.operationid + '"]').length > 0) {
                    $('[data-operationid="' + e.operationid + '"]').hide();
                }
            });
        }
    }

})(jQuery);

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return null;
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function ajax_conferencetopics_by_conferenceid(this_elem) {


    _waiting_screen("show");

    var this_site = "ajaxmethods/conferencetopics_by_conferenceid/";
    var url = base_url + this_site + this_elem.val();
    var pars = '';
    var target = '.targetBox_cmsarea';


    if (this_elem.val() == '') {
        $(target).html('<small class="badge pull-right bg-green" style="">please select conference first</small>');
        _waiting_screen("hide");
        return false;
    }


    $.ajax({
        type: "POST",
        url: url,
        data: "",
        success: function (response) {


            submit_action(response, target);

        }

    });

}


function ajax_conference_program_table_by_conferenceid(this_elem) {


    _waiting_screen("show");

    var this_site = "ajaxmethods/conference_program_table_by_conferenceid/";
    var url = base_url + this_site + this_elem.val();
    var pars = '';
    var target = '.targetBox_cmsarea';


    if (this_elem.val() == '') {
        $(target).html('<small class="badge pull-right bg-green" style="">please select conference first</small>');
        _waiting_screen("hide");
        return false;
    }


    $.ajax({
        type: "POST",
        url: url,
        data: "",
        success: function (response) {


            submit_action(response, target);

        }

    });

}


function ajax_cmstype_with_cmsmenu(this_elem) {
    _waiting_screen("show");

    var this_site = "ajaxmethods/cmstype_with_cmsmenu/";
    var url = base_url + this_site + this_elem.val();
    var pars = '';
    var target = '.targetBox_cmsarea';


    $.ajax({
        type: "POST",
        url: url,
        data: "",
        success: function (response) {


            submit_action(response, target);

        }

    });

}

function ajax_cmstype_with_cmsmenu_by_lang(this_elem) {
    _waiting_screen("show");

    var this_site = "ajaxmethods/cmstype_with_cmsmenu_by_lang/";
    var url = base_url + this_site + this_elem.val();
    var pars = '';
    var target = '.targetBox_cmsarea';


    $.ajax({
        type: "POST",
        url: url,
        data: "",
        success: function (response) {


            submit_action(response, target);

        }

    });

}


function ajax_cmstype_with_typeid(this_elem) {
    _waiting_screen("show");

    var this_site = "ajaxmethods/cmstype_with_typeid/";
    var url = base_url + this_site + this_elem.val();
    var pars = '';
    var target = '.targetBox_cmsarea';


    $.ajax({
        type: "POST",
        url: url,
        data: "",
        success: function (response) {


            submit_action(response, target);

        }

    });

}


function ajax_whoattend_by_conferenceid(this_elem) {
    _waiting_screen("show");

    var this_site = "ajaxmethods/whoattend_by_conferenceid/";
    var url = base_url + this_site + this_elem.val();
    var pars = '';
    var target = '.targetBox_other';


    $.ajax({
        type: "POST",
        url: url,
        data: "",
        success: function (response) {


            submit_action(response, target);

        }

    });

}


function ajax_cmsmenu_with_position(this_elem) {
    _waiting_screen("show");

    var this_site = "ajaxmethods/cmsmenu_with_position/";
    var url = base_url + this_site + this_elem.val();
    var pars = '';
    var target = '.targetBox_cmsarea';


    $.ajax({
        type: "POST",
        url: url,
        data: "",
        success: function (response) {


            submit_action(response, target);

        }

    });

}

function ajax_cmstopic_with_forum(this_elem) {

    _waiting_screen("show");

    var this_site = "ajaxmethods/cmstopics_with_forum/";
    var url = base_url + this_site + this_elem.val();
    var pars = '';
    var target = '.targetBox_topicarea';

    $.ajax({
        type: "POST",
        url: url,
        data: "",
        success: function (response) {


            submit_action(response, target);

        }

    });

}


function ajax_conferencetype_with_conferencemenu(this_elem) {
    _waiting_screen("show");

    var this_site = "ajaxmethods/conferencetype_with_conferencemenu/";
    var url = base_url + this_site + this_elem.val();
    var pars = '';
    var target = '.targetBox_conferencearea';


    $.ajax({
        type: "POST",
        url: url,
        data: "",
        success: function (response) {

            submit_action(response, target);

        }

    });

}


function ajax_sightseeing_with_country(this_elem) {
    _waiting_screen("show");

    var this_site = "ajaxmethods/sightseeing_with_country/";
    var url = base_url + this_site + this_elem.val();
    var pars = '';
    var target = '.targetBox_sightseeing';


    $.ajax({
        type: "POST",
        url: url,
        data: "",
        success: function (response) {


            submit_action(response, target);

        }

    });

}

function ajax_edit_save_family_member(this_elem) {
    _waiting_screen("show");

    var this_site = "ajaxmethods/edit_save_family_member/";
    var url = base_url + this_site;
    id = $(this_elem).data("id");
    parent_tr = $(this_elem).parent().parent();
    family_relationship_id = $(parent_tr).find('select[name="family_relationship"]').val();
    family_name = $(parent_tr).find('input[name="family_name"]').val();
    family_email = $(parent_tr).find('input[name="family_email"]').val();
    family_age = $(parent_tr).find('input[name="family_age"]').val();
    family_birthdate = $(parent_tr).find('input[name="family_birthdate"]').val();
    var target = '.targetBox_sightseeing';


    $.ajax({
        type: "POST",
        url: url,
        data: {
            "id": id,
            "family_relationship_id": family_relationship_id,
            "family_name": family_name,
            "family_email": family_email,
            "family_age": family_age,
            "family_birthdate": family_birthdate
        },
        success: function (response) {


            submit_action(response, target);

        }

    });

}

function ajax_new_save_family_member(this_elem) {
    _waiting_screen("show");

    var this_site = "ajaxmethods/new_save_family_member/";
    var url = base_url + this_site;
    id = $(this_elem).data("id");
    parent_tr = $(this_elem).parent().parent();
    family_relationship_id = $(parent_tr).find('select[name="family_relationship"]').val();
    family_name = $(parent_tr).find('input[name="family_name"]').val();
    family_email = $(parent_tr).find('input[name="family_email"]').val();
    family_age = $(parent_tr).find('input[name="family_age"]').val();
    family_birthdate = $(parent_tr).find('input[name="family_birthdate"]').val();
    var target = '.targetBox_sightseeing';


    $.ajax({
        type: "POST",
        url: url,
        data: {
            "id": id,
            "family_relationship_id": family_relationship_id,
            "family_name": family_name,
            "family_email": family_email,
            "family_age": family_age,
            "family_birthdate": family_birthdate
        },
        success: function (response) {

            submit_action(response, target);

            var _result = JSON.parse(response);

            setTimeout(function () {
                if (_result._call_name == 'edit_save_family_member' && "undefined" != _result.family_id) {
                    $('.family_relationships .relationships_data tr:last').find('.edit-family').attr('data-id', _result.family_id);
                    $('.family_relationships .relationships_data tr:last').find('.delete-family').attr('data-id', _result.family_id);
                }
            }, 1000);

        }

    });

}

function ajax_delete_family_member(this_elem) {
    _waiting_screen("show");

    var this_site = "ajaxmethods/delete_family_member/";
    var url = base_url + this_site;
    id = $(this_elem).data("id");
    var target = '.targetBox_sightseeing';


    $.ajax({
        type: "POST",
        url: url,
        data: {
            "id": id
        },
        success: function (response) {


            submit_action(response, target);

        }

    });

}


function toggle_confpricetypes(radio_inputs, elem) {
    radio_inputs.attr("disabled", false);
    if (elem.val() == "members") {
        $("tr.others input[type='text']").attr("disabled", true);
    }
    else {
        $("tr.members input[type='text']").attr("disabled", true);
    }
}

function render_numericonly() {
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
}


function manageconferencepresenters_conferencetopicsselection(view_or_edit) {
    if (view_or_edit == "edit") {
        $('.ilinks_sortable input[type="checkbox"]').on('ifChecked', function (event) {

            $(this).parent().parent().find("input[type='text']").attr("disabled", false);

        });

        $('.ilinks_sortable input[type="checkbox"]').on('ifUnchecked', function (event) {

            $(this).parent().parent().find("input[type='text']").attr("disabled", true);

        });
    }
    else {
        $('.ilinks_sortable input[type="checkbox"]').each(function () {

            if ($(this).attr("checked")) {
                $(this).parent().parent().find("input[type='text']").attr("disabled", false);
            }
            else {
                $(this).parent().parent().find("input[type='text']").attr("disabled", true);
            }

        });
    }
}

$(function () {

    $(document).ready(function () {

        $(document).on("click", '.edit-family', function () {
            let id = $(this).data('id');
            let parent_tr = $(this).parent().parent();

            $(parent_tr).addClass('family-editing');

            $(parent_tr).find('input').removeAttr('disabled');
            $(parent_tr).find('select').removeAttr('disabled');

            $(this).parent().html('<a href="javascript:;" class="save-family" data-id="' + id + '" >Save</a> <a href="javascript:;" data-id="' + id + '" class="cancel-family-edit">Cancel</a>');
        });

        $(document).on("click", '.cancel-family-edit', function () {
            let id = $(this).data('id');
            let parent_tr = $(this).parent().parent();

            $(parent_tr).find('input').attr('disabled', 'disabled');
            $(parent_tr).find('select').attr('disabled', 'disabled');

            $(parent_tr).removeClass('family-editing');
            $(this).parent().html('<a href="javascript:;" class="edit-family" data-id="' + id + '" >Edit</a> <a href="javascript:;" class="delete-family"  data-id="' + id + '" >Delete</a>');

        });

        $(document).on("click", '.save-family', function () {
            ajax_edit_save_family_member(this);
            $(this).parent().find('.cancel-family-edit').click();
        });

        $(document).on("click", '.delete-family', function () {

            if (confirm('Are you sure?')) {
                ajax_delete_family_member(this);
                let parent_tr = $(this).parent().parent();
                $(parent_tr).remove();
            }


        });

        $(document).on("click", '.save-new-family', function () {

            let parent_tr = $(this).parent().parent();

            if ($(parent_tr).find('input[name="family_name"]').val() == "") {
                $('.savenew_error').html('Family Name is required');
            } else if ($(parent_tr).find('input[name="family_email"]').val() == "") {
                $('.savenew_error').html('Family Email is required');
            } else if ($(parent_tr).find('input[name="family_age"]').val() == "") {
                $('.savenew_error').html('Family Age is required');
            } else if (!(validateEmail($(parent_tr).find('input[name="family_email"]').val()))) {
                $('.savenew_error').html('Family Email should be valid');
            } else {
                $('.savenew_error').html('');
                ajax_new_save_family_member(this);

                let last_relation = $('.family_relationships .relationships_data tr:last');

                let new_row = $(parent_tr).clone();
                $(new_row).removeClass('add');
                $(new_row).find('select[name="family_relationship"]').val($(parent_tr).find('select[name="family_relationship"]').find(':selected').val());
                $(new_row).find('input[name="family_name"]').val($(parent_tr).find('input[name="family_name"]').val());
                $(new_row).find('input[name="family_email"]').val($(parent_tr).find('input[name="family_email"]').val());
                $(new_row).find('input[name="family_age"]').val($(parent_tr).find('input[name="family_age"]').val());
                $(new_row).find('input[name="family_birthdate"]').val($(parent_tr).find('input[name="family_birthdate"]').val());
                $(new_row).find('td:last').html('<a href="javascript:;" class="edit-family" data-id="735">Edit</a> <a href="javascript:;" class="delete-family" data-id="735">Delete</a></td>');
                $(last_relation).after(new_row);
                if ($(last_relation).hasClass('no-family')) {
                    $(last_relation).remove();
                }

                $(parent_tr).find('input').val('');
            }
        });

        /* $('.edit-family').on('click',function(){
            
            let this_id = $(this).data('id');
            let this_parent_tr = $(this).parent().parent();

            let relationship = $(this_parent_tr).find('td.relationship');
            let old_relationship_html = $(relationship).html();

            let family_name = $(this_parent_tr).find('td.family_name');
            let old_family_name_html = $(family_name).html();
            
            let family_email = $(this_parent_tr).find('td.family_email');
            let old_family_email_html = $(family_email).html();
            
            let family_age = $(this_parent_tr).find('td.family_age');
            let old_family_age_html = $(family_age).html();
            
            let relationship_select = '<select id="family_relationships_' + this_id + '"></select>';
            $(relationship).html(relationship_select);

            $(JSON.parse(family_relationships)).each(function (index, obj) {
                let select = document.getElementById("family_relationships_" + this_id);
                let option = document.createElement("option");
                option.text = obj.name;
                option.value = obj.id;
                select.add(option);
                $(select).val($(relationship).data('id'));
            });

            family_name.html('<input type="text" name="family_name" value="'+old_family_name_html+'">');

            $(this).html('<a href="javascript:;" class="save-family">Save</a> <a href="javascript:;" class="cancel-family-edit">Cancel</a>');
            
        }); */

        showremove_button();

        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);

        if ($('.datetimepicker').length > 0) {
            $('.datetimepicker').datetimepicker({
                minDate: tomorrow,
                format: 'YYYY/MM/DD HH:mm:00'
            });
        }

        if ($('.datetimepicker_interview2').length > 0) {

            // example MySQL DATETIME
            var interview_1_date = $('input[name="interview_1_datetime"]').val();

            var dateTimeParts = interview_1_date.split(/[- :]/); // regular expression split that creates array with: year, month, day, hour, minutes, seconds values
            dateTimeParts[1]--; // monthIndex begins with 0 for January and ends with 11 for December so we need to decrement by one

            var interview_1_date = new Date(...dateTimeParts); // our Date object

            $('.datetimepicker_interview2').datetimepicker({
                minDate: interview_1_date,
                format: 'YYYY/MM/DD HH:mm:00'
            });
        }


        if ($('.timepicker_range').length > 0) {
            $('.timepicker_range').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                format: 'DD/MM/YYYY h:mm A'
            });
        }

        $('.timepicker').timepicker();

        $(".ilinks_sortable").sortable({ revert: true });


        //image popup (admincms)
        $(".modelImage").colorbox({});


        if (controller == "admincms/managewhatwedo/") {
            $("textarea[name='short_desc']").wordCountLimit({

                maxlength: "100",
                "divClassName": "count_short_desc",

            });
        }


        if (controller == "admincms/manageconferencepresenters/") {
            //manageconferencepresenters_conferencetopicsselection( "view" );
            //manageconferencepresenters_conferencetopicsselection( "edit" );

            if ($('#topics').length > 0) {
                $('#topics').selectize({
                    persist: false,
                    createOnBlur: true,
                    create: true
                });
            }

        }


        if (controller == "admincms/manageconference/") {
            $("select[name='countryid']").change(function () {

                ajax_sightseeing_with_country($("select[name='countryid']"));

            });
        }

        if (controller == "admincms/manageshortconference/") {
            $("select[name='countryid']").change(function () {

                ajax_sightseeing_with_country($("select[name='countryid']"));

            });
        }


        if (controller == "admincms/manageconferenceprices/") {


            var radio_inputs = $("tr.members input[type='text'], tr.others input[type='text']");
            radio_inputs.attr("disabled", true);


            $('input[type="radio"]').on('ifChecked', function (event) {

                toggle_confpricetypes(radio_inputs, $(this));

            });

            if (is_post) {

                toggle_confpricetypes(radio_inputs, $("input[name='paymenttype_key']:checked"));
            }

            $("select[name='conferenceid']").change(function () {

                ajax_whoattend_by_conferenceid($("select[name='conferenceid']"));

            });
        }


        if (controller == "admincms/managecmscontent/") {
            $("select[name='menuid']").change(function () {

                // ajax_cmstype_with_cmsmenu($("select[name='menuid']"));
                ajax_cmstype_with_cmsmenu_by_lang($("select[name='menuid']"));

            });
        }


        if (controller == "admincms/managesitebanners/") {
            $("select[name='typeid']").change(function () {

                ajax_cmstype_with_typeid($("select[name='typeid']"));

            });
        }


        if (controller == "admincms/managecmsmenus/") {

            $("select[name='positionid']").change(function () {

                ajax_cmsmenu_with_position($("select[name='positionid']"));

            });
        }


        if (controller == "admincms/manageposts/") {

            $("select[name='forum']").change(function () {

                ajax_cmstopic_with_forum($("select[name='forum']"));

            });
        }


        if (controller == "admincms/manageconferencecontent/") {
            $("select[name='menuid']").change(function () {

                ajax_conferencetype_with_conferencemenu($("select[name='menuid']"));

            });
        }


        if (controller == "admincms/manageabstractsubmissionforms/") {
            if ($("input[name='TMP_assignedto_ids']").length > 0) {
                var data = $("input[name='TMP_assignedto_ids']").val();

                var _result = JSON.parse(data);
                for (var i = 0; i < _result.length; i++) {

                    var _sel_elem = $("select[name='assignedto[]'] option[value='" + _result[i] + "']");
                    _sel_elem.text(_sel_elem.text() + " - (already assigned)");
                    _sel_elem.attr("disabled", true);
                }

            }
        }


        render_numericonly();


    });


    //set navigation class active on current page
    if ($("aside section.content-header h1").length > 0) {
        var c1_text = $("aside section.content-header h1").html().trim();

        if ($("ul.sidebar-menu li:contains('" + c1_text + "')").length > 0) {
            $("ul.sidebar-menu li").attr("class", "");
            $("ul.sidebar-menu li:contains('" + c1_text + "')").each(function () {


                if ($(this).find(" > a span").html().trim() == c1_text) {
                    $(this).attr("class", "active");


                    if ($(this).parent().attr("class") == "treeview-menu") {
                        $(this).parent().parent().attr("class", "active");
                        $(this).parent().slideDown("slow");
                    }

                }


            });
        }
    }


    if ($("div.testi_bottom_area ul.ulstyleone").length > 0) {
        if ($("div.right_area > h1.h1Style2").length > 0) {
            var c1_text = $("div.right_area > h1.h1Style2").html().trim();

            if ($("div.testi_bottom_area ul.ulstyleone li:contains('" + c1_text + "')").length > 0) {
                $("div.testi_bottom_area ul.ulstyleone li").attr("class", "");
                $("div.testi_bottom_area ul.ulstyleone li:contains('" + c1_text + "')").each(function () {


                    if ($(this).find(" > a").html().trim() == c1_text) {
                        $(this).find(" > a").attr("class", "active");


                        if ($(this).parent().attr("class") == "treeview-menu") {
                            $(this).parent().parent().attr("class", "active");
                            $(this).parent().slideDown("slow");
                        }

                    }


                });
            }
        }
    }


    $(document).on("click", ".submit_btn_form", function () {


        var operation = $(this).attr("data-operation");

        if (operation == "delete") {
            $(".box-body.table-responsive form:first").submit();
        }
        else if (operation == "copy") {
            $("input[name='options']").val(operation);

            var copy_id = $(this).parent().parent().find('input[type="checkbox"]').val();
            var input = $(document.createElement('input'));
            input.css('display', 'none');
            input.attr("name", "copy_id");
            input.val(copy_id);

            var copy_content_input = $(document.createElement('input'));
            copy_content_input.attr("type", "hidden");
            copy_content_input.attr("name", "copy_content");
            copy_content_input.val("0");

            var conf_id_input = $(document.createElement('input'));
            conf_id_input.attr("type", "hidden");
            conf_id_input.attr("name", "conf_id");
            conf_id_input.val("0");

            // confirm content copy
            if (!$(this).hasClass("con")) {

                $("#dialog-confirm-yes-no").dialog({
                    resizable: false,
                    modal: true,
                    buttons: {
                        "Yes": function () {

                            $(this).dialog("close");

                            // select conference
                            $("#dialog-select-conference").dialog({
                                resizable: false,
                                modal: true,
                                buttons: {
                                    "Confirm": function () {

                                        conf_id_input.val($('select[name="dialogconfid"]').val());
                                        $(this).dialog("close");

                                        // confirm content copy
                                        $("#dialog-confirm-content-copy").dialog({
                                            resizable: false,
                                            modal: true,
                                            buttons: {
                                                "Yes": function () {

                                                    copy_content_input.val("1");
                                                    $(this).dialog("close");

                                                    $(".box-body.table-responsive form").append(input);
                                                    $(".box-body.table-responsive form").append(copy_content_input);
                                                    $(".box-body.table-responsive form").append(conf_id_input);

                                                    $(".box-body.table-responsive form").submit();


                                                },
                                                "No": function () {

                                                    copy_content_input.val("0");
                                                    $(this).dialog("close");

                                                    $(".box-body.table-responsive form").append(input);
                                                    $(".box-body.table-responsive form").append(copy_content_input);
                                                    $(".box-body.table-responsive form").append(conf_id_input);

                                                    $(".box-body.table-responsive form").submit();

                                                }
                                            },
                                            close: function () {
                                                $(this).dialog("close");
                                            }
                                        });

                                    }
                                }
                            });
                        },
                        "No": function () {
                            $(this).dialog("close");
                        }
                    }
                });

            } else {

                $(".box-body.table-responsive form").append(input);
                $(".box-body.table-responsive form").append(copy_content_input);
                $(".box-body.table-responsive form").append(conf_id_input);

                $(".box-body.table-responsive form").submit();

            }
        }
        else if (operation == "ajax_save_record") {
            $("input[name='options']").val(operation);

            $("textarea[name='update_textboxes']").val($("textarea[name='update_textboxes']").val().substr(1));

            $("table#tbl_records_serverside textarea").not($($("textarea[name='update_textboxes']").val())).prop("disabled", true);

            $("textarea[name='update_textboxes']").prop("disabled", false);


            $(".box-body.table-responsive form").submit();
        }
        else if (operation == "ajax_update_sorting") {
            $("input[name='options']").val(operation);

            $(".box-body.table-responsive form").submit();
        }
        else if (operation == "ajax_download_csv" || operation == "ajax_download_paypalcsv" || operation == "ajax_download_payeezycsv" || operation == "ajax_get_data") {
            $("input[name='options']").val(operation);

            $(".box-body.table-responsive form").submit();
        }
        else if (operation == "reject") {
            $("input[name='options']").val(operation);

            $(".box-body.table-responsive form").submit();
        }
        else if (operation == "approve") {
            $("input[name='options']").val(operation);

            $(".box-body.table-responsive form").submit();
        }

    });


    var $tblRecordsServerside = $('#tbl_records_serverside');
    if ($tblRecordsServerside.length > 0) {
        var ajax_url = site_url + controller + "controls/view/1";

        var TMP_order_to = 10;
        var TMP_order_by = "desc";

        if (controller == "account/browseimimembers/") {
            //TMP_order_to		= 3;
            //TMP_order_by		= "asc";
            ajax_url = site_url + controller + "controls/search/1";
        }

        var oInitServerside = {
            "processing": true,
            "serverSide": true,
            "searchDelay": 2000,
            "fnDrawCallback": function (e) {


            },
            'sPaginationType': 'full_numbers',
            "order": [[TMP_order_to, TMP_order_by]],
            "ajax": $.fn.dataTable.pipeline({
                url: ajax_url,
                pages: 5, // number of pages to cache
                "type": "POST",
                "data": function (d) {
                    d.search_name = $("input[name='name']").val();
                    d.search_occupation = $("select[name='occupation']").val();
                    d.search_location = $("select[name='location']").val();
                    d.search_keyword = $("input[name='keyword']").val();
                }
            }),
        };
        if ($tblRecordsServerside.is('[data-tbl_records_serverside_additional_options-var]')) {
            oInitServerside = $.extend(oInitServerside, eval($tblRecordsServerside.data('tbl_records_serverside_additional_options-var')));
        }
        var oTable = $tblRecordsServerside.dataTable(oInitServerside);


        $('#tbl_records_serverside_filter input').unbind();
        $('#tbl_records_serverside_filter input').bind('keyup', function (e) {

            var table = $('#tbl_records_serverside').DataTable();
            if (e.keyCode == 13) {

                table.search(this.value).draw();
            }
        });


    }
    // To change later
    if ( $.fn.dataTable.isDataTable( '#tbl_records' ) ) {
        if ($("#tbl_records")) {
            var tble = $("#tbl_records");
            var bFilter = true;
            var bLengthChange = true;
            var bPaginate = true;
    
    
            var TMP_order_to = 0;
            var TMP_order_by = "desc";
            if (controller == "admincms/manageconferenceregistration/" || controller == "account/manageconferenceregistration/") {
                TMP_order_to = 2;
                TMP_order_by = "desc";
            }
    
    
            if (tble.hasClass("bFilter")) {
                bFilter = false;
            }
            if (tble.hasClass("bLengthChange")) {
                bLengthChange = false;
            }
            if (tble.hasClass("bPaginate")) {
                bPaginate = false;
            }
    
            var oInit = {
                "deferRender": true,
                'bProcessing': true,
                "order": [[TMP_order_to, TMP_order_by]],
    
                "pageLength": 50,
                "bFilter": bFilter,
                "bLengthChange": bLengthChange,
                "bPaginate": bPaginate,
    
                'sPaginationType': 'full_numbers',
                /*"aoColumnDefs":	[
                                  { 'bSortable': false, 'aTargets': [ 0 ] }
                                ]*/
    
            };
            if (tble.is('[data-tbl_records_additional_options-var]')) {
                oInit = $.extend(oInit, eval(tble.data('tbl_records_additional_options-var')));
            }
            var oTable = tble.dataTable(oInit);
    
    
            $('#tbl_records_filter input').unbind();
            $('#tbl_records_filter input').bind('keyup', function (e) {
    
                if (e.keyCode == 13) {
                    oTable.fnFilter(this.value);
                }
            });
    
            var search = getParameterByName('search');
    
            if (null != search) {
                oTable.fnFilter(search);
            }
        }
    }else{

        build_datatable();
    }

  


    if ($tblRecordsServerside.length > 0 || $("#tbl_records").length > 0) {
        //when press enter don't submit form -
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    }


    //admincms/manageresorts
    if ($('input[name="registration_from"]') && ('input[name="registration_to"]')) {
        $("#registration_from").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 3,
            onClose: function (selectedDate) {
                $("#registration_to").datepicker("option", "minDate", selectedDate);
            }
        });


        $("#registration_to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 3,
            onClose: function (selectedDate) {
                $("#registration_from").datepicker("option", "maxDate", selectedDate);
            }
        });
    }

    if ($('input[name="duration_from"]') && ('input[name="duration_to"]')) {
        $("#last_minute_start").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 3,
            onClose: function (selectedDate) {
                $("#last_minute_end").datepicker("option", "minDate", selectedDate);
            }
        });


        $("#last_minute_end").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 3,
            onClose: function (selectedDate) {
                $("#last_minute_start").datepicker("option", "maxDate", selectedDate);
            }
        });
    }


    /*
    2 types of datepicker
    - .datepicker (only shows datepicker)
    - .data-datemode (shows with start-end date)
    */


    if ($(".datepicker").length > 0) {
        $(".datepicker").datepicker({ dateFormat: "dd-mm-yy" });
    }

    if ($(".membership_date").length > 0) {
        $(".membership_date").datepicker({
            dateFormat: "yy-mm-dd 00:00:00",
            onSelect: function (date) {
                var per = update_membership_dates();

                if ($(this).is("#membership_expiry")) {
                    if (per == 'year' || per == 'yearly') {
                        var ending_date = $('#membership_expiry').val();
                        var starting_date = getPrevYearDate(ending_date);
                        $('#membership_date_purchased').val(starting_date);
                    } else if (per == 'life' || per == 'lifetime') {
                        $('#membership_expiry').val(getLifetimeDate());
                    }
                } else {
                    if (per == 'year' || per == 'yearly') {
                        var started_date = $('#membership_date_purchased').val();
                        var ending_date = getNextYearDate(started_date);
                        $('#membership_expiry').val(ending_date);
                    } else if (per == 'life' || per == 'lifetime') {
                        $('#membership_expiry').val(getLifetimeDate());
                    }
                }
            }
        });
    }

    if ($(".birthdate_datepicker").length > 0) {
        $(".birthdate_datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: '-13 months',
            maxDate: '0 years',
            yearRange: "-100:+0", // last hundred years
            changeMonth: true,
            changeYear: true,
            onClose: function (selectedDate) {
                $(this).parent().parent().find('input[name="family_age"]').val(_calculateAge(new Date(selectedDate)));
            }
        });
    }

    $('input[name="family_age"]').on('change', function () {
        let age = $(this).val();

        let d = new Date();
        let bY = d.getFullYear() - age;
        let bM = d.getMonth();
        let bD = d.getDate();
        $(this).parent().parent().find('.birthdate_datepicker').val(bY + '-' + bM + '-' + bD);
    });


    if ($('input[name="registration_from"]') && ('input[name="registration_to"]')) {
        $("#registration_from").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 3,
            onClose: function (selectedDate) {
                $("#registration_to").datepicker("option", "minDate", selectedDate);
            }
        });


        $("#registration_to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 3,
            onClose: function (selectedDate) {
                $("#registration_from").datepicker("option", "maxDate", selectedDate);
            }
        });
    }


    //when click on calendar icon - show datepicker
    $("i.fa-calendar").click(function () {

        $(this).parent().parent().find("input").datepicker("show");

    });


    if ($("input[data-datemode='start']") && $("input[data-datemode='end']")) {
        $("input[data-datemode='start']").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 2,
            onClose: function (selectedDate) {
                $("input[data-datemode='end']").datepicker("option", "minDate", selectedDate);
            }
        });


        $("input[data-datemode='end']").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 2,
            onClose: function (selectedDate) {
                $("input[data-datemode='start']").datepicker("option", "maxDate", selectedDate);
            }
        });
    }


    if ($("input[data-datemode='start_1']") && $("input[data-datemode='end_1']")) {
        $("input[data-datemode='start_1']").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 2,
            onClose: function (selectedDate) {
                $("input[data-datemode='end_1']").datepicker("option", "minDate", selectedDate);
            }
        });


        $("input[data-datemode='end_1']").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            numberOfMonths: 2,
            onClose: function (selectedDate) {
                $("input[data-datemode='start_1']").datepicker("option", "maxDate", selectedDate);
            }
        });
    }


    // admin left menu search

    // extend jquery for 'containsi' (case insensitive)
    $.extend($.expr[':'], {
        'containsi': function (elem, i, match, array) {
            return (elem.textContent || elem.innerText || '').toLowerCase()
                .indexOf((match[3] || "").toLowerCase()) >= 0;
        }
    });

    $('input[name="q"]').bind("keyup", function () {

        var tval = $(this).val();

        if ($("ul.sidebar-menu li").hide().filter(":containsi('" + tval + "')").find('li').andSelf().show()) {

            $("ul.sidebar-menu li ul.treeview-menu li").hide().filter(":containsi('" + tval + "')").find('li').andSelf().show();

        }

        if ($('li[style="display: list-item;"]').find('ul.treeview-menu').find('li[style="display: list-item;"]').length == 0) {
            $('li[style="display: list-item;"]').find('ul.treeview-menu').find('li').css('display', 'list-item');
        }

    });



});
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function _waiting_screen(mode1, mode2) {
    if (mode2 == null) {

    }

    if ((mode1 == "show") || (mode1 == "in")) {


        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });


        $(".waiting_screen").show();
    }
    else if (mode1 == "hide") {
        $('.blockOverlay').attr('title', 'Click to unblock').click($.unblockUI);

        $('.blockOverlay').click();

        $(".waiting_screen").fadeOut("slow");
    }

}

function _runtimePopup(mode, url) {

    if ((mode == "!!")) {
        $.colorbox({ href: url, iframe: true, width: "40%", height: "50%" });
        return;
    }
    else if ((mode == "modalUrl")) {

        $.colorbox({ href: url, iframe: true, width: "50%", height: "100%" });
        return;
    }
    else if ((mode == "modalUrl_80perc")) {

        $.colorbox({ href: url, iframe: true, width: "80%", height: "100%" });
        return;
    }
    else if ((mode == "modalImage")) {

        $.colorbox({ href: url, photo: true });
        return;
    }
    else if ((mode == "modalVideo")) {

        $.colorbox({ href: url, iframe: true, innerWidth: 640, innerHeight: 390 });
        return;
    }


}


function remImage(remove_id) {
    var tmp = $("input[id='" + remove_id + "']").val('');
    tmp.parent().find("small." + remove_id).remove();
}

function render_textarea(elem) {
    if (elem == null) {
        elem = $("textarea[class='ckeditor1']");
    }
    else {
        var editor = CKEDITOR.instances[elem.attr("name")];
        if (editor) {
            editor.destroy(true);
        }
    }


    elem.each(function () {

        CKEDITOR.replace($(this).attr("name"),
            {
                filebrowserBrowseUrl: base_url + "assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Connector=" + base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php",
                filebrowserImageBrowseUrl: base_url + "assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=" + base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php",
                filebrowserFlashBrowseUrl: base_url + "assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=" + base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php",
                filebrowserUploadUrl: base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=File",
                filebrowserImageUploadUrl: base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image",
                filebrowserFlashUploadUrl: base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash"
            });

    });

}

function _calculateAge(birthday) { // birthday is a date
    var today = new Date();
    var birthDate = new Date(birthday);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

function operation_menus_boxes(mode, elem) {
    if (elem == null) {

    }

    if (mode == "add") {
        var tr = $(".add_menus_boxes:last");

        var _clone = tr.clone();


        _clone.attr("class", "add_menus_boxes " + $(".add_menus_boxes").length);
        _clone.find("input").val("");


        $(".add_menus_boxes:last").after(_clone);


    }
    else if (mode == "remove") {
        elem.parent().parent().parent().parent().parent().parent().remove();
    }
}


function showremove_button() {

    if ((controller == 'admincms/managewherewework/') || (controller == 'admincms/managechapterlocation/') || (controller == 'admincms/managecampaigncontent/')) {
        $(".columndelete").parent().find("td").parent().not(":first").find(".columndelete span").addClass("display-block");
    }
}

function operation_menus_boxes_for_conference_program(mode, elem) {
    if (elem == null) {

    }

    if (mode == "add") {


        var tr = elem.parent().parent().parent().parent().find(".add_menus_boxes:last");

        var _clone = tr.clone();


        _clone.attr("class", "add_menus_boxes " + elem.parent().parent().parent().parent().find(".add_menus_boxes").length);
        _clone.find("input").val("");
        _clone.find('.timepicker').timepicker();


        tr.after(_clone);


        render_numericonly();
        showremove_button();

        /*elem.parent().parent().parent().parent().find(".columndelete span").addClass("display-block");
        elem.parent().parent().parent().parent().find(".columndelete:first span").removeClass("display-block");*/


    }
    else if (mode == "remove") {
        elem.parent().parent().parent().remove();
    }
}


function submit_action(data, target) {

    var _result = JSON.parse(data);

    if (_result._redirect_to == "") {

        if ((_result._call_name == 'cmstype_with_cmsmenu') || (_result._call_name == 'cmstype_with_typeid')) {

            $(target).html(_result._TEXT_show_messages);

            if ("_languages" in _result) {
                _result._languages.forEach(lang => {
                    render_textarea($("textarea[name='content[" + lang['code'] + "]']"));
                });
            } else {
                render_textarea($("textarea[name='content']"));
            }

            _waiting_screen("hide");

        }


        else if (_result._call_name == 'cmsmenu_with_position') {

            $(target).html(_result._TEXT_show_messages);
            //render_textarea( $("textarea[name='content']") );

            _waiting_screen("hide");

        }


        else if (_result._call_name == 'conferencetype_with_conferencemenu') {

            $(target).html(_result._TEXT_show_messages);
            render_textarea($("textarea[name='content']"));

            _waiting_screen("hide");

        }


        else if (_result._call_name == 'sightseeing_with_country') {

            $(target).html(_result._TEXT_show_messages);
            render_icheckbox();
            _waiting_screen("hide");

        }


        else if (_result._call_name == 'whoattend_by_conferenceid') {

            $(target).html(_result._TEXT_show_messages);
            _waiting_screen("hide");


        }

        else if (_result._call_name == 'conference_program_table_by_conferenceid') {

            $(target).html(_result._TEXT_show_messages);
            $('.timepicker').timepicker();
            render_icheckbox();
            render_numericonly();
            _waiting_screen("hide");


        }

        else if ( _result._call_name  == 'whoattend_by_short_conferenceid' ||  _result._call_name  == 'short_conferenceregion_by_conferenceid' ||  _result._call_name  == 'short_conferencepriceparent_by_conferenceid_whoattendid_regionid' || _result._call_name  == 'short_conferencetype_by_conferenceid')
		{
			
			$( target ).html( _result._TEXT_show_messages );
			_waiting_screen( "hide" );
			
			
		}

        else if (_result._call_name == 'conferencetopics_by_conferenceid') {

            $(target).html(_result._TEXT_show_messages);
            render_icheckbox();

            $(".ilinks_sortable").sortable({ revert: true });

            _waiting_screen("hide");

        }
        /******     Forum       ******/
        else if (_result._call_name == 'cmsposts_with_forum') {

            $(target).html(_result._TEXT_show_messages);
            _waiting_screen("hide");

        }
        /******     Save Family       ******/
        else if (_result._call_name == 'edit_save_family_member') {

            _waiting_screen("hide");

        }

        else if ( _result._call_name  == 'ajax_conference_content_with_conferenceid')
		{
			
			$( target ).html( _result._TEXT_show_messages );
			//render_textarea( $("textarea[name='content']") );
			
			build_datatable();
			
		}
    }
}


function getMoreTopics(id) {

    var this_site = "ajaxmethods/getMoreTopics/";
    var url = base_url + this_site;
    var pars = '';
    var target = '#ul_topic' + id + '';

    var limit_data = parseInt($("#last_limit" + id).val());
    //alert(limit_data);
    var last_limit_data = limit_data;
    console.log(last_limit_data);
    $('#last_limit' + id).val(limit_data + 3);

    $.ajax({

        type: "POST",
        url: url,
        data: "forumid=" + id + '&last_limit=' + last_limit_data,

        success: function (response) {

            $(target).append(
                $(response)
                    .find('.actions')
                    .hide()
                    .end()
            );

            var limit_data = parseInt($("#last_limit" + id).val());

            $.ajax({
                type: "POST",
                url: url,
                data: "forumid=" + id + '&last_limit=' + limit_data,

                success: function (data) {

                    if (data == false) $('#btnViewMore' + id).hide();
                }
            });
        }
    });


}

/*document.onkeydown=function(evt){
    //alert("alert");
    var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
    if(keyCode == 13)
    {

      $("#cmt").val('');
      $("form").submit();

    }
}*/

function sortby() {
    location.href = $("#sort").val();
}


function remPdf(this_elem) {

    var this_site = "ajaxmethods/remNewspdf/";
    var url = base_url + this_site;
    var pdfPath = $(this_elem).attr('data-pdfurl');
    var parent = $(this_elem).parent();

    $.ajax({

        type: "POST",
        url: url,
        data: "pdfPath=" + pdfPath,

        success: function (response) {

            $(parent).remove();

        }

    });
}

function setEditTopicid(id) {

    //	console.log(id);

    var this_site = "ajaxmethods/setEditPostDetail/";
    var url = base_url + this_site;
    var pars = '';

    $.ajax({

        type: "POST",
        url: url,
        dataType: 'json',
        data: "id=" + id,

        success: function (response) {


            var data = response.json;

            $("#topicid").val(data[0].topic_id);
            $("#id").val(data[0].id);
            $("#edit").val("edit");
            $("#post_name").val(data[0].name);
            $("#post_description").val(data[0].description);

        }

    });


}

function remVideo(this_elem) {

    var this_site = "ajaxmethods/remNewsVideo/";
    var url = base_url + this_site;
    var videoPath = $(this_elem).attr('data-videourl');
    var parent = $(this_elem).parent();

    $.ajax({
        type: "POST",
        url: url,
        data: "videoPath=" + videoPath,

        success: function (response) {
            $(parent).remove();

        }
    });
}

function setEditForumid(topicid) {

    var this_site = "ajaxmethods/getEditTopicDetail/";
    var url = base_url + this_site;
    var pars = '';
    var id = topicid;

    $.ajax({

        type: "POST",
        url: url,
        dataType: 'json',
        data: "id=" + id,

        success: function (response) {

            var data = response.json;

            $("#forumid").val(data[0].frmid);
            $("#id").val(data[0].id);
            $("#edit").val("edit");
            $("#topic_name").val(data[0].name);
            $("#topic_description").val(data[0].description);
        }

    });

}

$(document).on('change', '.profile_image', function () {
    var files = $(this).prop('files')[0];
    var nonce = $('input[name="profile-nonce"]').val();

    var formdata = new FormData();
    formdata.append('profile_image', files);
    formdata.append('nonce', nonce);

    var this_site = "ajaxmethods/upload_profile_picture/";
    var url = base_url + this_site;

    $.ajax({
        method: 'POST',
        url: url,
        data: formdata,
        dataType: 'JSON',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('.profile-loader').fadeIn();
        },
        complete: function () {
            $('.profile-loader').fadeOut();
        },
        success: function (response) {
            if (response.success) {
                $('.profile_image_wrap .memImg').html(response.html);
            } else {
                alert(response.message);
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
});

function getCurrentFormattedDate() {
    var current_date = new Date();
    return (current_date.getFullYear()) + "-" + ("0" + (current_date.getMonth() + 1)).slice(-2) + "-" + ("0" + current_date.getDate()).slice(-2) + " " + current_date.getHours() + ":" + current_date.getMinutes() + ":" + current_date.getSeconds();
}

function getNextYearDate(date) {
    var new_date = new Date(date);
    return (new_date.getFullYear() + 1) + "-" + ('0' + (new_date.getMonth() + 1)).slice(-2) + "-" + ("0" + new_date.getDate()).slice(-2) + " " + ("0" + new_date.getHours()).slice(-2) + ":" + ("0" + new_date.getMinutes()).slice(-2) + ":" + ("0" + new_date.getSeconds()).slice(-2);
}

function getPrevYearDate(date) {
    var new_date = new Date(date);
    return (new_date.getFullYear() - 1) + "-" + ('0' + (new_date.getMonth() + 1)).slice(-2) + "-" + ("0" + new_date.getDate()).slice(-2) + " " + ("0" + new_date.getHours()).slice(-2) + ":" + ("0" + new_date.getMinutes()).slice(-2) + ":" + ("0" + new_date.getSeconds()).slice(-2);
}

function getLifetimeDate() {
    return "9999-12-31 00:00:00";
}

$(document).on('change', '#membership_package_id', function () {
    var per = update_membership_dates();

    if (per == 'year' || per == 'yearly') {
        var started_date = $('#membership_date_purchased').val();
        var ending_date = getNextYearDate(started_date);
        $('#membership_expiry').val(ending_date);
    } else if (per == 'life' || per == 'lifetime') {
        $('#membership_expiry').val(getLifetimeDate());
    }
});

$(document).on('click input', '#membership_date_purchased', function () {
    var per = update_membership_dates();

    if (per == 'year' || per == 'yearly') {
        var started_date = $('#membership_date_purchased').val();
        var ending_date = getNextYearDate(started_date);
        $('#membership_expiry').val(ending_date);
    } else if (per == 'life' || per == 'lifetime') {
        $('#membership_expiry').val(getLifetimeDate());
    }
});

$(document).on('click input', '#membership_expiry', function () {
    var per = update_membership_dates();

    if (per == 'year' || per == 'yearly') {
        var ending_date = $('#membership_expiry').val();
        var starting_date = getPrevYearDate(ending_date);
        $('#membership_date_purchased').val(starting_date);
    } else if (per == 'life' || per == 'lifetime') {
        $('#membership_expiry').val(getLifetimeDate());
    }
});

function update_membership_dates() {
    if ($('#membership_package_id').val() == "") {
        $('#membership_date_purchased').val($('input[name="current_membership_date_purchased"]').val());
        $('#membership_expiry').val($('input[name="current_membership_expiry"]').val());
    }

    var per = $('#membership_package_id').find('option:selected').data('per').toLowerCase();

    if ($('#membership_date_purchased').val() == "" && $('#membership_expiry').val() == "") {

        $('#membership_date_purchased').val(getCurrentFormattedDate());

        if (per == 'year' || per == 'yearly') {
            var started_date = $('#membership_date_purchased').val();
            var ending_date = getNextYearDate(started_date);
            $('#membership_expiry').val(ending_date);

        } else if (per == 'life' || per == 'lifetime') {
            $('#membership_expiry').val(getLifetimeDate());
        }

    } else if ($('#membership_date_purchased').val() == "") {

        if ($('#membership_expiry').val() == "9999-12-31 00:00:00") {
            $('#membership_date_purchased').val(getCurrentFormattedDate());
            var started_date = $('#membership_date_purchased').val();
            var ending_date = getNextYearDate(started_date);
            $('#membership_expiry').val(ending_date);
        } else {
            if (per == 'year' || per == 'yearly') {

                var ending_date = $('#membership_expiry').val();
                var starting_date = getPrevYearDate(ending_date);
                $('#membership_date_purchased').val(starting_date);

            } else if (per == 'life' || per == 'lifetime') {

                $('#membership_expiry').val(getLifetimeDate());
                $('#membership_date_purchased').val(getCurrentFormattedDate());
            }
        }

    } else if ($('#membership_expiry').val() == "") {
        if (per == 'year' || per == 'yearly') {
            var started_date = $('#membership_date_purchased').val();
            var ending_date = getNextYearDate(started_date);
            $('#membership_expiry').val(ending_date);

        } else if (per == 'life' || per == 'lifetime') {
            $('#membership_expiry').val(getLifetimeDate());
        }
    }

    return per;
}

$(document).ready(function (e) {
    $('input[name="add_belongs_country"]').on('ifChanged', function () {
        if (this.checked) {
            $('.paypal-account').show();
        } else {
            $('.paypal-account').hide();
        }
    })
    $('input[name="is_separate"]').on('ifChanged', function () {
        if (this.checked) {
            $('.paypal-account-details').show();
        } else {
            $('.paypal-account-details').hide();
        }
    })

    if ( controller == "admincms/manageshortconferencewhoattend/" )
    {
        $("select[name='conferenceid']").change(function(){
                                                    
            ajax_short_conferencetype_by_conferenceid( $("select[name='conferenceid']") );
            
        });
    }

    if ( controller == "admincms/manageshortconferenceprices/" )
    {
        
        
        var radio_inputs		= $("tr.members input[type='text'], tr.others input[type='text']");
        radio_inputs.attr("disabled", true);
        
        
        $('input[type="radio"]').on('ifChecked', function(event){
                                            
            toggle_confpricetypes(radio_inputs, $(this) );		
            
        });
        
        if ( is_post )
        {
            
            toggle_confpricetypes(radio_inputs, $("input[name='paymenttype_key']:checked") );	
        }
        
        
        
        $("select[name='conferenceid']").change(function(){
                                                    
            //ajax_whoattend_by_short_conferenceid( $("select[name='conferenceid']") );
            ajax_short_conferenceregion_by_conferenceid( $("select[name='conferenceid']") );
            
        });
        
        $(document).on('change', 'select[name="regionid"]', function() { 
        
            ajax_whoattend_by_short_conferenceid( $("select[name='conferenceid']"),
                                            $("select[name='regionid']") );
            
        });
        
        //$(document).on('change', 'select[name="regionid"], select[name="whoattendid"]', function() {
        $(document).on('change', 'select[name="whoattendid"]', function() { 
        
            ajax_short_conferencepriceparent_by_conferenceid_whoattendid_regionid	( 	$("select[name='conferenceid']"), 
                                                                                $("select[name='whoattendid']"), 
                                                                                $("select[name='regionid']")
                                                                            );
            
            
        });


        
    }
});
function ajax_whoattend_by_short_conferenceid( this_elem, region_elem )
{
	_waiting_screen("show");
	
	var this_site			= "ajaxmethods/whoattend_by_short_conferenceid/";
	//var url 				= base_url + this_site + this_elem.val();
	var url 				= base_url + this_site + this_elem.val() + "/" +  region_elem.val();
	var pars 				= '';
	var target 				= '.targetBox_other';	
	
	

	$.ajax({
	  	type: "POST",
	  	url: url,
	  	data: "",
		success: function(response) {
			
			
			submit_action( response, target );
			
		}

	});	
	
}
function ajax_short_conferencetype_by_conferenceid( this_elem )
{
	_waiting_screen("show");
	
	var this_site			= "ajaxmethods/short_conferencetype_by_conferenceid/";
	var url 				= base_url + this_site + this_elem.val();
	var pars 				= '';
	var target 				= '.targetBox_typeid';	
	
	

	$.ajax({
	  	type: "POST",
	  	url: url,
	  	data: "",
		success: function(response) {
			
			
			submit_action( response, target );
			
		}

	});	
	
}

function ajax_short_conferenceregion_by_conferenceid( this_elem )
{
	_waiting_screen("show");
	
	var this_site			= "ajaxmethods/short_conferenceregion_by_conferenceid/";
	var url 				= base_url + this_site + this_elem.val();
	var pars 				= '';
	var target 				= '.targetBox_regionid';	
	
	

	$.ajax({
	  	type: "POST",
	  	url: url,
	  	data: "",
		success: function(response) {
			
			
			submit_action( response, target );
			
		}

	});	
	
}
function ajax_short_conferencepriceparent_by_conferenceid_whoattendid_regionid( conf_elem, whoattend_elem, region_elem )
{
	_waiting_screen("show");

    whoattend_elem_val = whoattend_elem.val();

    if(whoattend_elem_val == ''){
        whoattend_elem_val = null;
    }

    var this_site			= "ajaxmethods/short_conferencepriceparent_by_conferenceid_whoattendid_regionid/";
	var url 				= base_url + this_site + conf_elem.val() + "/" + whoattend_elem_val + "/" + region_elem.val();
	var pars 				= '';
	var target 				= '.targetBox_parentid';	
	
	$.ajax({
	  	type: "POST",
	  	url: url,
	  	data: "",
		success: function(response) {
			
			
			submit_action( response, target );
			
		}

	});	
	
}

function build_datatable()
{
	if ( $("#tbl_records") )
	{
		var tble				= $("#tbl_records, #tbl_records1");
		var bFilter				= true;
		var bLengthChange		= true;
		var bPaginate			= true;
		var bSortable			= true;
		
		
		
		
		var TMP_order_to		= 0;
		var TMP_order_by		= "desc";
		if ( controller == "admincms/manageshortconferenceregistration/" || controller == "account/manageshortconferenceregistration/" )
		{
			TMP_order_to		= 3;
			TMP_order_by		= "desc";
		}
		
		
		if ( tble.hasClass("bFilter") )
		{
			bFilter				= false;
		}
		if ( tble.hasClass("bLengthChange") )
		{
			bLengthChange		= false;
		}
		if ( tble.hasClass("bPaginate") )
		{
			bPaginate			= false;
		}
		if ( tble.hasClass("bSortable") )
		{
			bSortable			= false;
		}
		var oTable = tble.dataTable({
            // 'destroy': true,
            /* 'retrieve': true,
            'paging': false, */
			 'bProcessing': true,
           	"order": [[ TMP_order_to, TMP_order_by ]],
				
			"pageLength": 50,
			"bFilter" : bFilter,               
			"bLengthChange": bLengthChange,
			"bPaginate": bPaginate,
			"bSort": bSortable,

            'sPaginationType': 'full_numbers',
			/*"aoColumnDefs":	[
							  { 'bSortable': false, 'aTargets': [ 0 ] }
							]*/
				  
		});
		
		
		function format ( d ) {
			console.log(d);
			
			
			
			
			// `d` is the original data object for the row
			return '<table id="tbl_records1" class="table "><thead><tr><th></th></tr></thead><tbody><tr><td>ABVS</td></tr></tbody><tfoot></tfoot></table>';
		}

		
		// Add event listener for opening and closing details
		 $("#tbl_records tbody").on('click', 'td.details-control', function () {
			

			var parent_this			= $(this);
			var tr = parent_this.closest('tr');
			
			
			var row = oTable.api().row( tr );
	 
			if ( row.child.isShown() ) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			}
			else {
				
				_waiting_screen("show")
				
				// Open this row
				var this_site			= base_url ;
				
				
				if ( controller == "admincms/manageshortconferenceprices/" )
				{
					this_site			+= "ajaxmethods/ajax_datatable_conferenceprice_addons/" + row.data()[2];
				}
				
				$.ajax({
					type: "POST",
					url: this_site,
					data: "",
					success: function(response) {
						
						var _result			=  JSON.parse(response) ;
						var _html			= _result._TEXT_show_messages;
						
						row.child( _html ).show();
						tr.addClass('shown');
						
						$("#tbl_records1").dataTable({
							 'bProcessing': true,						  
						});
						
						
						_waiting_screen("hide");
						
					}
			
				});	
			}	
		});
		
		
		
		$('#tbl_records_filter input').unbind();
		$('#tbl_records_filter input').bind('keyup', function(e) {
															  
			if(e.keyCode == 13) 
			{
				oTable.fnFilter(this.value);   
			}
		});      
	}	
}