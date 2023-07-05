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
		
		
		$this->data["_heading"]										= 'Donation';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		$this->data["images_dir"]									= "./assets/temp-tax-files/";
		#pre-filled values for input fields
		//$this->_create_fields_for_form(false, $this->data);	
		
	}
	
	/*,'Donation Occ'*/
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array('Name', 'Email',/*'Employee Name', 'Employee Email',*/'Paym Method','Ref Id','Donation Mode','Donation Freq','Donation type','Sehm', /*'Marjaa',*/ 'Syed','Amount','Pay','date','Address','No. of Recurring Payments Paid','Last Recurring Payment','Cancel Recurring','Cancellation Date','Cancelled by','Receipt No.','Tax Receipt');
		return $tmp;
	}
	
	public function view( $is_ajax = 0, $cancelId = false, $page = 1 )
	{
		$data														= $this->data;
		if($cancelId){
			//$data["table_record"]									= $this->queries->fetch_records("who_donate", " and id = ".$cancelId);
			//$data["table_record"]									= $this->db->query('select df.*, dpp.name as dpdesc, dp.payment_mode, dp.paypal_post, (CASE WHEN (dp.payment_mode = "payeezy") THEN cp.transaction_id ELSE dp.reference_number END) as ref_id FROM tb_donation_form df LEFT JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_donation_form" LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id where df.id = '.$cancelId);
			//$data["table_record"]									= $this->db->query('select df.*, dpp.name as dpdesc, dp.payment_mode, dp.paypal_post, (CASE WHEN (dp.payment_mode = "payeezy") THEN cp.transaction_id ELSE dp.reference_number END) as ref_id, up.home_full_address, up.home_city, up.home_state_province, up.cellphone_number FROM tb_donation_form df LEFT JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_donation_form" LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id AND cp.is_cron = 0 LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id where df.id = '.$cancelId);
			$data["table_record"]									= $this->db->query('select df.id, df.first_name as name, df.email as email, df.donation_mode as donation_mode, df.donate_amount as donate_amount, df.num_of_recurring, df.last_recurring_payment, df.cancelled, df.cancel_date, df.cancel_by,
			(CASE WHEN (df.donation_freq = "M-1") THEN "Monthly" WHEN (df.donation_freq = "M-3") THEN "Quarterly" WHEN (df.donation_freq = "M-6") THEN "Half Yearly" ELSE "Yearly" END) as donation_freq,
			(CASE WHEN (df.is_paid = "1") THEN "Paid" ELSE "Unpaid" END) as status, 
			(CASE WHEN (df.date_added != "0000-00-00 00:00:00") THEN df.date_added ELSE dp.date_added END) as date, 
			dpp.name as dpdesc, 
			dp.payment_mode, dp.paypal_post, 
			(CASE WHEN (dp.payment_mode = "payeezy") THEN cp.transaction_id ELSE dp.reference_number END) as ref_id, 
			up.home_full_address, up.home_city, up.home_state_province, up.cellphone_number,
			df.sehm,df.marjaa,df.is_syed
			FROM tb_donation_form df 
			LEFT JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_donation_form" 
			LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id 
			LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id AND cp.is_cron = 0 
			LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id 
			WHERE df.is_active = 1 AND df.id = '.$cancelId);
			$data["total_record"]									= 1;
		} else {
			//$data["table_record"]									= $this->queries->fetch_records("who_donate", " ORDER BY id desc ");
			$offset 												= ($page-1) *1000;
			//$data["table_record"]									= $this->db->query('select df.*, dpp.name as dpdesc, dp.payment_mode, dp.paypal_post, (CASE WHEN (dp.payment_mode = "payeezy") THEN cp.transaction_id ELSE dp.reference_number END) as ref_id FROM tb_donation_form df LEFT JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_donation_form" LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id AND cp.is_cron = 0 ORDER BY id DESC limit '.$offset.', 1000 ');
			//$data["table_record"]									= $this->db->query('select df.*, dpp.name as dpdesc, dp.payment_mode, dp.paypal_post, (CASE WHEN (dp.payment_mode = "payeezy") THEN cp.transaction_id ELSE dp.reference_number END) as ref_id, up.home_full_address, up.home_city, up.home_state_province, up.cellphone_number FROM tb_donation_form df LEFT JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_donation_form" LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id AND cp.is_cron = 0 LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id ORDER BY id DESC limit '.$offset.', 1000 ');
			$data["table_record"]									= $this->db->query('
			select df.id, df.first_name as name, df.email as email, df.donation_mode as donation_mode, df.donate_amount as donate_amount, df.num_of_recurring, df.last_recurring_payment, df.cancelled, df.cancel_date, df.cancel_by, df.tax_receipt_num,
			(CASE WHEN (df.donation_freq = "M-1") THEN "Monthly" WHEN (df.donation_freq = "M-3") THEN "Quarterly" WHEN (df.donation_freq = "M-6") THEN "Half Yearly" ELSE "Yearly" END) as donation_freq,
			(CASE WHEN (df.is_paid = "1") THEN "Paid" ELSE "Unpaid" END) as status, 
			CAST(df.date_added AS DATE) as Date,  
			dpp.name as dpdesc, 
			dpp.id as dpid,
			dp.payment_mode, dp.paypal_post, dr.receipt_number, dr.receipt_prefix,
			(CASE WHEN (dp.payment_mode = "payeezy") THEN cp.transaction_id ELSE dp.reference_number END) as ref_id, 
			(CASE WHEN (up.home_full_address IS NULL) THEN df.home_address ELSE up.home_full_address END) as home_full_address,
			 up.home_city, up.home_state_province, up.cellphone_number,
			df.sehm, df.marjaa, df.is_syed, df.belongs_country 
			FROM tb_donation_form df 
			INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_donation_form" 
			LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id 
			LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id AND cp.is_cron = 0 
			LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id  
			INNER JOIN tb_payment_receipts dr ON df.id = dr.table_id_value AND dr.table_name = "tb_donation_form" 
			WHERE df.is_paid = 1 AND df.is_active = 1 
			GROUP BY ref_id
			UNION 
			select df.id, df.card_name as name, df.card_email as email, "onetime" as donation_mode, df.donate_amount as donate_amount, 0 as num_of_recurring, NULL as last_recurring_payment, 0 as cancelled, NULL as cancel_date, NULL as cancel_by, NULL as tax_receipt_num, 
			"Monthly" as donation_freq,
			(CASE WHEN (df.is_paid = "1") THEN "Paid" ELSE "Unpaid" END) as status, 
			CAST(df.date_added AS DATE) as Date, 
			"IMI Donation In Honor Of Someone" as dpdesc, 
			"" as dpid,
			dp.payment_mode, dp.paypal_post, dr.receipt_number, dr.receipt_prefix,
			(CASE WHEN (dp.payment_mode = "payeezy") THEN cp.transaction_id ELSE dp.reference_number END) as ref_id, 
			up.home_full_address, up.home_city, up.home_state_province, up.cellphone_number,
			"" as sehm,"" as marjaa,"" as is_syed,df.belongs_country
			FROM tb_give_honor_someone df 
			INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_give_honor_someone" 
			INNER JOIN tb_payment_receipts dr ON df.id = dr.table_id_value AND dr.table_name = "tb_give_honor_someone" 
			LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id AND cp.is_cron = 0 
			LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id
			WHERE df.is_paid = 1 AND df.is_active = 1  
			GROUP BY ref_id
			ORDER BY date DESC limit '.$offset.', 1000
			');
			// var_dump($this->db->last_query());die;
			//$query													= $this->db->query('select count(*) as total FROM tb_donation_form');
			$query													= $this->db->query('select ( select count(*) FROM tb_donation_form Where is_active = 1) + ( select count(*) from tb_give_honor_someone Where is_active = 1) as total');
			$data["total_record"]									= $query->row_array();
			$data['pageno']											= $page;
		}
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
	public function receipt( $df_id , $download = false){
		
		$data					= $this->data;
		// $TMP_table	= $this->db->query("SELECT df.*, dcc.comment as comments, dpp.name as dpdesc, dc.name as home_city_name, ds.name as home_state_name FROM tb_donation_form df LEFT JOIN `tb_dc_comments` dcc ON df.id = dcc.df_id LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id LEFT JOIN tb_cities dc ON dc.id = df.home_city LEFT JOIN tb_states ds ON ds.id = df.home_state WHERE df.id = '". $df_id ."' ");
		$TMP_table	= $this->db->query("SELECT df.*, dcc.comment as comments, dpp.name as dpdesc, dc.name as home_city_name, ds.name as home_state_name, dr.receipt_number, dr.receipt_prefix FROM tb_donation_form df LEFT JOIN `tb_dc_comments` dcc ON df.id = dcc.df_id LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id LEFT JOIN tb_cities dc ON dc.id = df.home_city LEFT JOIN tb_states ds ON ds.id = df.home_state LEFT JOIN tb_payment_receipts dr ON df.id = dr.table_id_value AND dr.table_name = 'tb_donation_form'  WHERE df.id = '". $df_id ."' ");
					
		if( $TMP_table->num_rows() > 0 )
		{
			$this->load->library('pdf');

			$_homestate	= ($TMP_table->row()->home_state_name) ? ', ' . $TMP_table->row()->home_state_name : "";
			/* $receipt_prefix = "";
			if($TMP_table->row()->belongs_country == '3'){
				$receipt_prefix = 'C';
			} else {
				$receipt_prefix = 'A';
			} */

			$pdfData = array(
				"name"			=> $TMP_table->row()->first_name,
				"address"		=> $TMP_table->row()->home_city_name . $_homestate,
				// "address"		=> $TMP_table->row()->home_address,
				"email"			=> $TMP_table->row()->email,
				"project"		=> $TMP_table->row()->dpdesc,
				"amount"		=> $TMP_table->row()->donate_amount,
				"date" 			=> date("Y-m-d", strtotime( $TMP_table->row()->date_added)),
				// "serial_num" 	=> (($TMP_table->row()->tax_receipt_num) ? $receipt_prefix . $TMP_table->row()->tax_receipt_num : "N/A"),
				"serial_num" 	=> (($TMP_table->row()->receipt_number) ? $TMP_table->row()->receipt_prefix . $TMP_table->row()->receipt_number : "N/A"),
			);

			$file_name = 'tax-receipt-' . $df_id . '.pdf';
			$html_code = '<link rel="preconnect" href="https://fonts.googleapis.com">';

			if($TMP_table->row()->belongs_country == '3'){
				$html_code .= $this->load->view( "receipts/canada.php", $pdfData, TRUE );
			}
			// international
			else{
				$html_code .= $this->load->view( "receipts/global.php", $pdfData, TRUE );
			}
			$pdf = new Pdf();
			$pdf->load_html($html_code);
			$pdf->render();
			if($download){
				
				$output = $pdf->output();
				
				//temp directory path of live and local
				$localhost = array('127.0.0.1', "::1");
				if (in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
					$path = $_SERVER['DOCUMENT_ROOT'].'/imamiamedicscom/assets/temp-tax-files/';
				} else {
					$path = $_SERVER['DOCUMENT_ROOT'].'/assets/temp-tax-files/';
				}

				file_put_contents($path.$file_name, $output);
			}else{

				$pdf->stream($file_name);
			}
		}
		if(!$download){
			redirect( site_url( $data["_directory"] . "controls/view" ) );
		}
	}

	public function delete( $id )
	{
		$data												= $this->data;
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_donation_form", 'id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}

	public function cancel_recurring( $id )
	{
		$data											= $this->data;

		$saveData['id']									= $id;
		$saveData['cancelled']							= 1;
		$saveData['cancel_date']						= date('Y-m-d');
		$saveData['cancel_by']							= $this->functions->_admincms_logged_in_details( "id" );
		$this->queries->SaveDeleteTables($saveData, 'e', "tb_donation_form", 'id');

		$data['_messageBundle']							= $this->_messageBundle('success' , 
														lang_line("operation_saved_success"), 
														lang_line("heading_operation_success"), 
														false,
														true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
	}

	public function exportpaypal(){
		// AND df.belongs_country IN($get_belongsto)
		$get_role_id 		= $this->functions->_admincms_logged_in_details( "roleid" ); 
		$get_belongsto 		= $this->functions->_admincms_logged_in_details( "belongs_country" );
		
		// check if admin or superadmin then assign all of belongs_country id
		if($get_role_id == 1 || $get_role_id == 4){ 
			$get_belongsto =  implode(',',array_keys(DropdownHelper::cmsmenubelongsto_dropdown()));
		}

		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$q = <<<EOT
		select df.first_name as Name, 
		df.donate_amount as Amount, 
		CAST(df.date_added AS DATE) as Date, 
		dpp.name as 'Donation Type', 
		dp.payment_mode as 'Payment Method', 
		(CASE WHEN (df.belongs_country = "2") THEN CONCAT('A', df.tax_receipt_num) WHEN (df.belongs_country = "3") THEN CONCAT('C', df.tax_receipt_num) ELSE df.tax_receipt_num END) as 'Receipt No.',
		df.donate_honoree as 'Honoree\'s Name',
		up.home_full_address as Address, 
		up.home_city as City, 
		IFNULL(df.home_zipcode,up.home_zipcode) as Zip,
		up.home_state_province as 'State/Province', 
		cn.countries_name as 'Country Name',
		up.cellphone_number as 'Contact #',
		df.email as Email,
		(CASE WHEN (df.is_paid = "1") THEN "Paid" ELSE "Unpaid" END) as Status, 
		dp.reference_number as 'Ref Id', 
		df.donation_mode as 'Donation Mode', 
		(CASE WHEN (df.donation_freq = "M-1") THEN "Monthly" WHEN (df.donation_freq = "M-3") THEN "Quarterly" WHEN (df.donation_freq = "M-6") THEN "Half Yearly" ELSE "Yearly" END) as 'Donation Freq', 
		df.sehm as 'Sehm', 
		df.marjaa as 'Marjaa', 
		df.is_syed as 'Syed'
		FROM tb_donation_form df 
		INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_donation_form" AND dp.payment_mode = "paypal" 
		LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id 
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id
		LEFT JOIN tb_countries cn ON cn.id = df.home_country 
		WHERE df.is_paid = 1 AND df.is_active = 1 AND df.belongs_country IN($get_belongsto)
		UNION ALL 
		select df.card_name as Name, 
		df.donate_amount as Amount,
		(CASE WHEN (df.date_added != "0000-00-00 00:00:00") THEN CAST(df.date_added AS DATE) ELSE CAST(dp.date_added AS DATE) END) as Date,
		"IMI Donation In Honor Of Someone" as 'Donation Type', 
		dp.payment_mode as 'Payment Method', 
		"" as 'Receipt No.',
		"" as 'Honoree\'s Name' ,
		up.home_full_address as Address, 
		up.home_city as City, 
		up.home_zipcode as Zip, 
		up.home_state_province as 'State/Province', 
		cn.countries_name as 'Country Name',
		up.cellphone_number as 'Contact #',
		df.card_email as Email, 
		(CASE WHEN (df.is_paid = "1") THEN "Paid" ELSE "Unpaid" END) as Status, 
		dp.reference_number as 'Ref Id', 
		"onetime" as 'Donation Mode', 
		"Monthly" as 'Donation Freq', 
		"" as 'Sehm',
		"" as 'Marjaa',
		"" as 'Syed'
		FROM tb_give_honor_someone df 
		INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_give_honor_someone" AND dp.payment_mode = "paypal" 
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id
		LEFT JOIN tb_countries cn ON cn.id = df.home_country 
		WHERE df.is_paid = 1 AND df.is_active = 1 AND df.belongs_country IN($get_belongsto)
		ORDER BY DATE DESC
EOT;
		$query = $this->db->query($q);
		$delimiter = ",";
		$newline = "\r\n";
		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline,'"');
		force_download('donation_paypal.csv', $data);
	}

	public function exportpayeezy(){
		//  AND df.belongs_country IN($get_belongsto)
		$get_role_id 		= $this->functions->_admincms_logged_in_details( "roleid" ); 
		$get_belongsto 		= $this->functions->_admincms_logged_in_details( "belongs_country" );
		// check if admin or superadmin then assign all of belongs_country id
		if($get_role_id == 1 || $get_role_id == 4){ 
			$get_belongsto =  implode(',',array_keys(DropdownHelper::cmsmenubelongsto_dropdown()));
		}

		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$q = <<<EOT
		select df.first_name as Name, 
			cp.card_name as 'CardHolder\'s Name', 
			df.donate_amount as Amount, 
			CAST(cp.date_added AS DATE) as Date, 
			dpp.name as 'Donation Type', 
			dp.payment_mode as 'Payment Method', 
			(CASE WHEN (df.belongs_country = "2") THEN CONCAT('A', df.tax_receipt_num) WHEN (df.belongs_country = "3") THEN CONCAT('C', df.tax_receipt_num) ELSE df.tax_receipt_num END) as 'Receipt No.',
			df.donate_honoree as 'Honoree\'s Name' ,
			up.home_full_address as Address, 
			up.home_city as City, 
			IFNULL(df.home_zipcode,up.home_zipcode) as Zip,
			cn.countries_name as 'Country Name',
			up.cellphone_number as 'Contact #',
			up.home_state_province as 'State/Province', 
			df.email as Email, 
			(CASE WHEN (df.is_paid = "1") THEN "Paid" ELSE "Unpaid" END) as Status, 
			cp.transaction_id as 'Ref Id', 
			df.donation_mode as 'Donation Mode', 
			(CASE WHEN (df.donation_freq = "M-1") THEN "Monthly" WHEN (df.donation_freq = "M-3") THEN "Quarterly" WHEN (df.donation_freq = "M-6") THEN "Half Yearly" ELSE "Yearly" END) as 'Donation Freq', 
			df.sehm as 'Sehm', 
			df.marjaa as 'Marjaa', 
			df.is_syed as 'Syed'
			FROM tb_donation_form df 
			INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_donation_form" AND dp.payment_mode = "payeezy" 
			LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id 
			LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id
			LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id
			LEFT JOIN tb_countries cn ON cn.id = df.home_country 
			WHERE df.is_paid = 1 AND df.is_active = 1 AND df.belongs_country IN($get_belongsto)
			UNION ALL 
			select df.card_name as Name, 
			cp.card_name as 'CardHolder\'s Name', 
			df.donate_amount as Amount, 
			(CASE WHEN (df.date_added != "0000-00-00 00:00:00") THEN CAST(df.date_added AS DATE) ELSE CAST(dp.date_added AS DATE) END) as Date, 
			"IMI Donation In Honor Of Someone" as 'Donation Type', 
			dp.payment_mode as 'Payment Method', 
			"" as 'Receipt No.',
			"" as 'Honoree\'s Name' ,
			up.home_full_address as Address, 
			up.home_city as City, 
			up.home_zipcode as Zip, 
			up.home_state_province as 'State/Province', 
			cn.countries_name as 'Country Name',
			up.cellphone_number as 'Contact #',
			df.card_email as Email, 
			(CASE WHEN (df.is_paid = "1") THEN "Paid" ELSE "Unpaid" END) as Status, 
			cp.transaction_id as 'Ref Id', 
			"onetime" as 'Donation Mode', 
			"Monthly" as 'Donation Freq', 
			"" as 'Sehm',
			"" as 'Marjaa',
			"" as 'Syed'
			FROM tb_give_honor_someone df 
			INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = "tb_give_honor_someone" AND dp.payment_mode = "payeezy" 
			LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id
			LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id
			LEFT JOIN tb_countries cn ON cn.id = df.home_country 
			WHERE df.is_paid = 1 AND df.is_active = 1 AND df.belongs_country IN($get_belongsto)
			ORDER BY DATE DESC
EOT;
		$query = $this->db->query($q);
		$delimiter = ",";
		$newline = "\r\n";
		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline,'"');
		force_download('donation_payeezy.csv', $data);
	}

	public function bulk_receipt_zip(){
		$data											= $this->data;

		$from_date 	= isset($_POST["bulk_receipt_from_date"])  && !empty($_POST["bulk_receipt_from_date"]) ? $_POST["bulk_receipt_from_date"] : '';
		$to_date  	= isset($_POST["bulk_receipt_to_date"])  && !empty($_POST["bulk_receipt_to_date"]) ? $_POST["bulk_receipt_to_date"] : '';
		
		if(isset($from_date) && isset($to_date)){
			
			$this->load->helper('file');
			$this->load->helper('directory');

			$query = $this->db->query("SELECT tb_donation_form.id FROM tb_donation_form RIGHT JOIN tb_payment_receipts On tb_payment_receipts.table_name = 'tb_donation_form' AND tb_payment_receipts.table_id_value = tb_donation_form.id WHERE tb_donation_form.date_added BETWEEN '$from_date' AND '$to_date'");

			//temp directory path of live and local
			$localhost = array('127.0.0.1', "::1");
			if (in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
				$path = $_SERVER['DOCUMENT_ROOT'].'/imamiamedicscom/assets/temp-tax-files/';
			} else {
				$path = $_SERVER['DOCUMENT_ROOT'].'/assets/temp-tax-files/';
			}

			// Delete all files before downloading
			$files = directory_map($path);
			foreach($files as $file)
			{ 
				if(is_file($path.$file)){
					unlink($path.$file);
				}
			}

			// For downloading a zip file
			if($query->num_rows() > 0){
				$result = $query->result();
				$this->load->library('zip');
				if(isset($result) && !empty($result)){
					
					foreach ($result as $key => $value) {
						$this->receipt($value->id,  true);
					}
					
					$this->zip->read_dir($path, FALSE);
					
					foreach ($result as $key => $value) {
						
						$file_name = 'tax-receipt-' . $value->id . '.pdf';
						$this->zip->archive($path.$file_name);	
					}
			
					$this->zip->download('bulk-receipt.zip');

				}else{
					$data['_messageBundle'] = $this->_messageBundle( 'danger' , "No Receipts Found", 'Error!', true);
				}
			}
			redirect( site_url( $this->data["_directory"] . "controls/view" ) );
		}
	}
}

/* End of file welcome.php */ 
/* Location: ./application/controllers/welcome.php */