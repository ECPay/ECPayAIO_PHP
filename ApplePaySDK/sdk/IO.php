<?php

namespace ECPay\ApplePay;

use Exception;

abstract class IO
{
    protected static function ServerPost($parameters ,$ServiceURL){

        $sSend_Info = '' ;

        // 組合字串
        foreach($parameters as $key => $value)
        {
            if( $sSend_Info == '')
            {
                $sSend_Info .= $key . '=' . $value ;
            }
            else
            {
                $sSend_Info .= '&' . $key . '=' . $value ;
            }
        }

        $ch = curl_init();

        if (FALSE === $ch) {
            throw new Exception('curl failed to initialize');
        }

        curl_setopt($ch, CURLOPT_URL, $ServiceURL);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sSend_Info);
        $rs = curl_exec($ch);

        if (FALSE === $rs) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }

        curl_close($ch);

        return $rs;
    }

    protected static function VerifyVendor($parameters, $ServiceURL, $debug_mode = false){

        $Return_Msg = '';

        $sMerchantIdentifier =  openssl_x509_parse( file_get_contents( $parameters['crt_path'] ))['subject']['UID'] ;

        // create a new cURL resource
        $ch = curl_init();

        $data = '{"merchantIdentifier":"'.$sMerchantIdentifier.'", "domainName":"'.$_SERVER['SERVER_NAME'].'", "displayName":"'.$parameters['displayName'].'"}';

        curl_setopt($ch, CURLOPT_URL, $ServiceURL);
        curl_setopt($ch, CURLOPT_SSLCERT, $parameters['crt_path']);
        curl_setopt($ch, CURLOPT_SSLKEY, $parameters['key_path']);
        curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $parameters['key_password']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if($debug_mode)
        {
            //debug options
            //curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
        }

        $result = curl_exec($ch);

        if($debug_mode)
        {
            if( $result === false)
            {
                $Return_Msg .= curl_errno($ch) . ' - ' . curl_error($ch);
            }
            else
            {
                $Return_Msg .= 'applePay server response ' . $result ;
            }

            rewind($verbose);
            $verboseLog = stream_get_contents($verbose);

            $Return_Msg .= htmlspecialchars($verboseLog);
        }
        else
        {
            $Return_Msg = $result ;
        }

        curl_close($ch);
        return $Return_Msg;
    }
}
