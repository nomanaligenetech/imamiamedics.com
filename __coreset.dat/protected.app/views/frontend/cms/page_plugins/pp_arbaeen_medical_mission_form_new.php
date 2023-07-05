<?php
// $step = 1;
?>
<div class="arbaeen-medical-mission-form form_sec fl_lft w_100">

    <!-- <ol class="form-tabs">
        <li class="step1-heading active"><?php echo lang_line('text_basicinformation'); ?></li>
        <li class="step2-heading"><?php echo lang_line('text_yourcontactdetail'); ?></li>
        <li class="step3-heading"><?php echo lang_line('text_healthdetails'); ?></li>
        <li class="step4-heading"><?php echo lang_line('text_commitmenttoserve'); ?></li>
        <li class="step5-heading"><?php echo lang_line('button_submit'); ?></li>
    </ol> -->

    <div class="content-wrap">

        <div class="imi_content">
            <?php echo $content; ?>
        </div>
        <div class="content_fp">        
            <?php echo $content_fp; ?>
        </div>
        <?php
        if (($id = $this->functions->_user_logged_in_details("id")) == 0) {
            echo '<span class="login-strip">'.lang_line('text_doyouhaveanaccount').'</span>';
        }
        ?>

        <div class="form-wrap">
            <div class="ajax-bg" style="display:none;">
                <img src="<?php echo site_url() . 'assets/frontend/images/ajax-loader.gif' ?>" alt="Loader" />
            </div>
            <div class="step-wrap step1">
            </div>
            <div class="step-wrap step2">
                <?php $this->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_form_new/step2.php");?>
            </div>
            <div class="step-wrap step3">
                <?php $this->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_form_new/step5.php");?>
            </div>
            <div class="step-wrap step4">
                <?php $this->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_form_new/step3.php");?>
            </div>
            <div class="step-wrap step5">
                <?php $this->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_form_new/step4.php");?>
            </div>

            <!-- <div class="btn-group m_top20">
                <a href="javascript:;" class="medical-form-prev btn btn-warning btn-flat m_rite10"><?php echo lang_line('text_previouspage'); ?></a>
                <a href="javascript:;" class="submit-medical-form btn btn-success btn-flat"><?php echo lang_line('text_nextpage'); ?></a>
            </div> -->
            <div class="btn-group m_top20">
                <a href="javascript:;" class="submit-medical-form btn btn-success btn-flat"><?php echo lang_line('button_submit'); ?></a>
            </div>
        </div>
    </div>
</div>


<script>
    var oldjQuery = jQuery;
    var old$ = $;
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="<?php echo FOLDER_WIDGETS . 'jquery-ui-1.12.1.custom/jquery-ui.min.js' ?>"></script> 
<script>
    var newjQuery = jQuery;
    var new$ = $;
    var step = '<?php echo $step; ?>';
    var signdiv = new$("#signature");
    // console.log(signdiv)
    // new$('.step-wrap').hide();
    // new$('.step' + step).show();

    // showHideButtons();
    initializeWidgets();

    var url = '<?php echo site_url(uri_string()) ?>';
    new$(document).on('click', '.submit-medical-form', function() {
        var form = new$(document).find('.form-wrap').find('input,select,textarea,radio,checkbox');
        var formdata = new FormData();
        formdata.append('btn_arbaeen_medical_mission_form_new', 'Submit');
        formdata.append('step', step);

        new$.each(form, function(index, field) {
            if (field.type == 'checkbox' || field.type == 'radio') {
                if (new$(field).is(':checked')) {
                    formdata.append(field.name, field.value);
                }
            } else {
                formdata.append(field.name, field.value);
            }
        });

        if (new$(document).find('.form-wrap').find('input[name="cv_resume"]').length > 0) {
            var field = document.getElementById('cv_resume');
            if (field.files.length == 1) {
                var file = field.files[0];
                formdata.append('cv_resume', file, file.name);
            }
        }

        if (new$(document).find('.form-wrap').find('input[name="passport_copy"]').length > 0) {
            var field = document.getElementById('passport_copy');
            if (field.files.length == 1) {
                var file = field.files[0];
                formdata.append('passport_copy', file, file.name);
            }
        }

        if (new$(document).find('.form-wrap').find('input[name="passport_pic"]').length > 0) {
            var field = document.getElementById('passport_pic');
            if (field.files.length == 1) {
                var file = field.files[0];
                formdata.append('passport_pic', file, file.name);
            }
        }

        new$.ajax({
            type: "POST",
            url: url,
            data: formdata,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response.success)
                if (response.success) {
                    // if (response.success_data.completed) {
                        new$('.arbaeen-medical-mission-form').html(response.success_data.content);
                        console.log(response.success_data.content)
                    // }
                } else if (response.error && response.error_messages) {
                    $('.error').html("");
                    var validation_messages = response.error_messages;
                    for (var key in validation_messages) {
                        // skip loop if the property is from prototype
                        if (!validation_messages.hasOwnProperty(key)) continue;

                        var msg = validation_messages[key];
                        new$(document).find('.error.' + key).html(msg);
                    }
                }

                // showHideButtons();
                initializeWidgets();
            },
            error: function(error) {
                console.log(error);
            },
            beforeSend: function() {
                new$('.ajax-bg').fadeIn();
                new$('.submit-medical-form').attr('disabled', true);
            },
            complete: function() {
                new$('.ajax-bg').fadeOut();
                new$('.submit-medical-form').attr('disabled', false);
            }
        });
    });

    new$(document).on('click', '.medical-form-prev', function() {
        // stepBackward();
    });

    // $('').click(function() {
    new$(document).on('click', 'body .overlay-imi', function() {
        $(this).css('display', 'none');
        $(this).siblings('#signature').addClass('hide-before');
    //   alert('Hello');
    });

    new$(document).on('click', 'body #signature div:last-child input', function() {
        $('#signature').removeClass('hide-before');
        $('body .overlay-imi').css('display', 'block');
        // alert('Hello');
      });
      
    new$(document).on('change', '#langauge-other', function() {
        if (new$(this).is(':checked')) {
            new$('input[name=other_language]').show();
        } else {
            new$('input[name=other_language]').hide();
        }
    });

   /*  new$(document).on('change', 'input[name="know_bmi"]', function() {
        if (new$(this).data('value') == "showchart") {
            new$('body').find('.showchart').show();
        } else {
            new$('body').find('.showchart').hide();
        }
    }); */

    /* new$(document).on('click', 'input[name="med_his"], input[name="med_curr"]', function() {
        if (new$('input[name="med_his"]:checked').data('value') == "showdetails" || new$('input[name="med_curr"]:checked').data('value') == "showdetails") {
            new$('body').find('.showdetails').show();
        } else {
            new$('body').find('.showdetails textarea').val('');
            new$('body').find('.showdetails').hide();
        }
    }); */

   /*  new$(document).on('change', '.showdetques', function() {
        if(this.checked) {
            new$('body').find('.' + new$(this).data('value')).show();
        } else {
            new$('body').find('.' + new$(this).data('value') + ' input').prop("checked", false);
            new$('body').find('.' + new$(this).data('value')).hide();
        }
    }); */
    
    /* new$(document).on('change', '#health-other', function() {
        if (this.checked) {
            new$('input[name=other_health_cond]').show();
        } else {
            new$('input[name=other_health_cond]').val('');
            new$('input[name=other_health_cond]').hide();
        }
    }); */

    /* new$(document).on('change', 'input[name="covid_vacc"]', function() {
        new$('body').find('.covid_det textarea').val("");
        new$('body').find('.covid_det label').hide();
        if(this.value != "") {
            console.log(this.value, new$("input[name='covid_vacc']:checked").data('value'));
            new$('body').find('.covid_det label.' + new$("input[name='covid_vacc']:checked").data('value')).show();
            new$('body').find('.covid_det').show();
        } else {
            new$('body').find('.covid_det').hide();
        }
    }); */

    /* new$(document).on('change', 'select[name="activities_applying_for"]', function() {
        if (new$(this).find(":selected").data('value') == "only-health") {
            new$('body').find('.hideonlyhealth').hide();
        } else {
            new$('body').find('.hideonlyhealth').show();
        }
    }); */

    new$(document).on('change', '.uploader-wrap input[type="file"]', function() {
        $(this).prev().html(this.files[0].name);
    });

    new$(document).on('click', '.uploader-wrap .remove-file', function() {
        $(this).next().next().val(null);
        $(this).next().html('Choose files or drag here');
    });

    new$(document).on('click', '.open-terms-conditions', function() {
        new$('#personal-covenant-liability').dialog({
            draggable: false,
            resizeable: false,
            height: 400,
            width: 500,
            buttons: [{
                text: "OK",
                click: function() {
                    new$(this).dialog("close");
                }
            }],
            modal: true,
            closeText: "",
            dialogClass: "arbaeen-medical-terms-conditions"
        });
    });

    function showHideButtons() {
        if (step == 1) {
            new$('.medical-form-prev').hide();
        } else {
            new$('.medical-form-prev').show();
        }
    }

    function initializeWidgets() {
        if ($("#signature").length > 0 && $("#signature").html() == "") {

            var signdiv = $("#signature").jSignature({
                UndoButton: true,
                height: '200px',
                width: '100%'
            });

            signdiv.bind('change', function(e) {
                if (signdiv.jSignature('getData', 'native').length > 0) {
                    new$('input[name="signature"]').val(signdiv.jSignature("getData", "default"));
                } else {
                    new$('input[name="signature"]').val("");
                }
            });
        }

        if (new$(".birthdate_datepicker").length > 0) {
            new$(".birthdate_datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                defaultDate: '-30 years',
                maxDate: '0 years',
                yearRange: "-100:+0", // last hundred years
                changeMonth: true,
                changeYear: true
            });
        }

        var currentYear = new Date().getFullYear();
        if (new$(".passport_expiry_datepicker").length > 0) {
            new$(".passport_expiry_datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                defaultDate:'-10 years',
                yearRange: "-10:+10",
                changeMonth: true,
                changeYear: true
            });
        }

        new$.widget("custom.combobox", {
            _create: function() {
                this.wrapper = new$("<span>")
                    .addClass("custom-combobox")
                    .insertAfter(this.element);

                this.element.hide();

                this._createAutocomplete();
                this._createShowAllButton();
            },

            _createAutocomplete: function() {
                var selected     = this.element.children(":selected"),
                    value        = selected.val() ? selected.text() : "";
                    placeholder  = this.element.attr('placeholder');
                    
                this.input = new$("<input>")
                    .appendTo(this.wrapper)
                    .val(value)
                    .attr("title", "")
                    .attr("placeholder", placeholder)
                    .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: $.proxy(this, "_source")
                    })
                    .tooltip({
                        classes: {
                            "ui-tooltip": "ui-state-highlight"
                        }
                    });

                this._on(this.input, {
                    autocompleteselect: function(event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });

                        if(ui.item.ele == 'combobox'){
                            dd_ele   =  new$("#combobox-code");
                            selected_option =  new$("#combobox-code").find('[data-id='+ ui.item.attr +']');
                            code    = selected_option.val();
                            country = selected_option.attr('data-cname').split('-').join(' ');
                            to_show = country + " (+"+ code +")"
                            console.log(selected_option);
                            selected_option.prop('selected', true);
                            dd_ele.next().find('input').val(to_show);
                            
                            // selected.prop('selected', true);
                        }
                    },

                    autocompletechange: "_removeIfInvalid"
                });
            },

            _createShowAllButton: function() {
                var input = this.input,
                    wasOpen = false;

                new$("<a>")
                    .attr("tabIndex", -1)
                    //.attr("title", "Show All Items")
                    .tooltip()
                    .appendTo(this.wrapper)
                    .button({
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                    })
                    .removeClass("ui-corner-all")
                    .addClass("custom-combobox-toggle ui-corner-right ui-widget")
                    .on("mousedown", function() {
                        wasOpen = input.autocomplete("widget").is(":visible");
                    })
                    .on("click", function() {
                        input.trigger("focus");

                        // Close if already visible
                        if (wasOpen) {
                            return;
                        }

                        // Pass empty string as value to search for, displaying all results
                        input.autocomplete("search", "");
                    });
            },

            _source: function(request, response) {
                dropdown = this.element.attr('id');
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function() {
                    var text   = new$(this).text();
                    var id     = new$(this).attr('data-id');
                    var c_name = new$(this).attr('data-cname');

                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            attr: id,
                            ele: dropdown,
                            c_name: c_name,
                            option: this
                        };
                }));
            },

            _removeIfInvalid: function(event, ui) {

                // Selected an item, nothing to do
                if (ui.item) {
                    return;
                }

                // Search for a match (case-insensitive)
                var value = this.input.val(),
                    valueLowerCase = value.toLowerCase(),
                    valid = false;
                this.element.children("option").each(function() {
                    if (new$(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });

                // Found a match, nothing to do
                if (valid) {
                    return;
                }

                // Remove invalid value
                this.input
                    .val("")
                    .attr("title", value + " didn't match any item")
                    .tooltip("open");
                this.element.val("");
                this._delay(function() {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.autocomplete("instance").term = "";
            },

            _destroy: function() {
                this.wrapper.remove();
                this.element.show();
            }
        });

        new$("#combobox").combobox();
        new$("#combobox-code").combobox();
        new$("#toggle").on("click", function() {
            new$("#combobox").toggle();
        });
    }

   /*  function stepForward(content) {
        var oldstep = step;
        step = parseInt(step) + 1;

        var html = new$('.step' + step).html();

        if (html == "") {
            new$('.step' + step).html(content);
            $('.error').html("");
        }
        new$('.step-wrap').hide();
        new$('.step' + step).show();
        new$('.step' + oldstep + '-heading').removeClass('active');
        new$('.step' + step + '-heading').addClass('active');
        if (step > 1) {
            new$('.content_fp').hide();
        }
    } */

   /*  function stepBackward() {
        var oldstep = step;
        step = parseInt(step) - 1;

        new$('.step-wrap').hide();
        new$('.step' + step).show();
        new$('.step' + oldstep + '-heading').removeClass('active');
        new$('.step' + step + '-heading').addClass('active');
        new$('.submit-medical-form').html('<?php echo lang_line('text_nextpage'); ?>');
        if (step == 1) {
            new$('.medical-form-prev').hide();
            new$('.content_fp').show();
        }
    } */

    window.jQuery = oldjQuery;
    window.$ = old$;
</script>