<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Membership_Renew extends C_frontend
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct()
    {
        parent::__construct();

        $this->data                                                    = $this->default_data();
    }

    public function index()
    {
        $current_date = date('Y-m-d h:i:s');
        $next_week_date = date('Y-m-d h:i:s', strtotime("+1 week"));
        $users = $this->imiconf_queries->fetch_records_imiconf("user_memberships", " and member_expiry >= '".$current_date."' and member_expiry <= '".$next_week_date."'");
        if ($users->num_rows() > 0) {
            $users = $users->result();
            foreach ($users as $user) {
                $user_row = $this->imiconf_queries->fetch_records_imiconf("users", " and id = ". $user->user_id);
                $user_row = $user_row->row();

                //if ( $user_row->email == "qateam786@gmail.com" ){
                    $email_template                = array(
                        "email_to"               => $user_row->email,
                        "email_heading"          => 'Imamiamedics - Membership is going to expire',
                        "email_file"             => "email/frontend/membership_expire.php",
                        "email_subject"          => 'Imamiamedics - Membership is going to expire',
                        "email_post"             => array("user"        => $user_row,'membership' => $user),
                        //"debug"                  => true
                    );
                    
                    $is_email_sent                = $this->_send_email($email_template);
                    echo $is_email_sent ? 'success' : 'failed';
                //}
            }
        }

        die('==END==');
    }
}