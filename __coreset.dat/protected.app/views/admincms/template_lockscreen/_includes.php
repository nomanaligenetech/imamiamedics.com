<link href="<?php echo base_url("assets/admincms/css/bootstrap.min.css");?>" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="<?php echo base_url("assets/admincms/css/font-awesome.min.css");?>" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="<?php echo base_url("assets/admincms/css/AdminLTE.css");?>" rel="stylesheet" type="text/css" />

<style>
.show_errors{ margin-top:10px;}
.show_errors p{ color:#000;}
</style>



<!-- jQuery 2.0.2 -->
<script src="<?php echo base_url( FRONTEND_FOLDER_JS . 'jquery.js');?>" type="text/javascript"></script>

<!-- Bootstrap -->
<script src="<?php echo base_url("assets/admincms/js/bootstrap.min.js");?>" type="text/javascript"></script>   

<script type="text/javascript">
            $(function() {
                startTime();
                $(".center").center();
                $(window).resize(function() {
                    $(".center").center();
                });
            });

            /*  */
            function startTime()
            {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();

                // add a zero in front of numbers<10
                m = checkTime(m);
                s = checkTime(s);

                //Check for PM and AM
                var day_or_night = (h > 11) ? "PM" : "AM";

                //Convert to 12 hours system
                if (h > 12)
                    h -= 12;

                //Add time to the headline and update every 500 milliseconds
                $('#time').html(h + ":" + m + ":" + s + " " + day_or_night);
                setTimeout(function() {
                    startTime()
                }, 500);
            }

            function checkTime(i)
            {
                if (i < 10)
                {
                    i = "0" + i;
                }
                return i;
            }

            /* CENTER ELEMENTS IN THE SCREEN */
            jQuery.fn.center = function() {
                this.css("position", "absolute");
                this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
                        $(window).scrollTop()) - 30 + "px");
                this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
                        $(window).scrollLeft()) + "px");
                return this;
            }
        </script>    