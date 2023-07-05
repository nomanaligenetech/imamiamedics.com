<?php

class customException extends Exception {
    private $_options;

    public function __construct($options = array('params')) {
        parent::__construct();

        $this->_options = $options; 
    }

    public function GetOptions() { return $this->_options; }
}

/*require APPPATH . 'third-party/payeezy/Util.php';
require APPPATH . 'third-party/payeezy/Error.php';
require APPPATH . 'third-party/payeezy/Transaction.php';
require APPPATH . 'third-party/payeezy/TransactionType.php';
require APPPATH . 'third-party/payeezy/TeleCheck.php';
require APPPATH . 'third-party/payeezy/threeDS.php';
require APPPATH . 'third-party/payeezy/Token.php';
require APPPATH . 'third-party/payeezy/ValueLink.php';
require APPPATH . 'third-party/payeezy/Paypal.php';
require APPPATH . 'third-party/payeezy/CreditCard.php';
require APPPATH . 'third-party/payeezy/Client.php';*/

class Payeezy{
    
    /*private $api_key;
    private $api_secret;
    private $api_token;
    private $api_url;*/
    
    public function __construct()
    {
        $ci = &get_instance();
        /*$this->api_key = $ci->config->item('payeezy_api');
        $this->api_secret = $ci->config->item('payeezy_secret');
        $this->api_token = $ci->config->item('payeezy_token');
        $this->api_url = $ci->config->item('payeezy_url');
        $this->ta_token = $ci->config->item('ta_token');*/

        $ci->load->library('ccdetector');
        $ci->load->library('payeezycredentials');
        $this->hmac = $ci->payeezycredentials->getCredentials('hmac');
        $this->exact = $ci->payeezycredentials->getCredentials('exact');
        //$pms['api_url'] = $cms['payeezy_apiurl'];
        //$pms['hmackey'] = $cms['payeezy_hmackey'];
        //$pms['hmacid'] = $cms['payeezy_hmackeyid'];
        //$pms['options'] = array('trace' => 1);
        //$ci->load->library('soapclienthmac', $pms);
    }

    public function pay($card_details,$amount,$email,$recurring=false, $rand_uuid="", $table_name = 'tb_donation_form')
    {
        $ci = &get_instance();
        $currency = 'USD';
        $merchant = 'Imamia Medics International';

        $check_uuid = $ci->db->query("SELECT * FROM {$table_name} WHERE payeezy_uuid = '" . $rand_uuid . "' ");

        if( !($check_uuid->num_rows() > 0) ){
        if ( $amount != "" && isset($card_details['name']) && isset($card_details['number']) && isset($card_details['expiry']) && isset($card_details['cvv']) ){
            
            //$config = $ci->payeezycredentials->getCredentials('exact');

            $trxnProperties = array(
                "ExactID"=> $this->exact['payeezy_exactid'],
                "Password"=> $this->exact['payeezy_password'],
                "Transaction_Type"=>"00",
                "Language"=>"en",
                "Expiry_Date"=>str_replace('/', '', $card_details['expiry']),
                "CardHoldersName"=>$card_details['name'],
                "DollarAmount"=>$amount,
                "Client_Email"=>$email,
                "Extra" => array(
                    "Field" => "uuid",
                    "Value" => $rand_uuid
                ),
            );

            if($recurring){               
                    //$tokencred = $ci->payeezycredentials->getCredentials('token');
                    try 
                    {
                        //$tokendata = $this->getToken($card_details, $tokencred);
                        $tokendata = $this->getSoapToken($card_details, $this->exact, $this->hmac);
                        //var_dump($tokendata);die;
                        $token = $tokendata['response'];
                        $trxnProperties['TransarmorToken'] = $token->TransarmorToken;
                        $trxnProperties['CardType'] = $token->CardType;
                        if($token->CardType == "American Express"){
                            $trxnProperties['Ecommerce_Flag'] = "2";
                        } else {
                            $trxnProperties['StoredCredentials'] = array(
                                "Indicator"=>"1",
                                "Initiation"=>"M",
                                "Schedule"=>"S",
                                "TransactionId"=>"new",
                            );
                            if($token->CardType == "Mastercard"){
                                $trxnProperties['StoredCredentials']['Indicator'] = "S";
                            }
                        }                        
                    }
                    catch (CustomException $ex)
                    {
                        $options = $ex->GetOptions();
                        return array('error'=>$options['error'],'request'=>$options['request'],'response'=>$options['response']);
                    }
                    catch (Exception $e)
                    {
                        return array('error'=>$e->getMessage(),'request'=>$trxnProperties,'response'=>$token);
                    }
            } else {
                $trxnProperties["Card_Number"] = $card_details['number'];
            }

            try {
                /*$configHmac = $ci->payeezycredentials->getCredentials('hmac');
                $params['api_url'] = $config['payeezy_apiurl'];
                $params['hmackey'] = $configHmac['payeezy_hmackey'];
                $params['hmacid'] = $configHmac['payeezy_hmackeyid'];
                $params['options'] = array('trace' => 1);
                $ci->load->library('soapclienthmac', $params);*/
                $client = new SoapClientHMAC($this->hmac);
                $trxnResult = $client->SendAndCommit($trxnProperties);
            }
            catch (exception $e) {
                // var_dump($e, $e->getMessage(),$trxnResult);die('test');
                if(empty($trxnResult)){
                    $trxnResult = $e->getMessage() ? $e->getMessage() : "Something Went Wrong";
                }
                return array('error'=>$e->getMessage(),'request'=>$trxnProperties,'response'=>$trxnResult);
            }

            if(@$client->fault){
                // var_dump($client, $client->faultstring,$trxnResult);die('best');
                if(empty($trxnResult)){
                    $trxnResult = $client->faultstring ? $client->faultstring : "Something Went Wrong";
                }
                return array('error'=>$client->faultstring,'request'=>$trxnProperties,'response'=>$trxnResult);
            }
            
            unset($client);

            if($trxnResult->Transaction_Approved != true /*&& $trxnResult->Bank_Message == "Approved"*/){
                $error = 'Something Went Wrong! Please Try Again.';
                if($trxnResult->Transaction_Error == true){
                    $error = $trxnResult->EXact_Message;
                } elseif(isset($trxnResult->Bank_Message)){
                    $error = $trxnResult->Bank_Message;
                }
                return array('error'=>$error,'request'=>$trxnProperties,'response'=>$trxnResult);
            } else {
                return array('success'=>true,'request'=>$trxnProperties,'response'=>$trxnResult);
            }
            /*try {

                $amount = $amount * 100;

                $client = new Payeezy_Client();
                $client->setApiKey($this->api_key);
                $client->setApiSecret($this->api_secret);
                $client->setMerchantToken($this->api_token);
                $client->setUrl($this->api_url . "transactions/tokens");

                $card_transaction = new Payeezy_Transaction($client);

                $authorize_response = $card_transaction->doPrimaryTransaction([
                    //"merchant_ref" => $merchant,
                    //"amount" => $amount,
                    //"currency_code" => $currency,
                    "credit_card" => array(
                        "type" => $ci->ccdetector->detect($card_details['number']),
                        "cardholder_name" => $card_details['name'],
                        "card_number" => $card_details['number'],
                        "exp_date" => str_replace('/', '', $card_details['expiry']),
                        "cvv" => $card_details['cvv']
                    ),
                    'type' => 'FDToken',
                    "auth" => "false",
                    "ta_token" => $this->ta_token
                ]);

                if ( $authorize_response->status == "success") {
                    $client->setUrl($this->api_url . "transactions");
                    $_transaction = new Payeezy_Token($client);

                    $response = $_transaction->purchase(
                        array(
                            "merchant_ref" => $merchant,
                            "amount" => $amount,
                            "currency_code" => $currency,
                            "token" => array(
                                "token_type" => "FDToken",
                                "token_data" => array(
                                    "type"  => $ci->ccdetector->detect($card_details['number']),
                                    "value" => $authorize_response->token->value,
                                    "cardholder_name" => $card_details['name'],
                                    "exp_date" => str_replace('/', '', $card_details['expiry'])
                                )
                            )
                        )
                    );

                    if ($response->transaction_status == "approved" && $response->validation_status == "success") {
                        $response->amount = $response->amount / 100;
                        return $response;
                    }else{
                        throw new Exception($response->bank_message);
                    }
                }else{
                    throw new Exception($authorize_response->bank_message);
                }
            }
            catch(Exception $e){
                return array('error'=>$e->getMessage());
            }*/
        }
    }
        return false;
    }

    public function pay_recurring($card_details)
    {
        $ci = &get_instance();
        $currency = 'USD';
        $merchant = 'Imamia Medics International';

        if ( $card_details['amount'] != "" && $card_details['card_name'] != "" && $card_details['card_type'] != "" && $card_details['card_expiry'] != "" && $card_details['ta_token'] != "" ){
            
            //$config = $ci->payeezycredentials->getCredentials('exact');

            $trxnProperties = array(
                "ExactID"=> $this->exact['payeezy_exactid'],
                "Password"=> $this->exact['payeezy_password'],
                "Transaction_Type"=>"00",
                "Language"=>"en",
                "Expiry_Date"=>str_replace('/', '', $card_details['card_expiry']),
                "CardHoldersName"=>$card_details['card_name'],
                "DollarAmount"=>$card_details['amount'],
                "Client_Email"=>$card_details['email'],
                "TransarmorToken"=>$card_details['ta_token'],
                "CardType"=>$card_details['card_type'],
            );
            
            
            if($card_details['card_type'] == "American Express"){
                $trxnProperties['Ecommerce_Flag'] = "2";
            } else {
                if(empty(trim($card_details['transaction_id']))){
                    return false;
                }
                $trxnProperties['StoredCredentials'] = array(
                    "Indicator"=>"S",
                    "Initiation"=>"M",
                    "Schedule"=>"S",
                    "TransactionId"=>$card_details['transaction_id'],
                    "OriginalAmount"=>$card_details['amount'],
                );
            }

            try {
                /*$configHmac = $ci->payeezycredentials->getCredentials('hmac');
                $params['api_url'] = $config['payeezy_apiurl'];
                $params['hmackey'] = $configHmac['payeezy_hmackey'];
                $params['hmacid'] = $configHmac['payeezy_hmackeyid'];
                $params['options'] = array('trace' => 1);
                $ci->load->library('soapclienthmac', $params);*/
                $client = new SoapClientHMAC($this->hmac);
                $trxnResult = $client->SendAndCommit($trxnProperties);
            }
            catch (exception $e) {
                return array('error'=>$e->getMessage(),'request'=>$trxnProperties,'response'=>$trxnResult);
            }

            if(@$client->fault){
                return array('error'=>$client->faultstring,'request'=>$trxnProperties,'response'=>$trxnResult);
            }
            
            unset($client);

            if($trxnResult->Transaction_Approved != true /*&& $trxnResult->Bank_Message == "Approved"*/){
                $error = 'Something Went Wrong! Please Try Again.';
                if($trxnResult->Transaction_Error == true){
                    $error = $trxnResult->EXact_Message;
                } elseif(isset($trxnResult->Bank_Message)){
                    $error = $trxnResult->Bank_Message;
                }
                return array('error'=>$error,'request'=>$trxnProperties,'response'=>$trxnResult);
            } else {
                return array('success'=>true,'request'=>$trxnProperties,'response'=>$trxnResult);
            }
        }

        /*if ( $amount != "" && isset($card_details['name']) && isset($card_details['type']) && isset($card_details['expiry']) && isset($card_details['token']) ){

            try {

                $amount = $amount * 100;

                $client = new Payeezy_Client();
                $client->setApiKey($this->api_key);
                $client->setApiSecret($this->api_secret);
                $client->setMerchantToken($this->api_token);
                $client->setUrl($this->api_url . "transactions");

                $_transaction = new Payeezy_Token($client);

                $response = $_transaction->purchase(
                    array(
                        "merchant_ref" => $merchant,
                        "amount" => $amount,
                        "currency_code" => $currency,
                        "token" => array(
                            "token_type" => "FDToken",
                            "token_data" => array(
                                "type"  => $card_details['type'],
                                "value" => $card_details['token'],
                                "cardholder_name" => $card_details['name'],
                                "exp_date" => str_replace('/','',$card_details['expiry'])
                            )
                        )
                    )
                );

                if ($response->transaction_status == "approved" && $response->validation_status == "success") {
                    $response->amount = $response->amount / 100;
                    return $response;
                }else{
                    throw new Exception( $response->bank_message);
                }
            } catch (Exception $e) {
                return array('error' => $e->getMessage());
            }
        }*/
        return false;
    }

    private function getSoapToken($card_details, $api_cred, $hmaccred){
        $ci = &get_instance();
        $trxnProperties = array(
            "ExactID"=> $api_cred['payeezy_exactid'],
            "Password"=> $api_cred['payeezy_password'],
            "Transaction_Type"=>"01",
            "Card_Number"=>$card_details['number'],
            "Expiry_Date"=>str_replace('/', '', $card_details['expiry']),
            "CardHoldersName"=>$card_details['name'],
            "DollarAmount"=>'0',            
        );
        try {
            /*$configHmac = $ci->payeezycredentials->getCredentials('hmac');
            $params['api_url'] = $api_cred['payeezy_apiurl'];
            $params['hmackey'] = $configHmac['payeezy_hmackey'];
            $params['hmacid'] = $configHmac['payeezy_hmackeyid'];
            $params['options'] = array('trace' => 1);
            $ci->load->library('soapclienthmac', $params);*/
            $client = new SoapClientHMAC($hmaccred);
            $trxnResult = $client->SendAndCommit($trxnProperties);
        }
        catch (exception $e) {
            //return array('error'=>$e->getMessage(),'request'=>$trxnProperties,'response'=>$trxnResult);
            throw new customException(array("error"=>$e,"request"=>$trxnProperties,"response"=> $trxnResult));
        }

        if(@$client->fault){
            //return array('error'=>$client->faultstring,'request'=>$trxnProperties,'response'=>$trxnResult);
            throw new customException(array("error"=>$client->faultstring,"request"=>$trxnProperties,"response"=> $trxnResult));
        }
        
        unset($client);

        if($trxnResult->Transaction_Approved != true){
            $error = 'Something Went Wrong! Please Try Again.';
            if($trxnResult->Transaction_Error == true){
                $error = $trxnResult->EXact_Message;
            } elseif(isset($trxnResult->Bank_Message)){
                $error = $trxnResult->Bank_Message;
            }
            //return array('error'=>$error,'request'=>$trxnProperties,'response'=>$trxnResult);
            throw new customException(array("error"=>$error,"request"=>$trxnProperties,"response"=> $trxnResult));
        } else {
            return array('success'=>true,'response'=>$trxnResult);
        }
    }

    /*private function getToken($card_details, $api_cred){
        $ci = &get_instance();
        $apiKey = $api_cred['payeezy_apikey'];
        $apiSecret = $api_cred['payeezy_apisecret'];
        $token = $api_cred['payeezy_mertoken'];

        $nonce = strval(hexdec(bin2hex(openssl_random_pseudo_bytes(4, $cstrong))));
        $timestamp = strval(time()*1000); //time stamp in milli seconds
    
        $cardArray = array(
            "type"=> "FDToken",
            "credit_card"=> array(
                "type"=> $ci->ccdetector->detect($card_details['number']),
                "cardholder_name"=> $card_details['name'],
                "card_number"=> $card_details['number'],
                "exp_date"=> str_replace('/', '', $card_details['expiry'])
            ),
            "auth"=> "false",
            "ta_token"=> $api_cred['payeezy_transtoken']
        );
   
        $payload = json_encode($cardArray, JSON_FORCE_OBJECT);

        $data = $apiKey . $nonce . $timestamp . $token . $payload;

        $hashAlgorithm = "sha256";

        ### Make sure the HMAC hash is in hex -->
        $hmac = hash_hmac ( $hashAlgorithm , $data , $apiSecret, false );

        ### Authorization : base64 of hmac hash -->
        $hmac_enc = base64_encode($hmac);

        $curl = curl_init($api_cred['payeezy_token_url']);
        
        $headers = array(
            'Content-Type: application/json',
            'apikey:'.strval($apiKey),
            'token:'.strval($token),
            'Authorization:'.$hmac_enc,
            'nonce:'.$nonce,
            'timestamp:'.$timestamp,
        );

        //curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);

        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLINFO_HEADER_OUT , true);

        
        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $reqheader = curl_getinfo($curl, CURLINFO_HEADER_OUT);
        //$response = json_decode($json_response, true);

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($json_response, 0, $header_size);
        $body = substr($json_response, $header_size);

        curl_close($curl);

        //var_dump($reqheader, $payload, json_decode($body, true), $status);die;

        $body = json_decode($body, true);

        if ( $status != 201 ) {
            $error = $body['Error']['messages'][0]['description'];
            unset($cardArray['credit_card']['card_number']);
            $request = $reqheader . "__BODY__" . json_encode($cardArray);
            throw new customException(array("error"=>$error, "request"=>$request, "response"=> $json_response));
        }  else {
            return array("success"=>true, "response"=> $body['token']);
        }
    }*/
}

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
        if(empty($params['payeezy_apiurl']) || empty($params['payeezy_hmackey']) || empty($params['payeezy_hmackeyid'])){
            $payeezy_mode = SessionHelper::_get_session("PAYEEZY_MODE", "site_settings") ? SessionHelper::_get_session("PAYEEZY_MODE", "site_settings") : "1";
            $params['payeezy_hmackey'] = $payeezy_mode == '0' ? 'fVI0haYJB_8KAcaO64rAHbjE1XcsazB~' : 'bfViliDGgf4Vbym3B~vdfhTP86TbTY1B';
            $params['payeezy_hmackeyid'] = $payeezy_mode == '0' ? '684287' : '542912';
            $params['payeezy_apiurl'] = $payeezy_mode == '0' ? 'https://api.demo.globalgatewaye4.firstdata.com/transaction/v31/wsdl' : 'https://api.globalgatewaye4.firstdata.com/transaction/v31/wsdl';
        }
        global $context;
        $this->hmackey = $params['payeezy_hmackey'];
        $this->hmacid = $params['payeezy_hmackeyid'];
        $this->api_url = $params['payeezy_apiurl'];
        //$options = $params['options'];
        //$context = stream_context_create();
        //$options['stream_context'] = $context;
        //return parent::SoapClient($this->api_url, $options);


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
            return $e;
        }
    }
}