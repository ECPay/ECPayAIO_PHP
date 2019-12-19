<?php

class ECPay_Verify_Vendor extends ECPay_ApplePay_IO
{
    public function verify_vendor($arParameters = [], $ServiceURL='', $debug_mode = false){

        $arErrors = [];

        if( parse_url($ServiceURL, PHP_URL_SCHEME ) != 'https' )
        {
            array_push($arErrors, 'ServiceURL verify fail.');
        }

        if( substr( parse_url($ServiceURL, PHP_URL_HOST), -10 )  != '.apple.com')
        {
            array_push($arErrors, 'ServiceURL verify fail.');
        }

        if(!is_file($arParameters['crt_path']))
        {
            array_push($arErrors, 'crt path verify fail.');
        }

        if(!is_file($arParameters['key_path']))
        {
            array_push($arErrors, 'key path verify fail.');
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        $Return_Info = parent::VerifyVendor($arParameters, $ServiceURL, $debug_mode);
        return $Return_Info ;


    }
}
