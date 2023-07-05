<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Queries queries
 */
class Controls extends C_admincms {

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
		
		
		$this->data["_heading"]										= 'Event Registrations';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
	}
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array('Name', 'Email', 'Event Name', 'Payment Method', 'Package Selected', 'Is Paid', 'Package Amount', 'Additional Donation', 'Phone #', 'Date');
		return $tmp;
	}
	
	public function view( $is_ajax = 0, $cancelId = false, $page = 1 )
	{
		$data														= $this->data;
		
		$data["table_record"]									    = $this->db->query('
            select er.id, er.donate_name, er.donate_email, er.donate_phone, er.donate_amount, er.package_amount, er.mailing_addr, er.created_at,
            df.is_paid, df.belongs_country, dp.payment_mode, ep.package_title, ssw.title, ssw.belongsto
			FROM tb_event_registrations er 
			LEFT JOIN tb_donation_form df ON df.id = er.donation_form_id
			LEFT JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_donation_form"
			LEFT JOIN tb_event_packages ep ON ep.id = er.package_id 
			LEFT JOIN tb_sitesectionswidgets ssw ON ssw.id = er.event_id
			ORDER BY created_at DESC
            ');
		$data["table_properties"]									= $this->view_table_properties();
		$data['admindata']											= $this->queries->fetch_records( "admin", "  ", " id, username " );
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
	
	public function options()
	{
		$data					= $this->data;
		$is_post				= FALSE;
		
		
		if ( $_POST['options'] == "ajax_update_sorting" )
		{
			$is_post		= TRUE;
		}
		else if ( isset($_POST['checkbox_options']) )
		{
		
			if (count($_POST['checkbox_options']) > 0 )
			{
				$is_post		= TRUE;
			}
				
		}
		
		
		if ($is_post)
		{
			switch ($_POST['options'])
			{
				
				case "delete":
					$this->delete( $_POST['checkbox_options'] );
					break;
					
				case "ajax_update_sorting":
					$this->ajax_update_sorting( $_POST['sorting'] );
					break;
					
				default:
					$data['_messageBundle']								= $this->_messageBundle( 'danger' , "Invalid Operation", 'Error!', true);
					redirect(  site_url( $data["_directory"] . "controls/view" ) );
					break;
				
			}
		}
		else
		{
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , "Invalid Operation", 'Error!', true);
			redirect( site_url( $data["_directory"] . "controls/view" ) );
		}

	}

	public function exporteventregistrations(){
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$q = <<<EOT
		select er.id, 
		er.donate_name as 'Name', 
		er.donate_email as 'Email', 
		ssw.title as 'Event Name',
		dp.payment_mode as 'Payment Method', 
		ep.package_title as 'Package Selected',
		(CASE WHEN (df.is_paid = "1") THEN "Paid" ELSE "Unpaid" END) as Status,
		er.package_amount as 'Package Amount', 
		er.donate_amount as 'Additional Donations', 
		er.donate_phone as 'Phone Number', 
		er.mailing_addr as 'Address', 
		er.created_at as 'Date'
		FROM tb_event_registrations er 
		LEFT JOIN tb_donation_form df ON df.id = er.donation_form_id
		LEFT JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_donation_form"
		LEFT JOIN tb_event_packages ep ON ep.id = er.package_id 
		LEFT JOIN tb_sitesectionswidgets ssw ON ssw.id = er.event_id
		ORDER BY er.created_at DESC
EOT;
		$query = $this->db->query($q);
		$delimiter = ",";
		$newline = "\r\n";
		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline,'"');
		force_download('eventregistrations.csv', $data);
	}

	public function delete( $id )
	{
		$data												= $this->data;
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_event_registrations", 'id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */