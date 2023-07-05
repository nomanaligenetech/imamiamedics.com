<?php
// A wrapper for PayPal IPN API

namespace apih\PayPal;

class IPN extends Base
{
	public function process($ipn_data)
	{
		$ipn_data['cmd'] = '_notify-validate';

		list($response, $http_code) = $this->curlPostRequest($ipn_data);

		if ($http_code === 200 && $response === 'VERIFIED') {
			return $this->convertToUtf8($ipn_data);
		}

		error_log('PayPal Error: IPN - ' . $http_code . ' - ' . $response);

		return false;
	}
}
?>