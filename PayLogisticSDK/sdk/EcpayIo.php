<?php

class EcpayIo
{
    /**
     * Server Post
     *
     * @param     array    $Params        Post 參數
     * @param     string   $ServiceURL    Post URL
     * @return    void
     */
    public static function ServerPost($Params ,$ServiceURL)
    {
        $SendInfo = '' ;

        // 組合字串
        foreach ($Params as $Key => $Value) {
            if ( $SendInfo == '') {
                $SendInfo .= $Key . '=' . $Value ;
            } else {
                $SendInfo .= '&' . $Key . '=' . $Value ;
            }
        }

        $Ch = curl_init();

        if (false === $Ch) {
            throw new Exception('curl failed to initialize');
        }

        curl_setopt($Ch, CURLOPT_URL, $ServiceURL);
        curl_setopt($Ch, CURLOPT_HEADER, false);
        curl_setopt($Ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($Ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($Ch, CURLOPT_POST, true);
        curl_setopt($Ch, CURLOPT_POSTFIELDS, $SendInfo);
        $Result = curl_exec($Ch);

        if (false === $Result) {
            throw new Exception(curl_error($Ch), curl_errno($Ch));
        }

        curl_close($Ch);

        return $Result;
    }
}
