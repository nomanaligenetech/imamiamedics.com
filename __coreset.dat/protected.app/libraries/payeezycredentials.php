<?php

class PayeezyCredentials{
    
    private $payeezy_mode;
    
    public function __construct(){
        $this->payeezy_mode = SessionHelper::_get_session("PAYEEZY_MODE", "site_settings");
    }

    public function getCredentials($type){
        $config = false;
        if($type=='exact'){
            $config = $this->getExactData();
        } elseif($type=='hmac'){
            $config = $this->getHmacData();
        } /*elseif($type=='token'){
            $config = $this->getTokenData();
        }*/
        return $config;        
    }

    private function getExactData(){
        $config['payeezy_exactid'] = $this->payeezy_mode == '0' ? SessionHelper::_get_session("PAYEEZY_EXACTID_SANDBOX", "site_settings") : SessionHelper::_get_session("PAYEEZY_EXACTID_LIVE", "site_settings");
        $config['payeezy_password'] = $this->payeezy_mode == '0' ? SessionHelper::_get_session("PAYEEZY_PASSWORD_SANDBOX", "site_settings") : SessionHelper::_get_session("PAYEEZY_PASSWORD_LIVE", "site_settings");
        //$config['payeezy_apiurl'] = $this->getPayeezyApiUrl();
        return $config;
    }

    private function getHmacData(){
        $config['payeezy_hmackey'] = $this->payeezy_mode == '0' ? SessionHelper::_get_session("PAYEEZY_HMACKEY_SANDBOX", "site_settings") : SessionHelper::_get_session("PAYEEZY_HMACKEY_LIVE", "site_settings");
        $config['payeezy_hmackeyid'] = $this->payeezy_mode == '0' ? SessionHelper::_get_session("PAYEEZY_HMACID_SANDBOX", "site_settings") : SessionHelper::_get_session("PAYEEZY_HMACID_LIVE", "site_settings");
        $config['payeezy_apiurl'] = $this->getPayeezyApiUrl();
        return $config;
    }

    /*private function getTokenData(){
        $config['payeezy_token_url'] = SessionHelper::_get_session("PAYEEZY_TOKEN_URL", "site_settings");
        $config['payeezy_apikey'] = $this->payeezy_mode == '0' ? SessionHelper::_get_session("PAYEEZY_APIKEY_SANDBOX", "site_settings") : SessionHelper::_get_session("PAYEEZY_APIKEY_LIVE", "site_settings");
        $config['payeezy_apisecret'] = $this->payeezy_mode == '0' ? SessionHelper::_get_session("PAYEEZY_APISECRET_SANDBOX", "site_settings") : SessionHelper::_get_session("PAYEEZY_APISECRET_LIVE", "site_settings");
        $config['payeezy_mertoken'] = $this->payeezy_mode == '0' ? SessionHelper::_get_session("PAYEEZY_MERTOKEN_SANDBOX", "site_settings") : SessionHelper::_get_session("PAYEEZY_MERTOKEN_LIVE", "site_settings");
        $config['payeezy_transtoken'] = $this->payeezy_mode == '0' ? SessionHelper::_get_session("PAYEEZY_TRANSTOKEN_SANDBOX", "site_settings") : SessionHelper::_get_session("PAYEEZY_TRANSTOKEN_LIVE", "site_settings");
        return $config;
    }
    */
    private function getPayeezyApiUrl(){
        return $this->payeezy_mode == '0' ? SessionHelper::_get_session("PAYEEZY_URL_SANDBOX", "site_settings") : SessionHelper::_get_session("PAYEEZY_URL_LIVE", "site_settings");
    }
}