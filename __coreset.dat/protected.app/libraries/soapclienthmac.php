<?php

class SoapClientHMAC extends SoapClient {

    private $hmackey;
    private $hmacid;
    private $api_url;

    public function __doRequest($request, $location, $action, $version, $one_way = NULL) {
        global $context;
        $hmackey = $this->hmackey;
        $keyid = $this->hmacid;
        $hashtime = date("c");
        $hashstr = "POST\ntext/xml; charset=utf-8\n" . sha1($request) . "\n" . $hashtime . "\n" . parse_url($location,PHP_URL_PATH);
        $authstr = base64_encode(hash_hmac("sha1",$hashstr,$hmackey,TRUE));
        if (version_compare(PHP_VERSION, '5.3.11') == -1) {
            ini_set("user_agent", "PHP-SOAP/" . PHP_VERSION . "\r\nAuthorization: GGE4_API " . $keyid . ":" . $authstr . "\r\nx-gge4-date: " . $hashtime . "\r\nx-gge4-content-sha1: " . sha1($request));
        } else {
            $abcd = array("header" => "authorization: GGE4_API " . $keyid . ":" . $authstr . "\r\nx-gge4-date: " . $hashtime . "\r\nx-gge4-content-sha1: " . sha1($request));
            stream_context_set_option($context,array("http" => $abcd ));
        }
        return parent::__doRequest($request, $location, $action, $version, $one_way);
    }
        
    //public function SoapClientHMAC($wsdl, $options = NULL) {
    public function SoapClientHMAC($params) {
        global $context;
        $this->hmackey = $params['hmackey'];
        $this->hmacid = $params['hmacid'];
        $this->api_url = $params['api_url'];
        /*$options = $params['options'];
        $context = stream_context_create();
        $options['stream_context'] = $context;
        return parent::SoapClient($this->api_url, $options);*/

        try {
            $opts = array(
                'http' => array(
                    'user_agent' => 'PHPSoapClient'
                )
            );
            $context = stream_context_create($opts);
        
            $soapClientOptions = array(
                'trace' => 1,
                'stream_context' => $context,
                'cache_wsdl' => WSDL_CACHE_NONE
            );
        
            return parent::SoapClient($this->api_url, $soapClientOptions);
        
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}