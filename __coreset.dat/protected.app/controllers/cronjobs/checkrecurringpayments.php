<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'controllers/paypal/payments_pro.php';

class Checkrecurringpayments extends Payments_pro {
	
	public function __construct()
	{
		// initials
		parent::__construct();
	}
	
	public function index()
	{
		
		$response = $this->Get_transaction_details( $transactionid = '9T200358EL962302E' );
			
			print_r($response); die();
		
		
		$payments = $this->db->query(" SELECT dp.* FROM `tb_donation_payments` dp INNER JOIN `tb_donation_form` df ON dp.table_id_value = df.id WHERE dp.payment_status = 'Completed' and df.donation_mode = 'recurring' ")->result_array();
		
		foreach($payments as $payment) {
			
			$transactionid = $payment['payer_id'];
			$response = $this->Get_transaction_details( $transactionid = '3GA263735A2311136' );
			
			print_r($response);
			echo "<br>===========================<br>";
			
			/*if ($response["ACK"] != 'Failure')
			{
				print_r($response);
				echo "<br>===========================<br>";
			}*/
		
		}
		
	}
	
}