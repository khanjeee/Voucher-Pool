<?php

namespace App\Helper;
 
use App\Constants\Constants;
use Disrupt\Common\Helper as DisruptHelper;

class Helper
{
    public static function redisGetUserInfo($sModule, $sUsername, $sKey='',RedisHelper $oRedis)
    {
        return json_decode($oRedis->get(self::redisGenerateKey($sModule,$sUsername,$sKey)));
    }

    public static function redisSetUserInfo($sModule, $sUsername, $sKey='', $sValue,RedisHelper $oRedis)
    {
        return $oRedis->set(self::redisGenerateKey($sModule,$sUsername,$sKey),json_encode($sValue));
    }

    public static function redisGenerateKey($sModule, $sUsername, $sKey)
    {
        if($sModule == Constants::REDIS_VALIDATE_USER_PREFERENCES)
        {
            $sKey = $sModule.'_'.$sUsername.'_'.md5($sModule.$sUsername.json_encode($sKey));
        }
        elseif ($sModule == Constants::REDIS_VALIDATE_USER_ABUSE)
        {
            $sKey = $sModule.'_'.$sUsername;
        }

        //Helper::log_php($sKey.'---');
        return $sKey;
    }

    public static function generateTokenSpeedTest($iResellerId, $iCountryId, $iCityId, $iProtocolNo, $iProtocolNo2, $iProtocolNo3, $isFree,$iMultiPort, $sUserName,$iPurposeId,/* $fLattitude, $fLongitude,*/ $sIp,$sDeviceType, $sDataCenters)
    {

        if(gettype($sDataCenters) == 'array')

            $sDataCenters = self::convertArrayToString($sDataCenters);

        return md5($iResellerId.$iCountryId.$iCityId.$iProtocolNo.$iProtocolNo2.$iProtocolNo3.$isFree.$iMultiPort.$sUserName.$iPurposeId./*$fLattitude.$fLongitude.*/$sIp.$sDeviceType.$sDataCenters.time().Constants::TOKEN_SALT);
    }

    //returns true if the json is valid
    public static function isJson($string)
    {
        if(gettype($string) == 'array')
            $string = self::convertArrayToString($string);

        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function convertArrayToString($array)
    {
        return "\"[" .implode(',',$array). "]\"";
    }

    public static function convertStringToArray($string)
    {
        return str_replace('"','',$string);
    }

    public static function getCommaSeperateProtocolsByDeviceType($sDeviceType)
    {

        switch ($sDeviceType)
        {
            case Constants::DEVICE_ANDROID:
                $sProtocols = Constants::ARRAY_PROTOCOLS_ANDROID;
                break;
            case Constants::DEVICE_IOS:
                $sProtocols = Constants::ARRAY_PROTOCOLS_IOS;
                break;
            case Constants::DEVICE_WINDOWS:
                $sProtocols = Constants::ARRAY_PROTOCOLS_WINDOWS;
                break;
            case Constants::DEVICE_MAC:
                $sProtocols = Constants::ARRAY_PROTOCOLS_MAC;
                break;
            default:
                $sProtocols = '';

        }

        return (!empty($sProtocols)) ? "'". implode("','",$sProtocols) ."'" : '' ;
    }

    public static function commaSeperatedProtocols($iProtocolNo,$iProtocolNo2,$iProtocolNo3)
    {
        $aProtocols  = [];

        if(!empty($iProtocolNo) && !in_array($iProtocolNo,$aProtocols))
            $aProtocols[] = $iProtocolNo;

        if(!empty($iProtocolNo2) && !in_array($iProtocolNo2,$aProtocols))
            $aProtocols[] = $iProtocolNo2;

        if(!empty($iProtocolNo3) && !in_array($iProtocolNo3,$aProtocols))
            $aProtocols[] = $iProtocolNo3;

        return implode(',',$aProtocols);
    }

    public static function dump($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public static function vardump($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>'; die;;
    }

    public static function dumpAndDie($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }

    public static function log_php($string)
    {
        file_put_contents('php://stderr', $string);
    }

    /**
     * postExceptionsToSlack
     * @param string $sMessage message to send
     * @param string $sFileName File in which exception occured
     * @return null
     */
    public static function postExceptionsToSlack($sMessage,$sFileName)
    {
        $Message =  "\n  File Name: ".$sFileName."\n  Error: ".$sMessage;
        
        DisruptHelper::sendMessagetoSlack(Constants::SLACK_WEBHOOK_URL,$Message);
    }

    /**
     * @param $sIp
     * @Desc  Validates the Ip address
     * @return Boolean
     */
    public static function validateIp($sIp)
    {
        return (!empty($sIp) && $sIp != '127.0.0.1' && filter_var($sIp, FILTER_VALIDATE_IP));
    }
}
