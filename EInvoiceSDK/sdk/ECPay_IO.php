<?php

class ECPay_IO
{
    static function ServerPost($parameters, $ServiceURL)
    {

        $sSend_Info = '';

        // 組合字串
        foreach ($parameters as $key => $value) {
            if ($sSend_Info == '') {
                $sSend_Info .= $key . '=' . $value;
            } else {
                $sSend_Info .= '&' . $key . '=' . $value;
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
}