<?php
// Base class

namespace apih\PayPal;

class Base
{
	const SANDBOX_URL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	const LIVE_URL = 'https://www.paypal.com/cgi-bin/webscr';

	protected $url;
	protected $user_agent = 'PayPal';
	protected $use_ssl = true;

	public function __construct()
	{
		$this->url = self::LIVE_URL;
	}

	public function useSandbox($flag = true)
	{
		$this->url = $flag ? self::SANDBOX_URL : self::LIVE_URL;
	}

	public function useSsl($flag = true)
	{
		$this->use_ssl = $flag;
	}

	public function setUserAgent($user_agent)
	{
		$this->user_agent = $user_agent;
	}

	protected function curlPostRequest($query_data)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent); 
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if ($this->use_ssl === false) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		}

		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query_data));
		curl_setopt($ch, CURLOPT_URL, $this->url);

		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		return [$response, $http_code];
	}

	protected function convertToUtf8($data)
	{
		if (isset($data['charset']) && strtolower($data['charset']) !== 'utf-8') {
			$original_charset = $data['charset'];

			foreach ($data as $key => &$value) {
				$value = mb_convert_encoding($value, 'utf-8', $original_charset);
			}

			unset($value);

			$data['charset_original'] = $original_charset;
			$data['charset'] = 'utf-8';
		}

		return $data;
	}
}
?>