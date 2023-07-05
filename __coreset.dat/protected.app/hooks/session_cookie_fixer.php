<?php
class SessionCookieFixer
{   
     //See (modified from) http://ha17.com/1745-bigip-f5-header-max-size-collides-with-codeigniters-bizarre-session-class/
    function removeDuplicateSessionCookieHeaders ()
    {
         $CI = &get_instance();

        // clean up all the cookies that are set...
        $headers             = headers_list();
        $cookies_to_output   = array ();
        $header_session_cookie = '';
        $session_cookie_name = $CI->config->item('sess_cookie_name');

        foreach ($headers as $header)
        {
            list ($header_type, $data) = explode (':', $header, 2);
            $header_type = trim ($header_type);
            $data        = trim ($data);

            if (strtolower ($header_type) == 'set-cookie')
            {
                header_remove ('Set-Cookie'); 

                $cookie_value = current(explode (';', $data));
                list ($key, $val) = explode ('=', $cookie_value);
                $key = trim ($key);

                if ($key == $session_cookie_name)
                {
                   // OVERWRITE IT (yes! do it!)
                   $header_session_cookie = $data;
                   continue;
                } 
                    else 
                    {
                   // Not a session related cookie, add it as normal. Might be a CSRF or some other cookie we are setting
                   $cookies_to_output[] = array ('header_type' => $header_type, 'data' => $data);
                }
            }
        }

        if ( ! empty ($header_session_cookie))
        {
            $cookies_to_output[] = array ('header_type' => 'Set-Cookie', 'data' => $header_session_cookie);
        }

        foreach ($cookies_to_output as $cookie)
        {
            header ("{$cookie['header_type']}: {$cookie['data']}", false);
        }
     }
}
?>