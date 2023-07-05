<?php
// application/core/MY_Exceptions.php
class MY_Exceptions extends CI_Exceptions {

    public function show_404($page = '', $log_error = true)
    {
        $CI =& get_instance();
        $data = $CI->data;

        $data['showThings']['_show_SLIDER'] = FALSE;
        $data['showThings']['_show_CONF_PARTNERS'] = FALSE;


        $data['_pagetitle'] = lang_line("text_404error");


        $data['content'] = "<div align='center' style='margin:50px;'><img src='" . base_url('assets/frontend/images/404.png') . "' /></div>";
        $data['_pageview'] = "global/_blank_page.php";

        $CI->load->view(FRONTEND_TEMPLATE_CENTER_WIDGETS_VIEW, $data);
        echo $CI->output->get_output();
    }
}