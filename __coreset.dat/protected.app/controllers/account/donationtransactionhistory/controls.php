<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controls extends C_frontend {

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

		$this->_auth_login( false );
		
		$this->data													= $this->default_data();
		
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		
		$this->data["_heading"]										= lang_line('text_financialtranshistory');
		$this->data["_pagetitle"]									= $this->data["_heading"];
		
		$this->TMP_dir												= "frontend/";
		$this->data['_pageview']									= $this->TMP_dir . $this->data["_directory"] . "view.php";
		
		
		
		
	}

	public function view()
	{		
		
		$data														= $this->data;
		
		$data['_pageview']											= $this->TMP_dir . $data["_directory"] . "view.php";
		
		
		$data['files_details_1'] = $this->db->query('select dp.id, df.is_paid, df.first_name as name, df.donate_amount as donate_amount, dp.payment_mode, dpp.name as dpdesc, df.donation_mode, dp.payment_status, cp.transaction_id, cp.is_cron, df.num_of_recurring, (CASE WHEN (dp.payment_mode = "payeezy") THEN cp.date_added ELSE (CASE WHEN (df.is_paid = 1) THEN dp.date_added ELSE df.date_added END) END) as date_added, dp.reference_number FROM tb_donation_form df LEFT JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_donation_form" LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id WHERE df.user_id = '.$this->functions->_user_logged_in_details( "id" ).' 
		UNION ALL 
		select dp.id, df.is_paid, df.card_name as name, df.donate_amount as donate_amount, dp.payment_mode, "IMI Donation In Honor Of Someone" as dpdesc, "onetime" as donation_mode, dp.payment_status, cp.transaction_id, cp.is_cron, 0 as num_of_recurring, (CASE WHEN (dp.payment_mode = "payeezy") THEN cp.date_added ELSE (CASE WHEN (df.is_paid = 1) THEN dp.date_added ELSE df.date_added END) END) as date_added, dp.reference_number FROM tb_give_honor_someone df LEFT JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_give_honor_someone" LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id WHERE df.user_id = '.$this->functions->_user_logged_in_details( "id" ).' 
		ORDER BY date_added DESC');

		$conference_db = $this->load->database('imiconf', true);
        $conference_db->initialize();

		$data['files_details_2'] = $conference_db->query('select paypal_post FROM tb_user_memberships WHERE user_id = '.$this->functions->_user_logged_in_details( "id" ).' ORDER BY id DESC');

		$data['files_details_3'] = $conference_db->query('select tcp.paypal_post, tcp.payment_gross, tcp.date_added, tcp.payment_status, tc.name FROM tb_conference_payments tcp left join tb_conference tc ON tc.id = tcp.conferenceid WHERE tcp.userid = '.$this->functions->_user_logged_in_details( "id" ).' ORDER BY tcp.id DESC');
		
		if ( $data['files_details_1'] -> num_rows() <= 0 && $data['files_details_2'] -> num_rows() <= 0 && $data['files_details_3'] -> num_rows() <= 0 )
		{
			$data['_messageBundle']										= $this->_messageBundle( 'info' , lang_line("text_norecordfound"), ' ');
		}
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */