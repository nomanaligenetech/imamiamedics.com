<?php
$step = 1;
?>
<div class="arbaeen-medical-mission-form form_sec fl_lft w_100">

    <ol class="form-tabs">
        <li class="step1-heading active"><?php echo lang_line('text_basicinformation'); ?></li>
        <li class="step2-heading"><?php echo lang_line('text_yourcontactdetail'); ?></li>
        <li class="step3-heading"><?php echo lang_line('text_commitmenttoserve'); ?></li>
        <li class="step4-heading"><?php echo lang_line('button_submit'); ?></li>
    </ol>

    <div class="content-wrap">

        <?php echo $content; ?>

        <?php
        if (($id = $this->functions->_user_logged_in_details("id")) == 0) {
            echo '<span class="login-strip">'.lang_line('text_doyouhaveanaccount').'</span>';
        }
        ?>

        <div class="form-wrap">
            <div class="ajax-bg" style="display:none;">
                <img src="<?php echo site_url() . 'assets/frontend/images/ajax-loader.gif' ?>" alt="Loader" />
            </div>
            <div class="step-wrap step1"></div>
            <div class="step-wrap step2"></div>
            <div class="step-wrap step3"></div>
            <div class="step-wrap step4"></div>

            <div class="btn-group m_top20">
                <a href="javascript:;" class="medical-form-prev btn btn-warning btn-flat m_rite10"><?php echo lang_line('text_previouspage'); ?></a>
                <a href="javascript:;" class="submit-medical-form btn btn-success btn-flat"><?php echo lang_line('text_nextpage'); ?></a>
            </div>
        </div>
    </div>
</div>


<script>
    var oldjQuery = jQuery;
    var old$ = $;
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo FOLDER_WIDGETS . 'jquery-ui-1.12.1.custom/jquery-ui.min.js' ?>"></script>
<script>
    var newjQuery = jQuery;
    var new$ = $;

    var step = '<?php echo $step; ?>';
    var signdiv = new$("#signature");
    new$('.step-wrap').hide();
    new$('.step' + step).show();

    showHideButtons();
    initializeWidgets();

    var url = '<?php echo site_url(uri_string()) ?>';
    new$(document).on('click', '.submit-medical-form', function() {
        var form = new$(document).find('.step' + step).find('input,select,textarea,radio,checkbox');
        var formdata = new FormData();
        formdata.append('btn_arbaeen_medical_mission_form', 'Submit');
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

        if (new$(document).find('.step' + step).find('input[name="cv_resume"]').length > 0) {
            var field = document.getElementById('cv_resume');
            if (field.files.length == 1) {
                var file = field.files[0];
                formdata.append('cv_resume', file, file.name);
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
                if (response.success && response.success_data.step) {
                    if (response.success_data.completed) {
                        new$('.arbaeen-medical-mission-form').html(response.success_data.content);
                    } else {
                        stepForward(response.success_data.content);
                    }
                    if (response.success_data.last_step) {
                        new$('.submit-medical-form').html('<?php echo lang_line('button_submit'); ?>');
                    }
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

                showHideButtons();
                initializeWidgets();
            },
            error: function(error) {
                console.log(error);
            },
            beforeSend: function() {
                new$('.ajax-bg').fadeIn();
            },
            complete: function() {
                new$('.ajax-bg').fadeOut();
            }
        });
    });

    new$(document).on('click', '.medical-form-prev', function() {
        stepBackward();
    });

    new$(document).on('change', '#langauge-other', function() {
        if (new$(this).is(':checked')) {
            new$('input[name=other_language]').show();
        } else {
            new$('input[name=other_language]').hide();
        }
    });

    new$(document).on('change', 'select[name="activities_applying_for"]', function() {
        if (new$(this).find(":selected").data('value') == "only-health") {
            new$('body').find('.hideonlyhealth').hide();
        } else {
            new$('body').find('.hideonlyhealth').show();
        }
    });

    new$(document).on('change', '.uploader-wrap input[type="file"]', function() {
        $('.uploader-wrap span.text').html(this.files[0].name);
    });

    new$(document).on('click', '.uploader-wrap .remove-file', function() {
        $('.uploader-wrap input[type="file"]').val(null);
        $('.uploader-wrap span.text').html('Choose file or drag here');
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
                var selected = this.element.children(":selected"),
                    value = selected.val() ? selected.text() : "";

                this.input = new$("<input>")
                    .appendTo(this.wrapper)
                    .val(value)
                    .attr("title", "")
                    .attr("placeholder", '<?php echo lang_line('text_country'); ?>')
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
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function() {
                    var text = new$(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
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
        new$("#toggle").on("click", function() {
            new$("#combobox").toggle();
        });
    }

    function stepForward(content) {
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
    }

    function stepBackward() {
        if (step > 1) {
            var oldstep = step;
            step = parseInt(step) - 1;

            new$('.step-wrap').hide();
            new$('.step' + step).show();
            new$('.step' + oldstep + '-heading').removeClass('active');
            new$('.step' + step + '-heading').addClass('active');
        } else {
            new$('.medical-form-prev').hide();
        }
    }

    window.jQuery = oldjQuery;
    window.$ = old$;
</script>