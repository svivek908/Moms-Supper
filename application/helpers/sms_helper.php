<?php 

/**
 * send sms
 * @param string $apikey
 * @param string $name
 */
if ( ! function_exists('send_sms')) {  
    function send_sms($mobile,$messge) {
        $CI =& get_instance();
        //$db = new DbHandler();
        $ch = curl_init();
        $responce = false;
        $username = SMS_USERNAME;
        $password = SMS_PASSWORD;
        $senderid = SMS_SENDER_ID;
        $route = SMS_ROUTE;
        $messge = urlencode($messge);
        $url = "http://sms.ironics.in/api/mt/SendSMS?user=".$username."&password=".$password."&senderid=" .$senderid."&channel=Trans&DCS=0&flashsms=0&route=".$route."&number=91".$mobile."&text=".$messge."";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,
            true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        //curl_setopt($ch,CURLOPT_DNS_USE_GLOBAL_CACHE, FALSE); //----uncomment on live 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE); //----comment on live 
        curl_setopt($ch,CURLOPT_DNS_CACHE_TIMEOUT, 2);

        $output = curl_exec($ch);
        if (curl_errno($ch)) {
             echo 'error:' . curl_error($ch);

            $responce = false;
        } else {
            $responce = true;
        }
        curl_close($ch);
        return $responce;
    }
}

?>