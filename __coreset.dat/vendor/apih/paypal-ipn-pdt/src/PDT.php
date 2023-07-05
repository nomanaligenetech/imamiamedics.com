<?php
// A wrapper for PayPal PDT API

namespace apih\PayPal;

class PDT extends Base
{
	public function process($tx, $at)
	{
		$query_data = [
			'cmd' => '_notify-synch',
			'tx' => $tx,
			'at' => $at
		];

		list($response, $http_code) = $this->curlPostRequest($query_data);

		if ($http_code === 200 && strpos($response, 'SUCCESS') === 0) {
			$response = trim(substr($response, 7));
			$response = str_replace("\r\n", "\n", $response);
			$response = explode("\n", $response);

			$pdt_data = [];

			foreach ($response as $line) {
				if ($line === '') continue;

				$temp = explode('=', $line, 2);

				$pdt_data[urldecode($temp[0])] = urldecode($temp[1]);
			}

			return $this->convertToUtf8($pdt_data);
		}

		error_log('PayPal Error: PDT - ' . $http_code . ' - ' . $response);

		return false;
	}
}
?>