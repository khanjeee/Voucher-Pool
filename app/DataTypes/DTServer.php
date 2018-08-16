<?php

namespace App\DataTypes;

use Disrupt\Common\DataTypes\DTFloat;
use Disrupt\Common\DataTypes\DTInteger;
use Disrupt\Common\DataTypes\DTString;
use Disrupt\Common\Helper as DisruptHelper;

class DTServer
{

 

    const COL_DATACENTER_ID = 'datacenter_id';
    const COL_PROTOCOL_NO   = 'protocol_number';
    const COL_PROTOCOL_IP   = 'protocol_ip';
    const COL_PROTOCOL_HOST = 'protocol_host';
    const COL_HUB_KEY       = 'hubkey';
    const COL_PORT_NO       = 'port_number';
    const COL_SERVER_ID     = 'server_id';
    const COL_SERVER_HOST   = 'server_host';
    const COL_SERVER_IP     = 'server_ip';
    const COL_SERVER_LOAD   = 'server_load';
    const COL_TUNNEL_TCP    = 'porttunneling_tcp';
    const COL_TUNNEL_UDP    = 'porttunneling_udp';
    const COL_IKEV_SUPPORT  = 'ikev_support';
    const COL_SERVER_TYPE   = 'server_type';
    const COL_RESELLER_HOST = 'reseller_host';


    const TBL_NAME  = 'speedtest_';
    const NAME      = 'speedtest';


    private $_oDataCenterId;
    private $_oServerId;
    private $_oServerLoad;
    private $_oPortNo;
    private $_oProtocolHost;
    private $_oHubKey;
    private $_oProtocolNo;
    private $_oServerHost;
    private $_oServerIp;
    private $_oTcp;
    private $_oUdp;
    private $_oIkev;
    private $_oServerType;
    private $_oResellerProtocolHost;

    /**
     * DTSpeedTest constructor.
     */

    public function __construct($aData)
    {
        $this->setBasicInfo($aData);
    }

    protected function setBasicInfo($aData)
    {
        $this->setDataCenterId(DisruptHelper::getKey($aData,self::COL_DATACENTER_ID,self::TBL_NAME));
        $this->setProtocolNumber(DisruptHelper::getKey($aData,self::COL_PROTOCOL_NO,self::TBL_NAME) );
        $this->setProtocolHost(DisruptHelper::getKey($aData,self::COL_PROTOCOL_HOST,self::TBL_NAME) );
        $this->setHubKey(DisruptHelper::getKey($aData,self::COL_HUB_KEY,self::TBL_NAME) );
        $this->setPortNo(DisruptHelper::getKey($aData,self::COL_PORT_NO,self::TBL_NAME));
        $this->setServerId(DisruptHelper::getKey($aData,self::COL_SERVER_ID,self::TBL_NAME) );
        $this->setServerHost(DisruptHelper::getKey($aData,self::COL_SERVER_HOST,self::TBL_NAME) );
        $this->setServerIp(DisruptHelper::getKey($aData,self::COL_SERVER_IP,self::TBL_NAME) );
        $this->setServerLoad(DisruptHelper::getKey($aData,self::COL_SERVER_LOAD,self::TBL_NAME) );
        $this->setPortTunnelingTcp(DisruptHelper::getKey($aData,self::COL_TUNNEL_TCP,self::TBL_NAME) );
        $this->setPortTunnelingUdp(DisruptHelper::getKey($aData,self::COL_TUNNEL_UDP,self::TBL_NAME) );
        $this->setIkevSupport(DisruptHelper::getKey($aData,self::COL_IKEV_SUPPORT,self::TBL_NAME) );
        $this->setServerType(DisruptHelper::getKey($aData,self::COL_SERVER_TYPE,self::TBL_NAME) );
        $this->setResellerProtocolHost(DisruptHelper::getKey($aData,self::COL_RESELLER_HOST,self::TBL_NAME) );

    }

    /**
     * @return mixed
     */
    public function getDataCenterId()
    {
        return $this->_oDataCenterId;
    }

    public function getPortTunnelingTcp()
    {
        return $this->_oTcp;
    }

    public function getPortTunnelingUdp()
    {
        return $this->_oUdp ;
    }

    public function getIkevSupport()
    {
        return $this->_oIkev;
    }

    public function getServerType()
    {
        return $this->_oServerType;
    }

    public function getResellerProtocolHost()
    {
        return $this->_oResellerProtocolHost;
    }
    

    /**
     * @return mixed
     */
    public function getProtocolNumber()
    {
        return $this->_oProtocolNo;
    }

    /**
     * @return mixed
     */
    public function getProtocolHost()
    {
        return $this->_oProtocolHost;
    }

    /**
     * @return mixed
     */
    public function getHubKey()
    {
        return $this->_oHubKey;
    }

   

    /**
     * @return mixed
     */
    public function getPortNo()
    {
        return $this->_oPortNo;
    }

    /**
     * @return mixed
     */
    public function getServerId()
    {
        return $this->_oServerId;
    }
    

    /**
     * @return mixed
     */
    public function getServerHost()
    {
        return $this->_oServerHost;
    }

    /**
     * @return mixed
     */
    public function getServerIp()
    {
        return $this->_oServerIp;
    }

    /**
     * @return mixed
     */
    public function getServerLoad()
    {
        return $this->_oServerLoad;
    }


    

/*************setters********/

    public function setPortTunnelingTcp($value)
    {
        $this->_oTcp = new DTInteger($value);
    }

    public function setPortTunnelingUdp($value)
    {
        $this->_oUdp = new DTInteger($value); 
    }

    public function setIkevSupport($value)
    {
        $this->_oIkev = new DTInteger($value);
    }

    public function setServerType($value)
    {
        $this->_oServerType = new DTString($value);
    }

    public function setResellerProtocolHost($value)
    {
        $this->_oResellerProtocolHost = new DTString($value);
    }

    /**
     * @param mixed $speedTestId
     */
    public function setDataCenterId($value)
    {
        $this->_oDataCenterId = new DTInteger($value);
    }

    /**
     * @param mixed $userId
     */
    public function setPortNo($value)
    {
        $this->_oPortNo = new DTString($value);
    }

    

    /**
     * @param mixed $countryId
     */
    public function setProtocolHost($value)
    {
        $this->_oProtocolHost = new DTString($value);
    }

    /**
     * @param mixed $cityId
     */
    public function setHubKey($value)
    {
        $this->_oHubKey = new DTString($value);
    }

    /**
     * @param mixed $protocolId
     */
    public function setProtocolNumber($value)
    {
        $this->_oProtocolNo = new DTInteger($value);
    }

    /**
     * @param mixed $ip
     */
    public function setServerHost($value)
    {
        $this->_oServerHost = new DTString($value);
    }
    


    public function setServerIp($value)
    {
        $this->_oServerIp = new DTString($value);
    }

    public function setServerLoad($value)
    {
        $this->_oServerLoad = new DTFloat($value);
    }
    /**
     * @param mixed $token
     */
    public function setServerId($value)
    {
        $this->_oServerId = new DTInteger($value);
    }
}
