<?php

/**
 * @param $phone
 * @param $country_code
 *
 * @return bool
 */
function is_phone($phone, $country_code = '234')
{
    $mtn = ['803','806','813','816','811','814','703','706','903'];
    $etisalat = ['809','807','819','817','818','808','708','900','909'];
    $glo = ['805','815','705','905'];
    $others = ['802','812','810','701'];

    $prefixes = array_merge($mtn,$etisalat, $glo, $others);
    foreach($prefixes as $prefix)
    {
        if(
            preg_match("/^0(".$prefix.")([0-9]{7})$/", $phone)
            or
            preg_match("/^(".$country_code.$prefix.")([0-9]{7})$/", $phone)
            or
            preg_match("/^(\\+".$country_code.$prefix.")([0-9]{7})$/", $phone)
        ) return true;
    }
    return false;
}

function normalize_phone($phone, $country_code = '234')
{
    if(is_phone($phone, $country_code)){
        if(strlen($phone) == 11){
            return $country_code.substr($phone, 1);
        }
        if(strlen($phone) == 14){
            return substr($phone, 1);
        }
        return $phone;
    }
    throw new \Exception("Invalid phone number: {$phone}");
}
