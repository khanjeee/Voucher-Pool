<?php

namespace App\DataTypes;

use Disrupt\Common\DataTypes\DTInteger;
use Disrupt\Common\DataTypes\DTString;
use Disrupt\Common\Helper as DisruptHelper;
use App\Models\SpeedTest;

class DTSpeedTest
{

    const COL_ID          = 'id';
    const COL_USER_ID     = 'user_id';
    const COL_RESELLER_ID = 'reseller_id';
    const COL_COUNTRY_ID  = 'country_id';
    const COL_CITY_ID     = 'city_id';
    const COL_PROTOCOL_NO = 'protocol_no';
    const COL_PROTOCOL_NO_2 = 'protocol_no_2';
    const COL_PROTOCOL_NO_3 = 'protocol_no_3';
    const COL_IS_FREE           = 'is_free';
    const COL_PURPOSE_ID = 'purpose_id';
    const COL_IP          = 'ip_address';
    const COL_LATT        = 'lattitude';
    const COL_LONG        = 'longitude';
    const COL_TYPE        = 'device_type';
    const COL_DATACENTERS = 'datacenters';
    const COL_MULTIPORT   = 'multiport';
    const COL_EXTRAS   = 'extras';
    const COL_VERSION   = 'version';
    const COL_TOKEN       = 'token';

    const TBL_NAME  = 'speedtest_';
    const NAME      = 'speedtest';


    private $_oSpeedTestId;
    private $_oUserId;
    private $_oResellerId;
    private $_oCountryId;
    private $_oCityId;
    private $_oProtocolNo;
    private $_oProtocolNo2;
    private $_oProtocolNo3;
    private $_oIsFree;
    private $_oPurposeId;
    private $_oIp;
    private $_oLattitude;
    private $_oLongitude;
    private $_oDeviceType;
    private $_oDataCenters;
    private $_oMultiport;
    private $_oToken;
    private $_oExtra;
    private $_oVersion;

    /**
     * DTSpeedTest constructor.
     */

    public function __construct($aData)
    {
        $this->setBasicInfo($aData);
    }

    protected function setBasicInfo($aData)
    {
        $this->setSpeedTestId(DisruptHelper::getKey($aData,self::COL_ID,self::TBL_NAME));
        $this->setUserId(DisruptHelper::getKey($aData,self::COL_USER_ID,self::TBL_NAME));
        $this->setResellerId(DisruptHelper::getKey($aData,self::COL_RESELLER_ID,self::TBL_NAME) );
        $this->setCountryId(DisruptHelper::getKey($aData,self::COL_COUNTRY_ID,self::TBL_NAME) );
        $this->setCityId(DisruptHelper::getKey($aData,self::COL_CITY_ID,self::TBL_NAME) );
        $this->setProtocolNumber(DisruptHelper::getKey($aData,self::COL_PROTOCOL_NO,self::TBL_NAME) );
        $this->setProtocolNumber2(DisruptHelper::getKey($aData,self::COL_PROTOCOL_NO_2,self::TBL_NAME) );
        $this->setProtocolNumber3(DisruptHelper::getKey($aData,self::COL_PROTOCOL_NO_3,self::TBL_NAME) );
        $this->setIsFree(DisruptHelper::getKey($aData,self::COL_IS_FREE,self::TBL_NAME) );
        $this->setPurposeId(DisruptHelper::getKey($aData,self::COL_PURPOSE_ID,self::TBL_NAME) );
        $this->setIp(DisruptHelper::getKey($aData,self::COL_IP,self::TBL_NAME) );
        $this->setLattitude(DisruptHelper::getKey($aData,self::COL_LATT,self::TBL_NAME) );
        $this->setLongitude(DisruptHelper::getKey($aData,self::COL_LONG,self::TBL_NAME) );
        $this->setDeviceType(DisruptHelper::getKey($aData,self::COL_TYPE,self::TBL_NAME) );
        $this->setDataCenters(DisruptHelper::getKey($aData,self::COL_DATACENTERS,self::TBL_NAME) );
        $this->setMultiPort(DisruptHelper::getKey($aData,self::COL_MULTIPORT,self::TBL_NAME) );
        $this->setExtras(DisruptHelper::getKey($aData,self::COL_EXTRAS,self::TBL_NAME) );
        $this->setVersion(DisruptHelper::getKey($aData,self::COL_VERSION,self::TBL_NAME) );
        $this->setToken(DisruptHelper::getKey($aData,self::COL_TOKEN,self::TBL_NAME) );
    }

    /**
     * @return mixed
     */
    public function getSpeedTestId()
    {
        return $this->_oSpeedTestId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->_oUserId;
    }

    /**
     * @return mixed
     */
    public function getResellerId()
    {
        return $this->_oResellerId;
    }

    /**
     * @return mixed
     */
    public function getCountryId()
    {
        return $this->_oCountryId;
    }

    public function getCountryIso()
    {
        $oModelSpeedTest = new SpeedTest();
        $aCountry = $oModelSpeedTest->getCountryIso($this->getCountryId()->value());
        return $aCountry['iso2'];
    }

    /**
     * @return mixed
     */
    public function getCityId()
    {
        return $this->_oCityId;
    }

    /**
     * @return mixed
     */
    public function getProtocolNumber()
    {
        return $this->_oProtocolNo;
    }
    
    public function getProtocolNumber2()
    {
        return $this->_oProtocolNo2;
    }

    public function getProtocolNumber3()
    {
        return $this->_oProtocolNo3;
    }

    public function getPurposeId()
    {
        return $this->_oPurposeId;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->_oIp;
    }

    /**
     * @return mixed
     */
    public function getLattitude()
    {
        return $this->_oLattitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->_oLongitude;
    }

    /**
     * @return mixed
     */
    public function getDeviceType()
    {
        return $this->_oDeviceType;
    }

    public function getDataCenters()
    {
        return $this->_oDataCenters;
    }

    public function getMultiPort()
    {
        return $this->_oMultiport;
    }

    public function getIsFree()
    {
        return $this->_oIsFree;
    }
    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->_oToken;
    }

    public function getExtras()
    {
        return $this->_oExtra;
    }

    public function getVersion()
    {
        return $this->_oVersion;
    }
    public function getExtrasDecoded()
    {
        return json_decode($this->_oExtra,true);
    }

/*************setters********/


    /**
     * @param mixed $speedTestId
     */
    public function setSpeedTestId($speedTestId)
    {
        $this->_oSpeedTestId = new DTInteger($speedTestId);
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->_oUserId = new DTInteger($userId);
    }

    /**
     * @param mixed $resellerId
     */
    public function setResellerId($resellerId)
    {
        $this->_oResellerId = new DTInteger($resellerId);
    }

    /**
     * @param mixed $countryId
     */
    public function setCountryId($countryId)
    {
        $this->_oCountryId = new DTInteger($countryId);
    }
 
    /**
     * @param mixed $cityId
     */
    public function setCityId($cityId)
    {
        $this->_oCityId = new DTInteger($cityId);
    }

    /**
     * @param mixed $protocolId
     */
    public function setProtocolNumber($protocolNo)
    {
        $this->_oProtocolNo = new DTInteger($protocolNo);
    }

    public function setProtocolNumber2($protocolNo)
    {
        $this->_oProtocolNo2 = new DTInteger($protocolNo);
    }

    public function setProtocolNumber3($protocolNo)
    {
        $this->_oProtocolNo3 = new DTInteger($protocolNo);
    }

    public function setIsFree($value)
    {
        $this->_oIsFree = new DTInteger($value);
    }

    public function setPurposeId($iPurposeId)
    {
        $this->_oPurposeId = new DTInteger($iPurposeId);
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->_oIp = new DTString($ip);
    }

    /**
     * @param mixed $lattitude
     */
    public function setLattitude($lattitude)
    {
        $this->_oLattitude = new DTString($lattitude);
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->_oLongitude = new DTString($longitude);
    }

    /**
     * @param mixed $deviceType
     */
    public function setDeviceType($deviceType)
    {
        $this->_oDeviceType = new DTString($deviceType);
    }

    /**
     * @param mixed $deviceType
     */
    public function setDataCenters($sDataCenters)
    {
        $this->_oDataCenters = new DTString($sDataCenters);
    }

    public function setMultiPort($iMultiPort)
    {
        $this->_oMultiport = new DTInteger($iMultiPort);
    }
    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->_oToken = new DTString($token);
    }

    public function setExtras($token)
    {
        $this->_oExtra = new DTString($token);
    }

    public function setVersion($sVersion)
    {
        $this->_oVersion = new DTInteger($sVersion);
    }
}
