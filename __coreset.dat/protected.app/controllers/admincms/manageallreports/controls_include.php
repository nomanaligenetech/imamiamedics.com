<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controls_Include extends C_admincms {

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
	}
	
	
	public function view_table_properties( $conference_slug = FALSE )
	{
		$tmp["tr_heading"]	= array( 
									'Card Holder\'s Name',
									'Full Name',
									'Amount',
									'Date',
									'Purpose',
									'Payment Method',
									'Payment Mode',
									'Country Name',
									'Email',
									'Status',
									'Tax Receipt',
									'Automated Reconciliation Status');

		return $tmp;	
	}

	public function search_option_properties()
	{
		$tmp["select_options"]	= array(
									'card_holder_name'=>'Name',
									'ref_id'=>'Reference id',
									'payment_mode'=>'Payment mode',
									'amount'=>'Amount',
									'payment_method'=>'Payment method',
									'email_address'=>"Email",
									'tax_recript'=>"Tax recript",
									'country_name'=>'Country',
									'category'=>"Category",
									'purpose'=>"Purpose");

		return $tmp;	
	}

	public function fetch_records_for_view( $id = array(), $where = FALSE, $payment_method )
	{
		$get_role_id 		= $this->functions->_admincms_logged_in_details( "roleid" ); 
		$get_belongsto 		= $this->functions->_admincms_logged_in_details( "belongs_country" );
		// var_dump($get_role_id);
		// var_dump($get_belongsto); die;
		// check if admin or superadmin then assign all of belongs_country id
		if($get_role_id == 1 || $get_role_id == 4){ 
			$get_belongsto =  implode(',',array_keys(DropdownHelper::cmsmenubelongsto_dropdown()));


			// print_r($get_belongsto);

			// die;
		}

		$get_role_id 		= $this->functions->_admincms_logged_in_details( "roleid" ); 
		$get_belongsto 		= $this->functions->_admincms_logged_in_details( "belongs_country" );
		// var_dump($get_role_id);
		// var_dump($get_belongsto); die;
		// check if admin or superadmin then assign all of belongs_country id
		if($get_role_id == 1 || $get_role_id == 4){ 
			$get_belongsto =  implode(',',array_keys(DropdownHelper::cmsmenubelongsto_dropdown()));
		}

		$query = "select 
		DISTINCT df.id, 
		df.first_name as name, 
		COALESCE(
		  ptd.card_holder_name, petd.cardholder_name
		) as card_holder_name, 
		COALESCE(
		  ptd.transaction_amount, df.donate_amount, 
		  petd.amount
		) as amount, 
		COALESCE(
		  ptd.transaction_initiation_date, 
		  petd.time, 
		  CAST(df.date_added AS DATETIME)
		) as Date, 
		dpp.name as dpdesc, 
		dp.payment_mode as payment_method, 
		df.donation_mode as payment_mode, 
		(
			CASE WHEN (df.donation_freq = 'M-1') THEN 'Monthly' WHEN (df.donation_freq = 'M-3') THEN 'Quarterly' WHEN (df.donation_freq = 'M-6') THEN 'Half Yearly' ELSE 'Yearly' END
		) as donation_frequency, 
		df.donate_honoree as honoree_name, 
		(
			CASE WHEN (up.home_full_address IS NULL) THEN df.home_address ELSE up.home_full_address END
		) as home_full_address, 
		up.home_city, 
		up.home_state_province, 
		up.cellphone_number, 
		IFNULL(
			df.home_zipcode, up.home_zipcode
		) as zip,
		COALESCE(ptd.email_address, df.email) as email_address, 
		(
		  CASE WHEN (df.is_paid = '1') THEN 'Paid' ELSE 'Unpaid' END
		) as status, 
		COALESCE(
			df.tax_receipt_num, dr.receipt_number
		) as tax_receipt_num, 
		dr.receipt_prefix, 
		(
			CASE WHEN (dp.payment_mode = 'payeezy') THEN cp.transaction_id ELSE dp.reference_number END
		) as ref_id, 
		'donation' as receipt_purpose, 
		(
		  CASE WHEN apc.id is not null then 'Yes' else 'No' end
		) as process_status, 
		cn.countries_name as country_name, 
		df.sehm, 
		df.marjaa, 
		df.is_syed,
		ssw.title as pkg_title
	  FROM 
		tb_donation_form df 
		INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value 
		AND dp.table_name = 'tb_donation_form' 
		LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id 
		LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id 
		AND cp.is_cron = 0 
		LEFT JOIN tb_event_registrations er ON er.donation_form_id = df.id
		LEFT JOIN tb_sitesectionswidgets ssw ON ssw.id = er.event_id
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id 
		LEFT JOIN imi_conf_restore2.tb_countries cn ON cn.id = df.home_country 
		LEFT join tb_all_payments_compiled apc on apc.df_id = df.id 
		LEFT join tb_external_payments ep on ep.id = apc.external_payment_id 
		LEFT join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id 
		LEFT join tb_payeezy_transaction_data petd on petd.id = ep.transaction_payeezy_id 
        INNER JOIN tb_payment_receipts dr ON df.id = dr.table_id_value 
		AND dr.table_name = 'tb_donation_form' 
		AND (
			petd.id is null 
			OR CAST(dr.created_at AS DATE) = CAST(petd.time AS DATE) 
			OR df.donation_mode != 'recurring'
		) 
	  WHERE 
		df.is_paid = 1 
		AND df.is_active = 1 
		AND df.belongs_country IN($get_belongsto)
		AND DATE(
		  COALESCE(
			ptd.transaction_initiation_date, 
			petd.time, 
			CAST(df.date_added AS DATETIME)
		  )
		) >= SUBDATE(CURRENT_DATE, 180) 
		UNION ALL 
		select 
		DISTINCT 
		df.id,
		df.card_name as name,
		COALESCE(ptd.card_holder_name, petd.cardholder_name) as card_holder_name, 
		COALESCE(ptd.transaction_amount, df.donate_amount, petd.amount) as amount,
		CAST(df.date_added AS DATETIME) as Date, 
		'IMI Donation In Honor Of Someone' as dpdesc, 
		dp.payment_mode as payment_method, 
		'onetime' as payment_mode, 
		'' as donation_frequency, 
		'' as honoree_name, 
		up.home_full_address, 
		up.home_city, 
		up.home_state_province, 
		up.cellphone_number, 
		up.home_zipcode as zip, 
		COALESCE(
			ptd.email_address, df.card_email
		) as email_address, 
		(
		CASE WHEN (df.is_paid = '1') THEN 'Paid' ELSE 'Unpaid' END
		) as status, 
		dr.receipt_number as tax_receipt_num, 
		dr.receipt_prefix, 
		cp.transaction_id as ref_id, 
		'honor_donation' as receipt_purpose, 
		CASE WHEN apc.id is not null then 'Yes' else 'No' end, 
		cn.countries_name as country_name, 
		'' as sehm, 
		'' as marjaa, 
		'' as is_syed,
		'' as pkg_title
		FROM 
		tb_give_honor_someone df 
		INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value 
		AND dp.table_name = 'tb_give_honor_someone' 
		INNER JOIN tb_payment_receipts dr ON df.id = dr.table_id_value 
		AND dr.table_name = 'tb_give_honor_someone' 
		LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id 
		AND cp.is_cron = 0 
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id 
		LEFT JOIN imi_conf_restore2.tb_countries cn ON cn.id = df.home_country 
		left join tb_all_payments_compiled apc on apc.df_id = df.id
		left join tb_external_payments ep on ep.id = apc.external_payment_id
		left join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id
		left join tb_payeezy_transaction_data petd on petd.id = transaction_payeezy_id
		WHERE 
			df.is_paid = 1 
			AND df.is_active = 1 
			AND df.belongs_country IN($get_belongsto)
			AND DATE( CAST(df.date_added AS DATETIME) ) >= SUBDATE(CURRENT_DATE, 180)
		UNION ALL 
	  	select 
		DISTINCT 
		um.id,
		u.name, 
		COALESCE(ptd.card_holder_name, petd.cardholder_name) as card_holder_name, 
		COALESCE(ptd.transaction_amount, IF(
		  membership_package_price IS NULL 
		  or membership_package_price = ' ', 
		  um_p.price, 
		  membership_package_price
		), petd.amount) as amount,
		COALESCE(ptd.transaction_initiation_date, petd.time, um.date_purchased) as Date,
		IF(
		  membership_package_name IS NULL 
		  or membership_package_name = ' ', 
		  um_p.name, 
		  membership_package_name
		) as dpdesc, 
		'paypal' as payment_method,
		ptd.transaction_event_code as payment_mode,
		(
			CASE WHEN (
			um.membership_package_per = 'Year'
			) THEN 'Yearly' WHEN (
			um.membership_package_per = 'Life'
			) THEN 'Lifetime' ELSE '' END
		) as donation_frequency, 
		'' as honoree_name, 
		up.home_full_address as home_full_address, 
		up.home_city, 
		up.home_state_province, 
		up.cellphone_number, 
		up.home_zipcode as zip, 
		COALESCE(
			ptd.email_address, 
			LOWER(u.email)
		) as email_address, 
		(
		  CASE WHEN (u.ispaid = '1') THEN 'Paid' ELSE 'Unpaid' END
		) as status, 
		dr.receipt_number as tax_receipt,
		dr.receipt_prefix,
		um.paypal_payer_id as ref_id, 
		'membershipregistration' as receipt_purpose,
		CASE WHEN apc.id is not null then 'Yes' else 'No' end,
		hc.countries_name as belongstoz, 
		'' as sehm, 
		'' as marjaa, 
		'' as is_syed,
		'' as pkg_title
	  FROM 
		imi_conf_restore2.tb_users u 
		INNER JOIN imi_conf_restore2.tb_user_memberships um ON um.id = (
		  SELECT 
			t1.id 
		  FROM 
			imi_conf_restore2.tb_user_memberships t1 
		  WHERE 
			t1.user_id = u.id 
		  ORDER BY 
			IFNULL(member_expiry, date_purchased) DESC 
		  LIMIT 
			1
		) INNER JOIN tb_payment_receipts dr ON um.id = dr.table_id_value 
		AND dr.table_name = 'tb_user_memberships' 
		LEFT JOIN tb_short_conference_prices_not_a_member um_p ON um.membership_package_id = um_p.id 
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = u.id 
		LEFT JOIN imi_conf_restore2.tb_countries hc ON hc.id = up.home_country 
		left join tb_all_payments_compiled apc on apc.um_id in (
		  SELECT 
			t1.id 
		  FROM 
			imi_conf_restore2.tb_user_memberships t1 
		  WHERE 
			t1.user_id = u.id 
		)
		left join tb_external_payments ep on ep.id = apc.external_payment_id
		left join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id
		left join tb_payeezy_transaction_data petd on petd.id = ep.transaction_payeezy_id
		WHERE DATE( COALESCE(ptd.transaction_initiation_date, petd.time, um.date_purchased) ) >= SUBDATE(CURRENT_DATE, 180)
	  
	  UNION ALL 
	  SELECT 
		(SELECT 
		userid 
		FROM 
			tb_short_conference_registration_master 
		WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid) as id,
		full_name,
		COALESCE(ptd.card_holder_name, petd.cardholder_name) as card_holder_name, 
		COALESCE(ptd.transaction_amount, (
		  SELECT 
			price_total_payable 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		), petd.amount) as amount,
		COALESCE(ptd.transaction_initiation_date, petd.time, (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		), (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_payments 
		  WHERE 
			conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid 
			AND payment_status = 'Completed' 
		  LIMIT 
			1
		)) as Date,
		(
		  SELECT 
			name 
		  FROM 
			tb_short_conference 
		  WHERE 
			id IN (
			  (
				SELECT 
				  conferenceid 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  )
			)
		) as conference_name, 
		(
		  SELECT 
			payment_type 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid
		) as payment_type,
		'onetime' as payment_mode,
		'' as donation_frequency, 
		'' as honoree_name, 
		'' as home_full_address, 
		'' as home_city, 
		'' as home_state_province, 
		(
			SELECT 
			  phone 
			FROM 
			  tb_short_conference_registration_screen_one 
			WHERE 
			  conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		  ) as cellphone_number,
		'' as zip, 
		COALESCE(
			ptd.email_address, 
			(
		  SELECT 
			email 
		  FROM 
			tb_short_conference_registration_screen_one 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
			)
		) as email_address, 
		NULL as status,
		(
		  SELECT 
			tax_receipt_num 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid
		) as tax_receipt, 
		'SC' as receipt_prefix, 
		(
			SELECT 
			ipn_track_id 
			FROM 
			tb_short_conference_payments 
			WHERE 
			conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid
			AND payment_status = 'Completed' 
			LIMIT 
		  	1
		) as ref_id, 
		'shortconferencceregistration' as receipt_purpose,
		CASE WHEN apc.id is not null then 'Yes' else 'No' end,
		'', 
		'' as sehm, 
		'' as marjaa, 
		'' as is_syed,
		'' as pkg_title
	  FROM 
		tb_short_conference_registration_screen_three 
	  left join tb_all_payments_compiled apc on apc.sc_id = tb_short_conference_registration_screen_three.conferenceregistrationid
	  left join tb_external_payments ep on ep.id = apc.external_payment_id
	  left join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id
	  left join tb_payeezy_transaction_data petd on petd.id = transaction_payeezy_id
	  WHERE 
		parentid = '0' 
		AND (
		  (
			SELECT 
			  is_paid 
			FROM 
			  tb_short_conference_registration_master 
			WHERE 
			  id = tb_short_conference_registration_screen_three.conferenceregistrationid
		  ) = 1 || (
			(
			  SELECT 
				is_paid 
			  FROM 
				tb_short_conference_registration_master 
			  WHERE 
				id = tb_short_conference_registration_screen_three.conferenceregistrationid
			) = 0 
			AND (
			  (
				SELECT 
				  payment_allow 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 0 || (
				SELECT 
				  payment_allow 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 1
			) 
			AND (
			  (
				SELECT 
				  payment_type 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 'cash'
			)
		  )
		) 
		AND (
		  SELECT 
			conferenceid 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid
		) = 5
	  AND DATE( COALESCE(ptd.transaction_initiation_date, petd.time, (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		))) >= SUBDATE(CURRENT_DATE, 180)
	  union
	  select
	  apc.id,
	  '' as name,
		COALESCE(ptd.card_holder_name, petd.cardholder_name) as card_holder_name, 
		COALESCE(ptd.transaction_amount, petd.amount) as amount,
		COALESCE(ptd.transaction_initiation_date, petd.time) as Date,
		ptd.item_name,
		(
			CASE WHEN ptd.id IS NOT NULL THEN 'paypal' ELSE 'payeezy' END
		), 
		ptd.transaction_event_code,
		'' as donation_frequency, 
		'' as honoree_name, 
		'' as home_full_address, 
		'' as home_city, 
		'' as home_state_province, 
		'' as cellphone_number, 
		'' as zip, 
		ptd.email_address as email_address,
		COALESCE(
			ptd.transaction_status, petd.status
		) as status, 
		'' as tax_receipt,
		'' as receipt_prefix, 
		'' as receipt_purpose, 
		COALESCE(ptd.transaction_id, petd.auth_no) as ref_id, 
		'No' as process_status,
		'', 
		'' as sehm, 
		'' as marjaa, 
		'' as is_syed,
		'' as pkg_title
		from 
		tb_all_payments_compiled apc 
		INNER JOIN tb_external_payments ep ON apc.external_payment_id = ep.id 
		LEFT JOIN tb_paypal_transaction_data ptd ON ep.transaction_paypal_id = ptd.id
		LEFT JOIN tb_payeezy_transaction_data petd ON ep.transaction_payeezy_id = petd.id
		where 
		apc.df_id is null 
		and apc.um_id is null 
		and apc.sc_id is null 
		and DATE(
			COALESCE(
			ptd.transaction_initiation_date, 
			petd.time
			)
		) >= SUBDATE(CURRENT_DATE, 30) 
	  ORDER BY 
		Date desc
		";

		$view_data = $this->db->query($query);




		$final_data = [];

		

		if($view_data->num_rows()>0){
			$data_for_view    = $view_data->result_array();
			
			
			foreach($data_for_view as $data_per_view_row){

				// echo '<pre>';
				// print_r($data_per_view_row);

				// die;
				// echo '</pre>'; 

				if($data_per_view_row['amount'] < 0){
					continue;
				}

				$status       = $data_per_view_row['status'] == 'S' ? 'Paid' : $data_per_view_row['status'];
				$payment_mode = $data_per_view_row['payment_mode'] == 'T0007' ? 'onetime' : ($data_per_view_row['payment_mode'] == 'T0002' ? 'recurring' : $data_per_view_row['payment_mode']);
				$payment_method = $data_per_view_row['payment_method'] == 'card' ? 'payeezy' : $data_per_view_row['payment_method'];

				// var_dump($name);
				$date_tempp = $data_per_view_row['Date'];  
				$date_temp  = new DateTime($date_tempp);
				/* echo '<pre>';
				// // var_dump($data_per_view_row['first_name'] . ' ' . $data_per_view_row['last_name']);
				print_r($data_per_view_row);
				// print_r($date_temp);
				// var_dump($date_temp->format('Y-m-d'));
				echo '</pre>';  */
				// var_dump($date_temp->format('Y-m-d'));
				// $final_data[] = [
				// 	"card_holder_name"   	=> $data_per_view_row['card_holder_name'],
				// 	"full_name"          	=> $data_per_view_row['name'],
				// 	"transaction_amount" 	=> round($data_per_view_row['amount'], 2),
				// 	"date"               	=> $date_temp->format('Y-m-d'),
				// 	"purpose" 			 	=> $data_per_view_row['dpdesc'],
				// 	"payment_method"     	=> $payment_method,
				// 	"donation_mode"      	=> $payment_mode,
				// 	"country_name"       	=> $data_per_view_row['country_name'],
				// 	"email_address"      	=> $data_per_view_row['email_address'],
				// 	"transaction_status" 	=> $status,
				// 	"tax_receipt"        	=> $data_per_view_row['tax_receipt_num'],
				// 	"reconciliation_status" => $data_per_view_row['process_status'],
				// 	"receipt_id"            => $data_per_view_row['id'],
				// 	"receipt_prefix"        => $data_per_view_row['receipt_prefix'],
				// 	"receipt_purpose"       => $data_per_view_row['receipt_purpose'],
				// ];

				$final_data[] = [
						"card_holder_name"   	=> $data_per_view_row['card_holder_name'],
						"full_name"          	=> $data_per_view_row['name'],
						"transaction_amount" 	=> round($data_per_view_row['amount'], 2),
						"date"               	=> $date_temp->format('Y-m-d'),
						"purpose" 			 	=> !empty($data_per_view_row['pkg_title']) ? $data_per_view_row['pkg_title'] : $data_per_view_row['dpdesc'],
						"payment_method"     	=> $data_per_view_row['payment_method'],
						"donation_mode"      	=> $payment_mode,
						"country_name"       	=> $data_per_view_row['country_name'],
						"email_address"      	=> $data_per_view_row['email_address'],
						"transaction_status" 	=> $status,
						"tax_receipt"        	=> $data_per_view_row['tax_receipt_num'],
						"reconciliation_status" => $data_per_view_row['process_status'],
						"receipt_id"            => $data_per_view_row['id'],
						"receipt_prefix"        => $data_per_view_row['receipt_prefix'],
						"receipt_purpose"       => !empty($data_per_view_row['pkg_title']) ? 'eventregistration' : $data_per_view_row['receipt_purpose'],
						"sehm"      			=> $data_per_view_row['sehm'],
						"syed"      			=> $data_per_view_row['syed'],
						"marjaa"       			=> $data_per_view_row['marjaa'],
						"ref_id"       			=> $data_per_view_row['ref_id'],
						"home_full_address"     => $data_per_view_row['home_full_address'],
						"home_city"       		=> $data_per_view_row['home_city'],
						"home_state_province"   => $data_per_view_row['home_state_province'],
						"cellphone_number"      => $data_per_view_row['cellphone_number'],
						"honoree_name"      	=> $data_per_view_row['honoree_name'],
						"payment_frequency"     => $data_per_view_row['donation_frequency'],
				];
				
			}/* die; */

			// echo "<pre>";
			// print_r($final_data);
			return $final_data;
		}


	}

	public function fetch_filter_records( $id = array(), $where = FALSE, $payment_method )
	{
		$get_role_id 		= $this->functions->_admincms_logged_in_details( "roleid" ); 
		$get_belongsto 		= $this->functions->_admincms_logged_in_details( "belongs_country" );
		// var_dump($get_role_id);
		// var_dump($get_belongsto); die;
		// check if admin or superadmin then assign all of belongs_country id
		if($get_role_id == 1 || $get_role_id == 4){ 
			$get_belongsto =  implode(',',array_keys(DropdownHelper::cmsmenubelongsto_dropdown()));	
		     // print_r($get_belongsto);
			// die;
		}

		$query = "select 
		DISTINCT df.id, 
		df.first_name as name, 
		COALESCE(
		  ptd.card_holder_name, petd.cardholder_name
		) as card_holder_name, 
		COALESCE(
		  ptd.transaction_amount, df.donate_amount, 
		  petd.amount
		) as amount, 
		COALESCE(
		  ptd.transaction_initiation_date, 
		  petd.time, 
		  CAST(df.date_added AS DATETIME)
		) as Date, 
		dpp.name as dpdesc, 
		dp.payment_mode as payment_method, 
		df.donation_mode as payment_mode, 
		(
			CASE WHEN (df.donation_freq = 'M-1') THEN 'Monthly' WHEN (df.donation_freq = 'M-3') THEN 'Quarterly' WHEN (df.donation_freq = 'M-6') THEN 'Half Yearly' ELSE 'Yearly' END
		) as donation_frequency, 
		df.donate_honoree as honoree_name, 
		(
			CASE WHEN (up.home_full_address IS NULL) THEN df.home_address ELSE up.home_full_address END
		) as home_full_address, 
		up.home_city, 
		up.home_state_province, 
		up.cellphone_number, 
		IFNULL(
			df.home_zipcode, up.home_zipcode
		) as zip,
		COALESCE(ptd.email_address, df.email) as email_address, 
		(
		  CASE WHEN (df.is_paid = '1') THEN 'Paid' ELSE 'Unpaid' END
		) as status, 
		COALESCE(
			df.tax_receipt_num, dr.receipt_number
		) as tax_receipt_num, 
		dr.receipt_prefix, 
		(
			CASE WHEN (dp.payment_mode = 'payeezy') THEN cp.transaction_id ELSE dp.reference_number END
		) as ref_id, 
		'donation' as receipt_purpose, 
		(
		  CASE WHEN apc.id is not null then 'Yes' else 'No' end
		) as process_status, 
		cn.countries_name as country_name, 
		df.sehm, 
		df.marjaa, 
		df.is_syed,
		ssw.title as pkg_title
	  FROM 
		tb_donation_form df 
		INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value 
		AND dp.table_name = 'tb_donation_form' 
		LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id 
		LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id 
		AND cp.is_cron = 0 
		LEFT JOIN tb_event_registrations er ON er.donation_form_id = df.id
		LEFT JOIN tb_sitesectionswidgets ssw ON ssw.id = er.event_id
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id 
		LEFT JOIN imi_conf_restore2.tb_countries cn ON cn.id = df.home_country 
		LEFT join tb_all_payments_compiled apc on apc.df_id = df.id 
		LEFT join tb_external_payments ep on ep.id = apc.external_payment_id 
		LEFT join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id 
		LEFT join tb_payeezy_transaction_data petd on petd.id = ep.transaction_payeezy_id 
        INNER JOIN tb_payment_receipts dr ON df.id = dr.table_id_value 
		AND dr.table_name = 'tb_donation_form' 
		AND (
			petd.id is null 
			OR CAST(dr.created_at AS DATE) = CAST(petd.time AS DATE) 
			OR df.donation_mode != 'recurring'
		) 
	  WHERE 
		df.is_paid = 1 
		AND df.is_active = 1 
		AND df.belongs_country IN($get_belongsto)
		AND DATE(
		  COALESCE(
			ptd.transaction_initiation_date, 
			petd.time, 
			CAST(df.date_added AS DATETIME)
		  )
		) >= SUBDATE(CURRENT_DATE, 10) 
		UNION ALL 
		select 
		DISTINCT 
		df.id,
		df.card_name as name,
		COALESCE(ptd.card_holder_name, petd.cardholder_name) as card_holder_name, 
		COALESCE(ptd.transaction_amount, df.donate_amount, petd.amount) as amount,
		CAST(df.date_added AS DATETIME) as Date, 
		'IMI Donation In Honor Of Someone' as dpdesc, 
		dp.payment_mode as payment_method, 
		'onetime' as payment_mode, 
		'' as donation_frequency, 
		'' as honoree_name, 
		up.home_full_address, 
		up.home_city, 
		up.home_state_province, 
		up.cellphone_number, 
		up.home_zipcode as zip, 
		COALESCE(
			ptd.email_address, df.card_email
		) as email_address, 
		(
		CASE WHEN (df.is_paid = '1') THEN 'Paid' ELSE 'Unpaid' END
		) as status, 
		dr.receipt_number as tax_receipt_num, 
		dr.receipt_prefix, 
		cp.transaction_id as ref_id, 
		'honor_donation' as receipt_purpose, 
		CASE WHEN apc.id is not null then 'Yes' else 'No' end, 
		cn.countries_name as country_name, 
		'' as sehm, 
		'' as marjaa, 
		'' as is_syed,
		'' as pkg_title
		FROM 
		tb_give_honor_someone df 
		INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value 
		AND dp.table_name = 'tb_give_honor_someone' 
		INNER JOIN tb_payment_receipts dr ON df.id = dr.table_id_value 
		AND dr.table_name = 'tb_give_honor_someone' 
		LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id 
		AND cp.is_cron = 0 
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id 
		LEFT JOIN imi_conf_restore2.tb_countries cn ON cn.id = df.home_country 
		left join tb_all_payments_compiled apc on apc.df_id = df.id
		left join tb_external_payments ep on ep.id = apc.external_payment_id
		left join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id
		left join tb_payeezy_transaction_data petd on petd.id = transaction_payeezy_id
		WHERE 
			df.is_paid = 1 
			AND df.is_active = 1 
			AND df.belongs_country IN($get_belongsto)
			AND DATE( CAST(df.date_added AS DATETIME) ) >= SUBDATE(CURRENT_DATE, 10)
		UNION ALL 
	  	select 
		DISTINCT 
		um.id,
		u.name, 
		COALESCE(ptd.card_holder_name, petd.cardholder_name) as card_holder_name, 
		COALESCE(ptd.transaction_amount, IF(
		  membership_package_price IS NULL 
		  or membership_package_price = ' ', 
		  um_p.price, 
		  membership_package_price
		), petd.amount) as amount,
		COALESCE(ptd.transaction_initiation_date, petd.time, um.date_purchased) as Date,
		IF(
		  membership_package_name IS NULL 
		  or membership_package_name = ' ', 
		  um_p.name, 
		  membership_package_name
		) as dpdesc, 
		'paypal' as payment_method,
		ptd.transaction_event_code as payment_mode,
		(
			CASE WHEN (
			um.membership_package_per = 'Year'
			) THEN 'Yearly' WHEN (
			um.membership_package_per = 'Life'
			) THEN 'Lifetime' ELSE '' END
		) as donation_frequency, 
		'' as honoree_name, 
		up.home_full_address as home_full_address, 
		up.home_city, 
		up.home_state_province, 
		up.cellphone_number, 
		up.home_zipcode as zip, 
		COALESCE(
			ptd.email_address, 
			LOWER(u.email)
		) as email_address, 
		(
		  CASE WHEN (u.ispaid = '1') THEN 'Paid' ELSE 'Unpaid' END
		) as status, 
		dr.receipt_number as tax_receipt,
		dr.receipt_prefix,
		um.paypal_payer_id as ref_id, 
		'membershipregistration' as receipt_purpose,
		CASE WHEN apc.id is not null then 'Yes' else 'No' end,
		hc.countries_name as belongstoz, 
		'' as sehm, 
		'' as marjaa, 
		'' as is_syed,
		'' as pkg_title
	  FROM 
		imi_conf_restore2.tb_users u 
		INNER JOIN imi_conf_restore2.tb_user_memberships um ON um.id = (
		  SELECT 
			t1.id 
		  FROM 
			imi_conf_restore2.tb_user_memberships t1 
		  WHERE 
			t1.user_id = u.id 
		  ORDER BY 
			IFNULL(member_expiry, date_purchased) DESC 
		  LIMIT 
			1
		) INNER JOIN tb_payment_receipts dr ON um.id = dr.table_id_value 
		AND dr.table_name = 'tb_user_memberships' 
		LEFT JOIN tb_short_conference_prices_not_a_member um_p ON um.membership_package_id = um_p.id 
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = u.id 
		LEFT JOIN imi_conf_restore2.tb_countries hc ON hc.id = up.home_country 
		left join tb_all_payments_compiled apc on apc.um_id in (
		  SELECT 
			t1.id 
		  FROM 
			imi_conf_restore2.tb_user_memberships t1 
		  WHERE 
			t1.user_id = u.id 
		)
		left join tb_external_payments ep on ep.id = apc.external_payment_id
		left join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id
		left join tb_payeezy_transaction_data petd on petd.id = ep.transaction_payeezy_id
		WHERE DATE( COALESCE(ptd.transaction_initiation_date, petd.time, um.date_purchased) ) >= SUBDATE(CURRENT_DATE, 10)
	  
	  UNION ALL 
	  SELECT 
		(SELECT 
		userid 
		FROM 
			tb_short_conference_registration_master 
		WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid) as id,
		full_name,
		COALESCE(ptd.card_holder_name, petd.cardholder_name) as card_holder_name, 
		COALESCE(ptd.transaction_amount, (
		  SELECT 
			price_total_payable 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		), petd.amount) as amount,
		COALESCE(ptd.transaction_initiation_date, petd.time, (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		), (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_payments 
		  WHERE 
			conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid 
			AND payment_status = 'Completed' 
		  LIMIT 
			1
		)) as Date,
		(
		  SELECT 
			name 
		  FROM 
			tb_short_conference 
		  WHERE 
			id IN (
			  (
				SELECT 
				  conferenceid 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  )
			)
		) as conference_name, 
		(
		  SELECT 
			payment_type 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid
		) as payment_type,
		'onetime' as payment_mode,
		'' as donation_frequency, 
		'' as honoree_name, 
		'' as home_full_address, 
		'' as home_city, 
		'' as home_state_province, 
		(
			SELECT 
			  phone 
			FROM 
			  tb_short_conference_registration_screen_one 
			WHERE 
			  conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		  ) as cellphone_number,
		'' as zip, 
		COALESCE(
			ptd.email_address, 
			(
		  SELECT 
			email 
		  FROM 
			tb_short_conference_registration_screen_one 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
			)
		) as email_address, 
		NULL as status,
		(
		  SELECT 
			tax_receipt_num 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid
		) as tax_receipt, 
		'SC' as receipt_prefix, 
		(
			SELECT 
			ipn_track_id 
			FROM 
			tb_short_conference_payments 
			WHERE 
			conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid
			AND payment_status = 'Completed' 
			LIMIT 
		  	1
		) as ref_id, 
		'shortconferencceregistration' as receipt_purpose,
		CASE WHEN apc.id is not null then 'Yes' else 'No' end,
		'', 
		'' as sehm, 
		'' as marjaa, 
		'' as is_syed,
		'' as pkg_title
	  FROM 
		tb_short_conference_registration_screen_three 
	  left join tb_all_payments_compiled apc on apc.sc_id = tb_short_conference_registration_screen_three.conferenceregistrationid
	  left join tb_external_payments ep on ep.id = apc.external_payment_id
	  left join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id
	  left join tb_payeezy_transaction_data petd on petd.id = transaction_payeezy_id
	  WHERE 
		parentid = '0' 
		AND (
		  (
			SELECT 
			  is_paid 
			FROM 
			  tb_short_conference_registration_master 
			WHERE 
			  id = tb_short_conference_registration_screen_three.conferenceregistrationid
		  ) = 1 || (
			(
			  SELECT 
				is_paid 
			  FROM 
				tb_short_conference_registration_master 
			  WHERE 
				id = tb_short_conference_registration_screen_three.conferenceregistrationid
			) = 0 
			AND (
			  (
				SELECT 
				  payment_allow 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 0 || (
				SELECT 
				  payment_allow 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 1
			) 
			AND (
			  (
				SELECT 
				  payment_type 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 'cash'
			)
		  )
		) 
		AND (
		  SELECT 
			conferenceid 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid
		) = 5
	  AND DATE( COALESCE(ptd.transaction_initiation_date, petd.time, (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		))) >= SUBDATE(CURRENT_DATE, 10)
	  union
	  select
	  apc.id,
	  '' as name,
		COALESCE(ptd.card_holder_name, petd.cardholder_name) as card_holder_name, 
		COALESCE(ptd.transaction_amount, petd.amount) as amount,
		COALESCE(ptd.transaction_initiation_date, petd.time) as Date,
		ptd.item_name,
		(
			CASE WHEN ptd.id IS NOT NULL THEN 'paypal' ELSE 'payeezy' END
		), 
		ptd.transaction_event_code,
		'' as donation_frequency, 
		'' as honoree_name, 
		'' as home_full_address, 
		'' as home_city, 
		'' as home_state_province, 
		'' as cellphone_number, 
		'' as zip, 
		ptd.email_address as email_address,
		COALESCE(
			ptd.transaction_status, petd.status
		) as status, 
		'' as tax_receipt,
		'' as receipt_prefix, 
		'' as receipt_purpose, 
		COALESCE(ptd.transaction_id, petd.auth_no) as ref_id, 
		'No' as process_status,
		'', 
		'' as sehm, 
		'' as marjaa, 
		'' as is_syed,
		'' as pkg_title
		from 
		tb_all_payments_compiled apc 
		INNER JOIN tb_external_payments ep ON apc.external_payment_id = ep.id 
		LEFT JOIN tb_paypal_transaction_data ptd ON ep.transaction_paypal_id = ptd.id
		LEFT JOIN tb_payeezy_transaction_data petd ON ep.transaction_payeezy_id = petd.id
		where 
		apc.df_id is null 
		and apc.um_id is null 
		and apc.sc_id is null 
		and DATE(
			COALESCE(
			ptd.transaction_initiation_date, 
			petd.time
			)
		) >= SUBDATE(CURRENT_DATE, 5) 
	  ORDER BY 
		Date desc
		";

		$view_data = $this->db->query($query);

		$final_data = [];

		

		if($view_data->num_rows()>0){
			$data_for_view    = $view_data->result_array();
			
			
			foreach($data_for_view as $data_per_view_row){

				// echo '<pre>';
				// print_r($data_per_view_row);

				// die;
				// echo '</pre>'; 

				if($data_per_view_row['amount'] < 0){
					continue;
				}

				$status       = $data_per_view_row['status'] == 'S' ? 'Paid' : $data_per_view_row['status'];
				$payment_mode = $data_per_view_row['payment_mode'] == 'T0007' ? 'onetime' : ($data_per_view_row['payment_mode'] == 'T0002' ? 'recurring' : $data_per_view_row['payment_mode']);
				$payment_method = $data_per_view_row['payment_method'] == 'card' ? 'payeezy' : $data_per_view_row['payment_method'];

				// var_dump($name);
				$date_tempp = $data_per_view_row['Date'];  
				$date_temp  = new DateTime($date_tempp);
				/* echo '<pre>';
				// // var_dump($data_per_view_row['first_name'] . ' ' . $data_per_view_row['last_name']);
				print_r($data_per_view_row);
				// print_r($date_temp);
				// var_dump($date_temp->format('Y-m-d'));
				echo '</pre>';  */
				// var_dump($date_temp->format('Y-m-d'));
				// $final_data[] = [
				// 	"card_holder_name"   	=> $data_per_view_row['card_holder_name'],
				// 	"full_name"          	=> $data_per_view_row['name'],
				// 	"transaction_amount" 	=> round($data_per_view_row['amount'], 2),
				// 	"date"               	=> $date_temp->format('Y-m-d'),
				// 	"purpose" 			 	=> $data_per_view_row['dpdesc'],
				// 	"payment_method"     	=> $payment_method,
				// 	"donation_mode"      	=> $payment_mode,
				// 	"country_name"       	=> $data_per_view_row['country_name'],
				// 	"email_address"      	=> $data_per_view_row['email_address'],
				// 	"transaction_status" 	=> $status,
				// 	"tax_receipt"        	=> $data_per_view_row['tax_receipt_num'],
				// 	"reconciliation_status" => $data_per_view_row['process_status'],
				// 	"receipt_id"            => $data_per_view_row['id'],
				// 	"receipt_prefix"        => $data_per_view_row['receipt_prefix'],
				// 	"receipt_purpose"       => $data_per_view_row['receipt_purpose'],
				// ];

				$final_data[] = [
						"card_holder_name"   	=> $data_per_view_row['card_holder_name'],
						"full_name"          	=> $data_per_view_row['name'],
						"transaction_amount" 	=> round($data_per_view_row['amount'], 2),
						"date"               	=> $date_temp->format('Y-m-d'),
						"purpose" 			 	=> !empty($data_per_view_row['pkg_title']) ? $data_per_view_row['pkg_title'] : $data_per_view_row['dpdesc'],
						"payment_method"     	=> $data_per_view_row['payment_method'],
						"donation_mode"      	=> $payment_mode,
						"country_name"       	=> $data_per_view_row['country_name'],
						"email_address"      	=> $data_per_view_row['email_address'],
						"transaction_status" 	=> $status,
						"tax_receipt"        	=> $data_per_view_row['tax_receipt_num'],
						"reconciliation_status" => $data_per_view_row['process_status'],
						"receipt_id"            => $data_per_view_row['id'],
						"receipt_prefix"        => $data_per_view_row['receipt_prefix'],
						"receipt_purpose"       => !empty($data_per_view_row['pkg_title']) ? 'eventregistration' : $data_per_view_row['receipt_purpose'],
						"sehm"      			=> $data_per_view_row['sehm'],
						"syed"      			=> $data_per_view_row['syed'],
						"marjaa"       			=> $data_per_view_row['marjaa'],
						"ref_id"       			=> $data_per_view_row['ref_id'],
						"home_full_address"     => $data_per_view_row['home_full_address'],
						"home_city"       		=> $data_per_view_row['home_city'],
						"home_state_province"   => $data_per_view_row['home_state_province'],
						"cellphone_number"      => $data_per_view_row['cellphone_number'],
						"honoree_name"      	=> $data_per_view_row['honoree_name'],
						"payment_frequency"     => $data_per_view_row['donation_frequency'],
				];
				
			}/* die; */

			// echo "<pre>";
			// print_r($final_data);
			return $final_data;
		}


	}
	public function fetch_records_for_csv_payeezy( $id = array(), $where = FALSE, $payment_method )
	{
		$get_role_id 		= $this->functions->_admincms_logged_in_details( "roleid" ); 
		$get_belongsto 		= $this->functions->_admincms_logged_in_details( "belongs_country" );
		// var_dump($get_role_id);
		// var_dump($get_belongsto); die;
		// check if admin or superadmin then assign all of belongs_country id
		if($get_role_id == 1 || $get_role_id == 4){ 
			$get_belongsto =  implode(',',array_keys(DropdownHelper::cmsmenubelongsto_dropdown()));
			

		}

		$query = "select 
		DISTINCT
		df.id,
		df.first_name as name,
		petd.cardholder_name as card_holder_name, 
		COALESCE(petd.amount, df.donate_amount) as amount,
		COALESCE(petd.time, CAST(df.date_added AS DATETIME)) as Date,
		dpp.name as dpdesc, 
		dp.payment_mode as payment_method,
		df.donation_mode as payment_mode,
		(CASE WHEN (df.donation_freq = 'M-1') THEN 'Monthly' WHEN (df.donation_freq = 'M-3') THEN 'Quarterly' WHEN (df.donation_freq = 'M-6') THEN 'Half Yearly' ELSE 'Yearly' END) as donation_frequency, 
		df.donate_honoree as honoree_name,
		(CASE WHEN (up.home_full_address IS NULL) THEN df.home_address ELSE up.home_full_address END) as home_full_address,
		up.home_city,
		up.home_state_province,
		up.cellphone_number,
		IFNULL(df.home_zipcode,up.home_zipcode) as zip,
		df.email as email_address,
		(
		  CASE WHEN (df.is_paid = '1') THEN 'Paid' ELSE 'Unpaid' END
		) as status, 
		COALESCE(
			df.tax_receipt_num, 
			dr.receipt_number) as tax_receipt_num,
		dr.receipt_prefix, 
		cp.transaction_id as ref_id,
		'donation' as receipt_purpose,
		(CASE WHEN apc.id is not null then 'Yes' else 'No' end) as process_status,
		cn.countries_name as country_name,
		df.sehm, df.marjaa, df.is_syed,
		ssw.title as pkg_title
		FROM 
		tb_donation_form df 
		INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value 
		AND dp.table_name = 'tb_donation_form' 
		LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id 
		LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id 
		AND cp.is_cron = 0 
		LEFT JOIN tb_event_registrations er ON er.donation_form_id = df.id
		LEFT JOIN tb_sitesectionswidgets ssw ON ssw.id = er.event_id
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id 
		LEFT JOIN imi_conf_restore2.tb_countries cn ON cn.id = df.home_country 
		LEFT join tb_all_payments_compiled apc on apc.df_id = df.id
		LEFT join tb_external_payments ep on ep.id = apc.external_payment_id
		LEFT join tb_payeezy_transaction_data petd on petd.id = transaction_payeezy_id
		INNER JOIN tb_payment_receipts dr ON df.id = dr.table_id_value 
		AND dr.table_name = 'tb_donation_form' AND ( petd.id is null OR CAST(dr.created_at AS DATE) = CAST(
					petd.time AS DATE ) OR df.donation_mode != 'recurring')
		WHERE 
			df.is_paid = 1 
			AND df.is_active = 1 
			AND dp.payment_mode = 'payeezy'
			AND df.belongs_country IN($get_belongsto)
			AND DATE( COALESCE(petd.time, CAST(df.date_added AS DATETIME)) ) >= SUBDATE(CURRENT_DATE, 180)
		UNION ALL 
		select 
		DISTINCT 
		df.id,
		df.card_name as name,
		petd.cardholder_name as card_holder_name, 
		COALESCE(petd.amount, df.donate_amount) as amount,
		CAST(df.date_added AS DATETIME) as Date, 
		'IMI Donation In Honor Of Someone' as dpdesc, 
		dp.payment_mode as payment_method,
		'onetime' as payment_mode,
		'' as donation_frequency,
		'' as honoree_name,
		up.home_full_address,
		up.home_city,
		up.home_state_province,
		up.cellphone_number,
		up.home_zipcode as zip,
		df.card_email as email_address,
		(
		CASE WHEN (df.is_paid = '1') THEN 'Paid' ELSE 'Unpaid' END
		) as status, 
		dr.receipt_number as tax_receipt_num,
		dr.receipt_prefix,
		cp.transaction_id as ref_id,
		'donation' as receipt_purpose,
		(CASE WHEN apc.id is not null then 'Yes' else 'No' end) as process_status,
		cn.countries_name as country_name,
		'' as sehm,'' as marjaa,'' as is_syed,
		'' as pkg_title
		FROM 
		tb_give_honor_someone df 
		INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value 
		AND dp.table_name = 'tb_give_honor_someone' 
		INNER JOIN tb_payment_receipts dr ON df.id = dr.table_id_value 
		AND dr.table_name = 'tb_give_honor_someone' 
		LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id 
		AND cp.is_cron = 0 
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id 
		LEFT JOIN imi_conf_restore2.tb_countries cn ON cn.id = df.home_country 
		left join tb_all_payments_compiled apc on apc.df_id = df.id
		left join tb_external_payments ep on ep.id = apc.external_payment_id
		left join tb_payeezy_transaction_data petd on petd.id = transaction_payeezy_id
		WHERE 
			df.is_paid = 1 
			AND df.is_active = 1 
			AND DATE( CAST(df.date_added AS DATETIME) ) >= SUBDATE(CURRENT_DATE, 180) AND dp.payment_mode = 'payeezy' AND df.belongs_country IN($get_belongsto)
	  UNION ALL 
	  SELECT 
		(SELECT 
		userid 
		FROM 
			tb_short_conference_registration_master 
		WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid) as id,
		full_name,
		petd.cardholder_name as card_holder_name, 
		COALESCE(petd.amount, (
		  SELECT 
			price_total_payable 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		)) as amount,
		COALESCE(petd.time, (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		), (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_payments 
		  WHERE 
			conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid 
			AND payment_status = 'Completed' 
		  LIMIT 
			1
		)) as Date,
		(
		  SELECT 
			name 
		  FROM 
			tb_short_conference 
		  WHERE 
			id IN (
			  (
				SELECT 
				  conferenceid 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  )
			)
		) as conference_name, 
		(
		  SELECT 
			payment_type 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid AND payment_type = 'card'
		) as payment_type,
		'onetime' as payment_mode,
		'' as donation_frequency,
		'' as honoree_name,
		'' as home_full_address,
		'' as home_city,
		'' as home_state_province,
		(
			SELECT 
			  phone 
			FROM 
			  tb_short_conference_registration_screen_one 
			WHERE 
			  conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		  ) as cellphone_number,
		'' as zip,
		(
		  SELECT 
			email 
		  FROM 
			tb_short_conference_registration_screen_one 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		) as email_address,
		NULL as status,
		(
		  SELECT 
			tax_receipt_num 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid
		) as tax_receipt, 
		'SC' as receipt_prefix, 
		(
			SELECT 
			ipn_track_id 
			FROM 
			tb_short_conference_payments 
			WHERE 
			conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid
			AND payment_status = 'Completed' 
			LIMIT 
		  	1
		  ) as ref_id,
		'shortconferencceregistration' as receipt_purpose,
		(CASE WHEN apc.id is not null then 'Yes' else 'No' end) as process_status,
		'',
		'' as sehm,'' as marjaa,'' as is_syed,
		'' as pkg_title
	  FROM 
		tb_short_conference_registration_screen_three 
	  left join tb_all_payments_compiled apc on apc.sc_id = tb_short_conference_registration_screen_three.conferenceregistrationid
	  left join tb_external_payments ep on ep.id = apc.external_payment_id
	  left join tb_payeezy_transaction_data petd on petd.id = transaction_payeezy_id
	  WHERE 
		parentid = '0' 
		AND (
		  (
			SELECT 
			  is_paid 
			FROM 
			  tb_short_conference_registration_master 
			WHERE 
			  id = tb_short_conference_registration_screen_three.conferenceregistrationid
		  ) = 1 || (
			(
			  SELECT 
				is_paid 
			  FROM 
				tb_short_conference_registration_master 
			  WHERE 
				id = tb_short_conference_registration_screen_three.conferenceregistrationid
			) = 0 
			AND (
			  (
				SELECT 
				  payment_allow 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 0 || (
				SELECT 
				  payment_allow 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 1
			) 
			AND (
			  (
				SELECT 
				  payment_type 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 'cash'
			)
		  )
		) 
		AND (
		  SELECT 
			conferenceid 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid
		) = 5
	  AND DATE( COALESCE( petd.time, (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		))) >= SUBDATE(CURRENT_DATE, 180)
	  
	  union
	  select
	  apc.id,
	  '' as name,
		petd.cardholder_name as card_holder_name, 
		petd.amount as amount,
		petd.time,
		'',
		'payeezy',
		'',
		'' as donation_frequency,
		'' as honoree_name,
		'' as home_full_address,
		'' as home_city,
		'' as home_state_province,
		'' as cellphone_number,
		'' as zip,
		'',
		petd.status as status,
		'' as tax_receipt,
		'' as receipt_prefix,  '' as receipt_purpose,
		petd.auth_no as ref_id,
		'No' as process_status,
		'',
		'' as sehm, '' as marjaa, '' as is_syed,
		'' as pkg_title
	  from tb_all_payments_compiled apc
			  INNER JOIN tb_external_payments ep ON apc.external_payment_id = ep.id 
			  LEFT JOIN tb_payeezy_transaction_data petd ON ep.transaction_payeezy_id = petd.id
	  where apc.df_id is null and apc.um_id is null and apc.sc_id is null
	  and DATE( petd.time ) >= SUBDATE(CURRENT_DATE, 180)
	  ORDER BY 
		Date desc";

		$view_data = $this->db->query($query);

		$final_data = [];

		if($view_data->num_rows()>0){
			$data_for_view    = $view_data->result_array();
			
			
			foreach($data_for_view as $data_per_view_row){

				// echo '<pre>';
				// print_r($data_per_view_row);
				// echo '</pre>'; 

				if($data_per_view_row['amount'] < 0){
					continue;
				}

				// var_dump($name);
				$date_tempp = $data_per_view_row['Date'];  
				$date_temp  = new DateTime($date_tempp);
				/* echo '<pre>';
				// // var_dump($data_per_view_row['first_name'] . ' ' . $data_per_view_row['last_name']);
				print_r($data_per_view_row);
				// print_r($date_temp);
				// var_dump($date_temp->format('Y-m-d'));
				echo '</pre>';  */
				// var_dump($date_temp->format('Y-m-d'));
				$final_data[] = [
					"card_holder_name"   	=> $data_per_view_row['card_holder_name'],
					"full_name"          	=> $data_per_view_row['name'],
					"transaction_amount" 	=> round($data_per_view_row['amount'], 2),
					"date"               	=> $date_temp->format('Y-m-d'),
					"purpose" 			 	=> !empty($data_per_view_row['pkg_title']) ? $data_per_view_row['pkg_title'] : $data_per_view_row['dpdesc'],
					"payment_method"     	=> $data_per_view_row['payment_method'],
					"donation_mode"      	=> $data_per_view_row['payment_mode'],
					"country_name"       	=> $data_per_view_row['country_name'],
					"email_address"      	=> $data_per_view_row['email_address'],
					"transaction_status" 	=> $data_per_view_row['status'],
					"tax_receipt"        	=> $data_per_view_row['tax_receipt_num'],
					"reconciliation_status" => $data_per_view_row['process_status'],
					"receipt_id"            => $data_per_view_row['id'],
					"receipt_prefix"        => $data_per_view_row['receipt_prefix'],
					"receipt_purpose"       => $data_per_view_row['receipt_purpose'],
					"sehm"      			=> $data_per_view_row['sehm'],
					"syed"      			=> $data_per_view_row['syed'],
					"marjaa"       			=> $data_per_view_row['marjaa'],
					"ref_id"       			=> $data_per_view_row['ref_id'],
					"home_full_address"     => $data_per_view_row['home_full_address'],
					"home_city"       		=> $data_per_view_row['home_city'],
					"home_state_province"   => $data_per_view_row['home_state_province'],
					"cellphone_number"      => $data_per_view_row['cellphone_number'],
					"honoree_name"      	=> $data_per_view_row['honoree_name'],
					"payment_frequency"     => $data_per_view_row['donation_frequency'],
				];
				
			}/* die; */

			return $final_data;
		}


	}

	public function fetch_records_for_csv_paypal( $id = array(), $where = FALSE, $payment_method )
	{
		$get_role_id 		= $this->functions->_admincms_logged_in_details( "roleid" ); 
		$get_belongsto 		= $this->functions->_admincms_logged_in_details( "belongs_country" );
		// var_dump($get_role_id);
		// var_dump($get_belongsto); die;
		// check if admin or superadmin then assign all of belongs_country id
		if($get_role_id == 1 || $get_role_id == 4){ 
			$get_belongsto =  implode(',',array_keys(DropdownHelper::cmsmenubelongsto_dropdown()));
		}
		
		$query = "select 
		DISTINCT
		df.id,
		df.first_name as name,
		ptd.card_holder_name as card_holder_name, 
		COALESCE(ptd.transaction_amount, df.donate_amount) as amount,
		COALESCE(ptd.transaction_initiation_date, CAST(df.date_added AS DATETIME)) as Date,
		dpp.name as dpdesc, 
		dp.payment_mode as payment_method,
		df.donation_mode as payment_mode,
		(CASE WHEN (df.donation_freq = 'M-1') THEN 'Monthly' WHEN (df.donation_freq = 'M-3') THEN 'Quarterly' WHEN (df.donation_freq = 'M-6') THEN 'Half Yearly' ELSE 'Yearly' END) as donation_frequency, 
		df.donate_honoree as honoree_name,
		(CASE WHEN (up.home_full_address IS NULL) THEN df.home_address ELSE up.home_full_address END) as home_full_address,
		up.home_city,
		up.home_state_province,
		up.cellphone_number,
		IFNULL(df.home_zipcode,up.home_zipcode) as zip,
		COALESCE(ptd.email_address, df.email) as email_address,
		(
		  CASE WHEN (df.is_paid = '1') THEN 'Paid' ELSE 'Unpaid' END
		) as status, 
		COALESCE(
			df.tax_receipt_num, 
			dr.receipt_number) as tax_receipt_num, 
		dr.receipt_prefix, 
		dp.reference_number as ref_id,
		'donation' as receipt_purpose,
		(CASE WHEN apc.id is not null then 'Yes' else 'No' end) as process_status,
		cn.countries_name as country_name,
		df.sehm, df.marjaa, df.is_syed,
		ssw.title as pkg_title
		FROM 
		tb_donation_form df 
		INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value 
		AND dp.table_name = 'tb_donation_form' 
		LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id 
		LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id 
		AND cp.is_cron = 0 
		LEFT JOIN tb_event_registrations er ON er.donation_form_id = df.id
		LEFT JOIN tb_sitesectionswidgets ssw ON ssw.id = er.event_id
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id 
		INNER JOIN tb_payment_receipts dr ON df.id = dr.table_id_value 
		AND dr.table_name = 'tb_donation_form' 
		LEFT JOIN imi_conf_restore2.tb_countries cn ON cn.id = df.home_country 
		LEFT join tb_all_payments_compiled apc on apc.df_id = df.id
		LEFT join tb_external_payments ep on ep.id = apc.external_payment_id
		LEFT join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id
		WHERE 
			df.is_paid = 1 
			AND df.is_active = 1 
			AND df.belongs_country IN($get_belongsto)
			AND DATE( COALESCE(ptd.transaction_initiation_date, CAST(df.date_added AS DATETIME)) ) >= SUBDATE(CURRENT_DATE, 180) AND dp.payment_mode = 'paypal'
		UNION ALL 
		select 
		DISTINCT 
		df.id,
		df.card_name as name,
		ptd.card_holder_name as card_holder_name, 
		COALESCE(ptd.transaction_amount, df.donate_amount) as amount,
		CAST(df.date_added AS DATETIME) as Date, 
		'IMI Donation In Honor Of Someone' as dpdesc, 
		dp.payment_mode as payment_method, 
		'onetime' as payment_mode, 
		'' as donation_frequency,
		'' as honoree_name,
		up.home_full_address,
		up.home_city,
		up.home_state_province,
		up.cellphone_number,
		up.home_zipcode as zip,
		COALESCE(ptd.email_address, df.card_email) as email_address,
		(
		CASE WHEN (df.is_paid = '1') THEN 'Paid' ELSE 'Unpaid' END
		) as status, 
		dr.receipt_number as tax_receipt_num, 
		dr.receipt_prefix,
		dp.reference_number as ref_id,
		'donation' as receipt_purpose,
		(CASE WHEN apc.id is not null then 'Yes' else 'No' end) as process_status,
		cn.countries_name as country_name,
		'' as sehm,'' as marjaa,'' as is_syed,
		'' as pkg_title
		FROM 
		tb_give_honor_someone df 
		INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value 
		AND dp.table_name = 'tb_give_honor_someone' 
		INNER JOIN tb_payment_receipts dr ON df.id = dr.table_id_value 
		AND dr.table_name = 'tb_give_honor_someone' 
		LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id 
		AND cp.is_cron = 0 
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = dp.user_id 
		LEFT JOIN imi_conf_restore2.tb_countries cn ON cn.id = df.home_country 
		left join tb_all_payments_compiled apc on apc.df_id = df.id
		left join tb_external_payments ep on ep.id = apc.external_payment_id
		left join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id
		WHERE 
			df.is_paid = 1 
			AND df.is_active = 1 
			AND df.belongs_country IN($get_belongsto)
			AND DATE( CAST(df.date_added AS DATETIME) ) >= SUBDATE(CURRENT_DATE, 180) AND dp.payment_mode = 'paypal'
		UNION ALL 
	  	select 
		DISTINCT 
		um.id,
		u.name, 
		ptd.card_holder_name as card_holder_name, 
		COALESCE(ptd.transaction_amount, IF(
		  membership_package_price IS NULL 
		  or membership_package_price = ' ', 
		  um_p.price, 
		  membership_package_price
		)) as amount,
		COALESCE(ptd.transaction_initiation_date, um.date_purchased) as Date,
		IF(
		  membership_package_name IS NULL 
		  or membership_package_name = ' ', 
		  um_p.name, 
		  membership_package_name
		) as dpdesc, 
		'paypal' as payment_method,
		ptd.transaction_event_code as payment_mode,
		(CASE WHEN (um.membership_package_per = 'Year') THEN 'Yearly' WHEN (um.membership_package_per = 'Life') THEN 'Lifetime' ELSE '' END) as donation_frequency, 
		'' as honoree_name,
		up.home_full_address as home_full_address,
		up.home_city,
		up.home_state_province,
		up.cellphone_number,
		up.home_zipcode as zip,
		COALESCE(ptd.email_address, LOWER(u.email)) as email_address,
		(
		  CASE WHEN (u.ispaid = '1') THEN 'Paid' ELSE 'Unpaid' END
		) as status, 
		dr.receipt_number as tax_receipt,
		dr.receipt_prefix,
		um.paypal_payer_id as ref_id,
		'membershipregistration' as receipt_purpose,
		(CASE WHEN apc.id is not null then 'Yes' else 'No' end) as process_status,
		hc.countries_name as belongstoz,
		'' as sehm, '' as marjaa, '' as is_syed,
		'' as pkg_title
	  FROM 
		imi_conf_restore2.tb_users u 
		INNER JOIN imi_conf_restore2.tb_user_memberships um ON um.id = (
		  SELECT 
			t1.id 
		  FROM 
			imi_conf_restore2.tb_user_memberships t1 
		  WHERE 
			t1.user_id = u.id 
		  ORDER BY 
			IFNULL(member_expiry, date_purchased) DESC 
		  LIMIT 
			1
		) INNER JOIN tb_payment_receipts dr ON um.id = dr.table_id_value 
		AND dr.table_name = 'tb_user_memberships' 
		LEFT JOIN tb_short_conference_prices_not_a_member um_p ON um.membership_package_id = um_p.id 
		LEFT JOIN imi_conf_restore2.tb_users_profile up ON up.userid = u.id 
		LEFT JOIN imi_conf_restore2.tb_countries hc ON hc.id = up.home_country 
		left join tb_all_payments_compiled apc on apc.um_id in (
		  SELECT 
			t1.id 
		  FROM 
			imi_conf_restore2.tb_user_memberships t1 
		  WHERE 
			t1.user_id = u.id 
		)
		left join tb_external_payments ep on ep.id = apc.external_payment_id
		left join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id
		WHERE DATE( COALESCE(ptd.transaction_initiation_date, um.date_purchased) ) >= SUBDATE(CURRENT_DATE, 180)
	  
	  UNION ALL 
	  SELECT 
		(SELECT 
		userid 
		FROM 
			tb_short_conference_registration_master 
		WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid) as id,
		full_name,
		ptd.card_holder_name as card_holder_name, 
		COALESCE(ptd.transaction_amount, (
		  SELECT 
			price_total_payable 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		)) as amount,
		COALESCE(ptd.transaction_initiation_date, (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		), (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_payments 
		  WHERE 
			conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid 
			AND payment_status = 'Completed' 
		  LIMIT 
			1
		)) as Date,
		(
		  SELECT 
			name 
		  FROM 
			tb_short_conference 
		  WHERE 
			id IN (
			  (
				SELECT 
				  conferenceid 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  )
			)
		) as conference_name, 
		(
		  SELECT 
			payment_type 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid AND payment_type = 'paypal'
		) as payment_type,
		'onetime' as payment_mode,
		'' as donation_frequency,
		'' as honoree_name,
		'' as home_full_address,
		'' as home_city,
		'' as home_state_province,
		(
			SELECT 
			  phone 
			FROM 
			  tb_short_conference_registration_screen_one 
			WHERE 
			  conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		) as cellphone_number,
		'' as zip,
		COALESCE(ptd.email_address, (
		  SELECT 
			email 
		  FROM 
			tb_short_conference_registration_screen_one 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		)) as email_address,
		NULL as status,
		(
		  SELECT 
			tax_receipt_num 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid
		) as tax_receipt, 
		'SC' as receipt_prefix, 
		(
			SELECT 
			ipn_track_id 
			FROM 
			tb_short_conference_payments 
			WHERE 
			conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid
			AND payment_status = 'Completed' 
			  LIMIT 
			1
		  ) as ref_id,
		'shortconferencceregistration' as receipt_purpose,
		(CASE WHEN apc.id is not null then 'Yes' else 'No' end) as process_status,
		'',
		'' as sehm,'' as marjaa,'' as is_syed,
		'' as pkg_title
	  FROM 
		tb_short_conference_registration_screen_three 
	  left join tb_all_payments_compiled apc on apc.sc_id = tb_short_conference_registration_screen_three.conferenceregistrationid
	  left join tb_external_payments ep on ep.id = apc.external_payment_id
	  left join tb_paypal_transaction_data ptd on ptd.id = ep.transaction_paypal_id
	  WHERE 
		parentid = '0' 
		AND (
		  (
			SELECT 
			  is_paid 
			FROM 
			  tb_short_conference_registration_master 
			WHERE 
			  id = tb_short_conference_registration_screen_three.conferenceregistrationid
		  ) = 1 || (
			(
			  SELECT 
				is_paid 
			  FROM 
				tb_short_conference_registration_master 
			  WHERE 
				id = tb_short_conference_registration_screen_three.conferenceregistrationid
			) = 0 
			AND (
			  (
				SELECT 
				  payment_allow 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 0 || (
				SELECT 
				  payment_allow 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 1
			) 
			AND (
			  (
				SELECT 
				  payment_type 
				FROM 
				  tb_short_conference_registration_master 
				WHERE 
				  id = tb_short_conference_registration_screen_three.conferenceregistrationid
			  ) = 'cash'
			)
		  )
		) 
		AND (
		  SELECT 
			conferenceid 
		  FROM 
			tb_short_conference_registration_master 
		  WHERE 
			id = tb_short_conference_registration_screen_three.conferenceregistrationid
		) = 5
	  	AND DATE( COALESCE(ptd.transaction_initiation_date, (
		  SELECT 
			date_added 
		  FROM 
			tb_short_conference_registration_screen_two 
		  WHERE 
			conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid
		))) >= SUBDATE(CURRENT_DATE, 180)
	  union
	  select
	  apc.id,
	  '' as name,
		ptd.card_holder_name as card_holder_name, 
		ptd.transaction_amount as amount,
		ptd.transaction_initiation_date as Date,
		ptd.item_name,
		'paypal',
		ptd.transaction_event_code,
		'' as donation_frequency,
		'' as honoree_name,
		'' as home_full_address,
		'' as home_city,
		'' as home_state_province,
		'' as cellphone_number,
		'' as zip,
		ptd.email_address as email_address,
		ptd.transaction_status as status,
		'' as tax_receipt,
		'' as receipt_prefix,  '' as receipt_purpose,
		ptd.transaction_id as ref_id,
		'No' as process_status,
		'',
		'' as sehm, '' as marjaa, '' as is_syed,
		'' as pkg_title
	  from tb_all_payments_compiled apc
			  INNER JOIN tb_external_payments ep ON apc.external_payment_id = ep.id 
			  LEFT JOIN tb_paypal_transaction_data ptd ON ep.transaction_paypal_id = ptd.id
	  where apc.df_id is null and apc.um_id is null and apc.sc_id is null
	  and DATE( ptd.transaction_initiation_date ) >= SUBDATE(CURRENT_DATE, 180)
	  ORDER BY 
		Date desc";

		$view_data = $this->db->query($query);

		$final_data = [];

		if($view_data->num_rows()>0){
			$data_for_view    = $view_data->result_array();
			
			
			foreach($data_for_view as $data_per_view_row){

				/* echo '<pre>';
				print_r($data_per_view_row);
				echo '</pre>'; */ 

				if($data_per_view_row['amount'] < 0){
					continue;
				}

				$status       = $data_per_view_row['status'] == 'S' ? 'Paid' : $data_per_view_row['status'];
				$payment_mode = $data_per_view_row['payment_mode'] == 'T0007' ? 'onetime' : ($data_per_view_row['payment_mode'] == 'T0002' ? 'recurring' : $data_per_view_row['payment_mode']);

				// var_dump($name);
				$date_tempp = $data_per_view_row['Date'];  
				$date_temp  = new DateTime($date_tempp);
				/* echo '<pre>';
				// // var_dump($data_per_view_row['first_name'] . ' ' . $data_per_view_row['last_name']);
				print_r($data_per_view_row);
				// print_r($date_temp);
				// var_dump($date_temp->format('Y-m-d'));
				echo '</pre>';  */
				// var_dump($date_temp->format('Y-m-d'));
				$final_data[] = [
					"card_holder_name"   	=> $data_per_view_row['card_holder_name'],
					"full_name"          	=> $data_per_view_row['name'],
					"transaction_amount" 	=> round($data_per_view_row['amount'], 2),
					"date"               	=> $date_temp->format('Y-m-d'),
					"purpose" 			 	=> !empty($data_per_view_row['pkg_title']) ? $data_per_view_row['pkg_title'] : $data_per_view_row['dpdesc'],
					"payment_method"     	=> $data_per_view_row['payment_method'],
					"donation_mode"      	=> $payment_mode,
					"country_name"       	=> $data_per_view_row['country_name'],
					"email_address"      	=> $data_per_view_row['email_address'],
					"transaction_status" 	=> $status,
					"tax_receipt"        	=> $data_per_view_row['tax_receipt_num'],
					"reconciliation_status" => $data_per_view_row['process_status'],
					"receipt_id"            => $data_per_view_row['id'],
					"receipt_prefix"        => $data_per_view_row['receipt_prefix'],
					"receipt_purpose"       => $data_per_view_row['receipt_purpose'],
					"sehm"      			=> $data_per_view_row['sehm'],
					"syed"      			=> $data_per_view_row['syed'],
					"marjaa"       			=> $data_per_view_row['marjaa'],
					"ref_id"       			=> $data_per_view_row['ref_id'],
					"home_full_address"     => $data_per_view_row['home_full_address'],
					"home_city"       		=> $data_per_view_row['home_city'],
					"home_state_province"   => $data_per_view_row['home_state_province'],
					"cellphone_number"      => $data_per_view_row['cellphone_number'],
					"honoree_name"      	=> $data_per_view_row['honoree_name'],
					"payment_frequency"     => $data_per_view_row['donation_frequency'],
				];
				
			}/* die; */

			return $final_data;
		}

	}

	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "userid", "conferenceid", "gender", "name", "middle_name", "father_name", "surname", "passport_number", "passport_type", "date_of_birth|default_date", "place_of_birth", "country_of_birth", "nationality", "passport_image", "photo_image", "marital_status", "gender_father_name", "previous_nationality", "place_of_issue", "date_of_issue|default_date", "expiry_date|default_date", "occupation", "position", "name_of_institute_company", "title_of_activity", "visa_insurance_place", "duration_of_stay", "no_of_previous_travels", "date_of_entry_for_conference|default_date", "last_date_of_entry|default_date", "date_of_departure|default_date", "date_added", "registration_date|default_date", "is_paid", "parentid", "options", "unique_formid",
											
											"full_name", "email", "phone", "mailing_address", "speciality_interest", "age_level_of_school" );
		
		$filled_inputs				= array( "id", "userid", "conferenceid", "gender", "name", "middle_name", "father_name", "surname", "passport_number", "passport_type", "date_of_birth", "place_of_birth", "country_of_birth", "nationality", "passport_image", "photo_image", "marital_status", "gender_father_name", "previous_nationality", "place_of_issue", "date_of_issue", "expiry_date", "occupation", "position", "name_of_institute_company", "title_of_activity", "visa_insurance_place", "duration_of_stay", "no_of_previous_travels", "date_of_entry_for_conference", "last_date_of_entry", "date_of_departure", "date_added", "registration_date", "is_paid", "parentid", "options", "unique_formid",
											
											"full_name", "email", "phone", "mailing_address", "speciality_interest", "age_level_of_school" );
		
		//$filled_inputs				= array( "id", "resorts_id", "promo_code_percentage_discount_code", "promo_code_percentage_discount_percent", "promo_code_percentage_discount_datefrom", "promo_code_percentage_discount_expiry", "promo_code_value_add_code", "promo_code_value_add_details", "promo_code_value_add_datefrom", "promo_code_value_add_expiry",  "options" );
		
		
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				

				$explode_empty_inputs			= explode( "|", $empty_inputs[$x] );
				$empty_inputs[$x]				= $explode_empty_inputs[0];
				$tmp_value						= $db_data[ $filled_inputs[$x] ];
				
				if ( count($explode_empty_inputs) > 1 )
				{
					switch ( $explode_empty_inputs[1] )
					{
						case "default_date":	
							$tmp_value			= date("d-m-Y", strtotime( $db_data[ $filled_inputs[$x] ] ) );
							break;
							
						case "default":	
							break;
					}
				}
				
				$data[ $empty_inputs[$x] ]		= $tmp_value;
				
				
				
				
			}
			
			
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				$explode_empty_inputs				= explode( "|", $empty_inputs[$x] );
				$empty_inputs[$x]					= $explode_empty_inputs[0];
				$tmp_value							= "";
				
				
				if ( count($explode_empty_inputs) > 1 )
				{
					switch ( $explode_empty_inputs[1] )
					{
						case "default_date":	
							$tmp_value				= "00-00-0000";
							break;
							
						case "default":	
							break;
					}
				}
				
				$data[ $empty_inputs[$x] ]		= $tmp_value;
			}
			
			return $data;
		
		}
	}
	
	public function _create_array_fields_for_form( $return_array = false, &$data, $loop_object = array(), $db_data = array() )
	{
	
		$empty_inputs				= array( "bh_name", "bh_descr", "bh_announce" );
		$filled_inputs				= array( "bh_name", "bh_descr", "bh_announce" );
		$languages					= $data["languages"];

		
		
		if ($return_array == true and count($db_data) > 0 )
		{
			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				foreach ($loop_object as $loop)
				{
					$detail_array[ $loop["id"] ] [ $empty_inputs[$x]]		= "";
				}
			}
			
			
			#loop with the parent object... for e.g. Types of Promo Codes
			foreach ($loop_object as $main)
			{
				
				$language_id				= $main["id"];
				
				for ($x=0;  $x < count($empty_inputs); $x++)
				{
					#second - if value found it will overwrite above array.
					foreach ( $db_data as $loop )
					{
						if ( $loop["languageid"] == $language_id )
						{
							$detail_array[ $main["id"] ] [ $empty_inputs[$x] ]			= $loop[ $filled_inputs[$x] ];	
						}
						
					}
				}
			}			
			
			ksort( $detail_array );
		
			$data["_detail_array"]	= $detail_array;
			
			
			return $data;
		}
		else
		{
			
			

			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				foreach ($loop_object as $loop)
				{
					$detail_array[ $loop["id"] ] [ $empty_inputs[$x]]		= "";
				}
			}
			
			$data["_detail_array"]	= $detail_array;
			
			return $data;
		
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */