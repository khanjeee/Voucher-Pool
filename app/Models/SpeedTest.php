<?php

namespace App\Models;

use App\Constants\Constants;
use App\DataTypes\DTServer;
use App\DataTypes\DTToken;
use App\Helper\Helper;
use App\Helper\RedisHelper;
use Curl\Curl;
use Disrupt\Common\Helper as DisruptHelper;
use Disrupt\Libraries\DAO\DB;
use Disrupt\Libraries\GeoIp2\GeoIp2;


class SpeedTest
{
    private $_db;

    /**
     * Reseller constructor.
     * @param $_db
     */
    public function __construct()
    {
        $this->_db = new DB('DB-DX');
    }


    public function insert($iResellerId, $iProtocolNo, $iProtocolNo2, $iProtocolNo3, $isFree,$iMultiPort, $iCountryId, $iCityId, $sUserName,$iPurposeId,$sIp,$sDeviceType, $sDataCenters,$sExtras,$iVersion,$sToken)
    {
       return $this->db_insert($iResellerId,$iProtocolNo,$iProtocolNo2,$iProtocolNo3,$isFree,$iMultiPort,$iCountryId, $iCityId, $sUserName,$iPurposeId,$sIp,$sDeviceType,$sDataCenters,$sExtras,$iVersion,$sToken);

    }


    private function db_insert($iResellerId, $iProtocolNo, $iProtocolNo2, $iProtocolNo3, $isFree,$iMultiPort, $iCountryId, $iCityId, $sUserName, $iPurposeId, $sIp,$sDeviceType, $sDataCenters, $sExtras,$iVersion,$sToken)
    {
        $sDataCenters = (gettype($sDataCenters) == 'array') ? Helper::convertArrayToString($sDataCenters) : $sDataCenters;
        
        $aInput   = array(
            'p_reseller_id'  => $iResellerId,
            'p_protocol_no'  => $iProtocolNo,
            'p_protocol_no_2'=> $iProtocolNo2,
            'p_protocol_no_3'=> $iProtocolNo3,
            'p_is_free'      => $isFree,
            'p_multiport'    => $iMultiPort,
            'p_purpose_id'   => $iPurposeId,
            'p_ip_address'   => $sIp,
            'p_device_type'  => $sDeviceType,
            'p_country_id'   => $iCountryId,
            'p_city_id'      => $iCityId,
            'p_username'     => $sUserName,
            'p_datacenters'  => $sDataCenters,
            'p_extras'       => $sExtras,
            'p_version'       => $iVersion,
            'p_token'        => $sToken

        );
//dd($aInput);

        $sQuery = "INSERT INTO pf_speedtest
                        (
                         username,
                         reseller_id,
                         country_id,
                         city_id,
                         purpose_id,
                         ip_address,
                         is_free,
                         multiport,
                         device_type,
                         datacenters,
                         protocol_no,
                         protocol_no_2,
                         protocol_no_3,
                         extras,
                         version,
                         token
                         
                         )
                VALUES (
                        :p_username,
                        :p_reseller_id,
                        :p_country_id,
                        :p_city_id,
                        :p_purpose_id,
                        :p_ip_address,
                        :p_is_free,
                        :p_multiport,
                        :p_device_type,
                        :p_datacenters,
                        :p_protocol_no,
                        :p_protocol_no_2,
                        :p_protocol_no_3,
                        :p_extras,
                        :p_version,
                        :p_token
                        );";

        $sQuery2 = "INSERT INTO pf_speedtest_logs
                        (
                         username,
                         reseller_id,
                         country_id,
                         city_id,
                         purpose_id,
                         ip_address,
                         is_free,
                         multiport,
                         device_type,
                         datacenters,
                         protocol_no,
                         protocol_no_2,
                         protocol_no_3,
                         extras,
                         version,
                         token
                         
                         )
                VALUES (
                        :p_username,
                        :p_reseller_id,
                        :p_country_id,
                        :p_city_id,
                        :p_purpose_id,
                        :p_ip_address,
                        :p_is_free,
                        :p_multiport,
                        :p_device_type,
                        :p_datacenters,
                        :p_protocol_no,
                        :p_protocol_no_2,
                        :p_protocol_no_3,
                        :p_extras,
                        :p_version,
                        :p_token
                        );";


        $oDb =  new DB('DB-DX');
        $oDb->query($sQuery2, $aInput);
        $this->_db->query($sQuery, $aInput);
        return $this->_db->lastInsertId();
    }
    
    public function removeExpiredTokens($iInterval)
    {
        return $this->db_removeExpiredTokens($iInterval);
    }

    private function db_removeExpiredTokens($iInterval)
    {
        $aInput = array('p_interval'=> $iInterval );
        
        $sQuery = "DELETE FROM `pf_speedtest` WHERE `created_on` <= DATE_SUB(NOW(),INTERVAL :p_interval MINUTE);";

        return $this->_db->query($sQuery, $aInput);
        
    }


    public function removePskByStatus()
    {
        return $this->db_removePskByStatus();
    }

    private function db_removePskByStatus()
    {
        //$aInput = array('p_interval'=> $iInterval );

        $sQuery = "DELETE FROM `pf_speedtest` WHERE `status` = 1;";

        return $this->_db->query($sQuery);

    }

    public function getByToken($sToken)
    {
        return $this->db_getByToken($sToken);
    }

    private function db_getByToken($sToken)
    {
        $aInput     =   array('p_token'=> $sToken );

        $sQuery = "SELECT * FROM `pf_speedtest` WHERE `token`= :p_token ;";

        $aResult=   $this->_db->row($sQuery, $aInput);

        //delete psks where no advance features are requested
        if(!empty($aResult) && strpos($aResult['extras'], 'advance_features')  === false)
        {
            $sQueryDelete = "DELETE FROM `pf_speedtest` WHERE `token`= :p_token ;";
            $this->_db->query($sQueryDelete, $aInput);
        }


        return $aResult;

    }
    
 
    public function getDataCenters($sDatacenterIds)
    {
       return $this->db_getDataCenters($sDatacenterIds);
    }

    private function db_getDatacenters($sDatacenterIds)
    {

        $aInput = array();//array('p_datacenterid' => $aParams['aDatacenterIds']);

        $sQuery = "SELECT id, dc_name FROM new_datacenters WHERE id IN (" . $sDatacenterIds . ")";
        $aResult = $this->_db->query($sQuery, $aInput);
        return $aResult;
    }

   


    function logFailedServers($requestId,$failedServers) {
        if(empty($requestId) || empty($failedServers)) {
            return false;
        }

        $failedServers = explode(',',$failedServers);
        $values = array();
        foreach($failedServers as $failedServer) {
            $values[] = "($requestId,$failedServer)";
        }

        $query = "INSERT INTO new_failed_servers (server_request_id,server_id) VALUES " . implode(',',$values) . ";";

        return $this->db->query($query);
    }
    


    public function getAcknowledgementServer(DTToken $oToken)
    {
        $aResult            =  $this->db_getAcknowledgementServer($oToken);
        $sFailover          = '';

        if(!empty($aResult))
        {
            foreach ($aResult as $aFailovers)
            {
                //seperating reseller specific failovers in an array
                if($aFailovers['reseller_id'] == $oToken->getResellerId()->value())
                {
                    $sFailover = $aFailovers['failover'];
                }
            }

            $sFailover = (!empty($sFailover)) ? $sFailover : $aResult[0]['failover'];
        }

        return $sFailover;

    }
    public function db_getAcknowledgementServer(DTToken $oToken)
    {
        $aInput = array(
            'p_reseller_id'     =>  $oToken->getResellerId()->value(),
            'p_country_id'      =>  $oToken->getCountryId()->value(),
            'p_city_id'         =>  0,
            'p_dns_type_id'     =>  Constants::DNS_TYPE_ID_ACKNOWLEDGEMENT_SERVER,
            'p_server_type'     =>  Constants::SERVER_TYPE_WINDOWS,
            'p_speedtest_method'=>  Constants::SPEEDTEST_METHOD_AFO,
            'p_protocol_nos'    =>  $oToken->getAllProtocolsCommaSeperated(),
        );


        $aResult = $this->_db->query(Constants::SP_GET_FAILOVER_SERVERS_BY_DNS_TYPE,$aInput);

        return $aResult;
        /*$aInput = array('p_country_id'=>$iCountryId);

        $sQuery = "SELECT ack_server FROM `new_country_acknowledgement_servers` WHERE country_id =:p_country_id";

        $aResult = $this->_db->row($sQuery, $aInput);

        return $aResult['ack_server'];*/
    }
    
    public function getServersByDataCenterIds(DTToken $oToken)
    {
        return $this->db_getServersByDataCenterIds($oToken);
    }

    private function db_getServersByDataCenterIds(DTToken $oToken)
    {
        $aDTServers = [];
        try
        {
            $aAdvanceFeatureExtras = json_decode($oToken->getExtras()->value());
    
            $sCommaSeperatedFeatureIds = '';
    
            if(!empty($aAdvanceFeatureExtras) && isset($aAdvanceFeatureExtras->advance_features))
            {
                foreach ($aAdvanceFeatureExtras->advance_features as $aFeatures)
                {
                    $aFeatureIds[] = $aFeatures->id;
                }
    
                $sCommaSeperatedFeatureIds = implode(',',$aFeatureIds);
            }

            $aInput = array(
                'p_purpose_id'      =>  $oToken->getPurposeId()->value(),
                'p_country_id'      =>  $oToken->getCountryId()->value(),
                'p_city_id'         =>  $oToken->getCityId()->value(),
                'p_datacenter_ids'  =>  $oToken->getDataCentersCommaSeperated(),
                'p_protocol_nos'    =>  $oToken->getAllProtocolsCommaSeperated(),
                'p_is_free'         =>  $oToken->getIsFree()->value(),
                'p_reseller_id'     =>  $oToken->getResellerId()->value(),

            );
            
            if(!empty($sCommaSeperatedFeatureIds))
            {
                //ivap returns all features including childs this call removed child ids
                $aAdvanceFeatures = $this->validateAdvanceFeatures($sCommaSeperatedFeatureIds);

                foreach (explode(',',$aAdvanceFeatures['slugs']) as $sSlug)
                {
                    $aLikeQuerySlugs[] = " SPR.tags_avf NOT LIKE '%$sSlug%' ";
                }

                $sLikeQuerySlugs   = implode(' AND ',$aLikeQuerySlugs);
                //Helper::dumpAndDie($sCommaSeperatedFeatureIds);
    
                //adding values to $aInput array for avf
                $aInput['p_avf_ids']        = $aAdvanceFeatures['feature_ids'];
                $aInput['p_avf_like_tags']  = $sLikeQuerySlugs;

                $aResults = $this->_db->query(Constants::SP_GET_AVF_SERVERS_BY_DC,$aInput);
            }
            else
            {
                $aResults = $this->_db->query(Constants::SP_GET_SERVERS_BY_DC,$aInput);
            }
    
            //Helper::dumpAndDie($aResults);
            if(!empty($aResults))
            {
                foreach ($aResults as $aResult)
                {
                    $aDTServers[] = new DTServer($aResult);
                }
            }
        }
        catch(\Exception $e)
        {
            //Helper::log_php($e->getMessage());
            Helper::postExceptionsToSlack($e->getMessage(),__FILE__);
            $aDTServers = [] ;
        }
        
        return $aDTServers;
       
        
    }


    public function getServersByLatLong(DTToken $oToken)
    {
        return $this->db_getServersByLatLong($oToken);
    }

    private function db_getServersByLatLong(DTToken $oToken)
    {
        
        $aDTServers = [];
        try
        {
            $oGeoIp =  new GeoIp2($oToken->getIp()->value());
            $sLatt = $oGeoIp->getReader()->location->latitude;
            $sLong = $oGeoIp->getReader()->location->longitude;
            
            $aAdvanceFeatureExtras = json_decode($oToken->getExtras()->value());

            $sCommaSeperatedFeatureIds = '';

            if(!empty($aAdvanceFeatureExtras) && isset($aAdvanceFeatureExtras->advance_features))
            {
                foreach ($aAdvanceFeatureExtras->advance_features as $aFeatures)
                {
                    $aFeatureIds[] = $aFeatures->id;
                }

                $sCommaSeperatedFeatureIds = implode(',',$aFeatureIds);
            }

            $aInput = array(
                'p_purpose_id'      =>  $oToken->getPurposeId()->value(),
                'p_country_id'      =>  $oToken->getCountryId()->value(),
                'p_city_id'         =>  $oToken->getCityId()->value(),
                'p_lattitude'       =>  $sLatt,
                'p_longitude'       =>  $sLong,
                'p_protocol_nos'    =>  $oToken->getAllProtocolsCommaSeperated(),
                'p_is_free'         =>  $oToken->getIsFree()->value(),
                'p_reseller_id'     =>  $oToken->getResellerId()->value(),

            );

            if(!empty($sCommaSeperatedFeatureIds))
            {
                //ivap returns all features including childs this call removed child ids
                $aAdvanceFeatures = $this->validateAdvanceFeatures($sCommaSeperatedFeatureIds);

                foreach (explode(',',$aAdvanceFeatures['slugs']) as $sSlug)
                {
                    $aLikeQuerySlugs[] = " SPR.tags_avf NOT LIKE '%$sSlug%' ";
                }

                $sLikeQuerySlugs   = implode(' AND ',$aLikeQuerySlugs);

                $aInput['p_avf_ids']         =  $aAdvanceFeatures['feature_ids'];
                $aInput['p_avf_like_tags']   =  $sLikeQuerySlugs;

                $aResults = $this->_db->query(Constants::SP_GET_AVF_SERVERS_BY_LL,$aInput);
            }
            else
            {
                $aResults = $this->_db->query(Constants::SP_GET_SERVERS_BY_LL,$aInput);
            }

            //Helper::dumpAndDie($aResults);

            if(!empty($aResults))
            {
                foreach ($aResults as $aResult)
                {
                    $aDTServers[] = new DTServer($aResult);
                }
            }
        }
        catch(\Exception $e)
        {
            //Helper::log_php($e->getMessage());
            Helper::postExceptionsToSlack($e->getMessage(),__FILE__);
            $aDTServers = [] ;
        }
        return $aDTServers;


    }

    public function validateAdvanceFeatures($sCommaSeperatedFeatureIds)
    {
        return $this->db_validateAdvanceFeatures($sCommaSeperatedFeatureIds);
    }

    private function db_validateAdvanceFeatures($sCommaSeperatedFeatureIds)
    {

        $sQuery = "SELECT GROUP_CONCAT(id) AS feature_ids, GROUP_CONCAT(slug) AS slugs FROM pf_service WHERE id  IN ($sCommaSeperatedFeatureIds)";
        $aResult = $this->_db->row($sQuery);
        //Helper::dumpAndDie($aResult);
        return $aResult;
    }


    public function pingHandler(DTServer $aServer)
    {
        return $this->db_pingHandler($aServer);
    }

    private function db_pingHandler(DTServer $aServer)
    {
        $iPortNumber = 0 ;
        
        switch($aServer->getProtocolNumber()->value())
        { 
            case Constants::PROTOCOL_TCP_NO:
                $iPortNumber = Constants::TCP_PORT_NUMBER;
                break;
            case Constants::PROTOCOL_UDP_NO:
                $iPortNumber = Constants::UDP_PORT_NUMBER;
                break;
            default:
                $iPortNumber = Constants::RRAS_PORT_NUMBER;
        }

        $iPortNumber = (!empty($aServer->getPortNo()->value())) ? $aServer->getPortNo()->value() : $iPortNumber;
        
        $iErrorNo = 6;

        try
        {
            $bSocketOpen = @fsockopen(trim($aServer->getProtocolHost()->value()),
                $iPortNumber,
                $iErrorNo,
                $iErrorNo,
                Constants::PING_ERROR_TIMEOUT
            );
        }
        catch(\Exception $e)
        {
            Helper::postExceptionsToSlack($e->getMessage(),__FILE__);
            $bSocketOpen = false;
        }

        //if socket is not opened then return false - server is not responding
        return (!$bSocketOpen) ? false : true;

    }
    

    public function getProtocolIdByNumber($iProtocolNumber)
    {
        return $this->db_getProtocol($iProtocolNumber);
    }

    private function db_getProtocol($iProtocolNumber)
    {
        $aInput = array('p_protocol_number' => $iProtocolNumber);
        $sQuery = "SELECT id FROM new_protocols WHERE protocol_number = :p_protocol_number";
        $aResult = $this->_db->row($sQuery, $aInput);
        return $aResult;
    }


    public function getCountryIso($iCountryId)
    {
        return $this->db_getCountryIso($iCountryId);
    }
    private function db_getCountryIso($iCountryId)
    {
        $aInput = array('p_country_id' => $iCountryId);
        $sQuery = "SELECT iso2 FROM new_map_countries WHERE id = :p_country_id";
        $aResult = $this->_db->row($sQuery, $aInput);
        return $aResult;
    }



    public function validateConnectionRequest($sUserName,$iResellerId,$iCountryId,$iCityId,$sExtras,$sProtocolNumbers)
    {
        //Helper::dumpAndDie($sProtocolNumbers);
        $aSettings = DisruptHelper::getSettings();

        $sExtras = (empty($sExtras)) ? new \stdClass() : $sExtras;
        $sExtras->sUsername       = $sUserName;
        $sExtras->iResellerId     = $iResellerId;
        $sExtras->iCountryId      = $iCountryId;
        $sExtras->iCityId         = $iCityId.'';
        $sExtras->aProtocolNumber = explode(',',$sProtocolNumbers);

        //Helper::dumpAndDie($sExtras);
        $sModule = Constants::REDIS_VALIDATE_USER_PREFERENCES;

        try
        {
            $oRedis = new RedisHelper();
            $aResponse = Helper::redisGetUserInfo($sModule,$sUserName,$sExtras,$oRedis);

            //get data from ivap and add it to redis / if not present in redis
            if(empty($aResponse))
            {
                $oCurl = new Curl();
                $oCurl->setOpt(CURLOPT_SSL_VERIFYPEER,false);
                $oCurl->setOpt(CURLOPT_RETURNTRANSFER,true);
                $oCurl->setHeader('X-Psk',$aSettings['service-urls']['x-psk_speedtest']);
                $aResponse = $oCurl->post($aSettings['service-urls']['validate_user_preferences'],$sExtras);
                
                //saving response to redis
                if(isset($aResponse->header->code) && $aResponse->header->code == 1 )
                {
                    Helper::redisSetUserInfo($sModule,$sUserName,$sExtras,$aResponse,$oRedis);
                }
                
                
            }
        }
        catch(\Exception $e)
        {
            //handling exception in case redis fails
            $oCurl = new Curl();
            $oCurl->setOpt(CURLOPT_SSL_VERIFYPEER,false);
            $oCurl->setOpt(CURLOPT_RETURNTRANSFER,true);
            $oCurl->setHeader('X-Psk',$aSettings['service-urls']['x-psk_speedtest']);
            $aResponse = $oCurl->post($aSettings['service-urls']['validate_user_preferences'],$sExtras);
            //Helper::log_php('Redis: '.$e->getMessage());
            //Helper::postExceptionsToSlack($e->getMessage(),__FILE__);

        }

        //Helper::dumpAndDie($aResponse);
        return $aResponse;
    }


    public function validateAbuseByUserName($sUserName,$iAllowedLogins,$iAllowedSessions)
    {

        $aSettings  = DisruptHelper::getSettings();
        $oCurl      = new Curl();
        $oCurl->setHeader('X-Psk',$aSettings['service-urls']['x-psk_speedtest']);
        $aResponse  = $oCurl->get($aSettings['service-urls']['validate_abuse'],['sUsername'=>$sUserName,
                                                                                'iAllowedLogins'=>$iAllowedLogins,
                                                                                'iAllowedSessions'=>$iAllowedSessions]);

        //$aResponse->body->multi_login_validation = 0;
        //$aResponse->body->multi_login_validation = 0;
        //Helper::dumpAndDie($aResponse);
        return $aResponse;
    }
    public function updateSpeedtestLog($sPsk='',$sResponse='')
    {
        return $this->db_updateSpeedtestLog($sPsk,$sResponse);
    }

    private function db_updateSpeedtestLog($sPsk,$sResponse) {

        $oDb = new DB('DB-DX');

        $aInput = array('p_psk' => $sPsk,'p_response' => json_encode($sResponse));

        $sQuery = "UPDATE pf_speedtest_logs SET response = :p_response WHERE token= :p_psk ;  ";

        $iResult = $oDb->query($sQuery, $aInput);
        if ($iResult) {

            try {

                $iResult = $this->db_insertLogData($sPsk);
            } catch (\Exception $e) {
                Helper::postExceptionsToSlack($e->getMessage(),__FILE__);
            }

        }


        return $iResult;
    }

    public function addSpeedtestLogs($sServerId) 
    {
        return $this->db_addSpeedtestLogs($sServerId);
    }
    
    private function db_addSpeedtestLogs($sServerId) {

        $oDb = new DB('DB-DX');

        $aInput = array('p_server_id' => $sServerId);

        $sSelectQuery = "SELECT fail_count,server_id FROM pf_speedtest_failed_servers WHERE server_id=:p_server_id LIMIT 1 ";

        $aResult = $oDb->row($sSelectQuery, $aInput);

        if(!empty($aResult))
        {
            $aInput['p_count']  = intval($aResult['fail_count'])+1 ;

            $sUpdateQuery = "UPDATE pf_speedtest_failed_servers SET fail_count=:p_count WHERE server_id=:p_server_id ";
            $oDb->query($sUpdateQuery, $aInput);
        }
        else
        {
            $sInsertQuery = "INSERT INTO pf_speedtest_failed_servers (server_id) VALUES(:p_server_id)";
            $oDb->query($sInsertQuery, $aInput);
        }

    }

    public function getAdvanceFeaturesByUsername($sUsername)
    {
        return $this->db_getAdvanceFeaturesByUsername($sUsername);

    }
    private function db_getAdvanceFeaturesByUsername($sUsername)
    {
        $aInput     =   array('p_username'=> $sUsername );

        $sQuery = "SELECT id,extras FROM `pf_speedtest` WHERE `username`= :p_username  ORDER BY created_on ASC  LIMIT 1;;";
        $aResult = $this->_db->row($sQuery, $aInput);

        if(!empty($aResult))
                $this->deletePskById($aResult['id']);

        return $aResult;

    }

    private function deletePskById($id)
    {
        $aInput     =   array('p_id'=> $id );
        $sUpdateQuery = "DELETE FROM pf_speedtest  WHERE id =:p_id; ";
        $this->_db->query($sUpdateQuery, $aInput);
    }

    public function addAbuseCaseByUsername($sUserName,$bLoginAbuse,$bSessionAbuse)
    {
        return $this->db_addAbuseCaseByUsername($sUserName,$bLoginAbuse,$bSessionAbuse);
    }
    private function db_addAbuseCaseByUsername($sUserName,$bLoginAbuse,$bSessionAbuse) {

        //0 login abuse
        //3  session abuse

        //$bLoginAbuse    = false;
        //$bSessionAbuse  = false;

        $oDb    = new DB('DB-SA');
        $aInput = array('p_username'      => $sUserName);

        $sSelectQuery = "SELECT GROUP_CONCAT(`usertype`) as abuse_types FROM abusedcases WHERE username = :p_username";
        $aResult      = $oDb->row($sSelectQuery, $aInput);

        if($aResult['abuse_types'] !='')
        {
            $aAbuseTypes = explode(',',$aResult['abuse_types']);

            $bLoginAbuse    = (in_array(0,$aAbuseTypes));
            $bSessionAbuse  = (in_array(3,$aAbuseTypes));

        }

        //Helper::dumpAndDie($aAbuseTypes);
        //var_dump($bLoginAbuse);
        //var_dump($bSessionAbuse); die;

        if($bLoginAbuse == false)
        {
            $sInsertQuery = "INSERT INTO abusedcases (servername,username,datetime,usertype,notes)
                                 VALUES ('',:p_username,NOW(),0,'Speedtest Login Abuse');";
            $oDb->query($sInsertQuery, $aInput);
        }

        if($bSessionAbuse == false)
        {
            $sInsertQuery = "INSERT INTO abusedcases (servername,username,datetime,usertype,notes)
                                 VALUES ('',:p_username,NOW(),3,'Speedtest Session Abuse');";
            $oDb->query($sInsertQuery, $aInput);
        }
    }


    public function getFailoverByCountryProtocol(DTToken $oToken)
    {
        $aResult            =  $this->db_getFailoverByCountryProtocol($oToken);
        $aResellerFailover  = [];

        if(!empty($aResult))
        {
           foreach ($aResult as $aFailovers)
           {
               //seperating reseller specific failovers in an array
               if($aFailovers['reseller_id'] == $oToken->getResellerId()->value())
               {
                   $aResellerFailover[] = $aFailovers;
               }
           }
        }

        return((!empty($aResellerFailover)) ? $aResellerFailover : $aResult);



    }
    private function db_getFailoverByCountryProtocol(DTToken $oToken)
    {


        $aInput = array(
                        'p_reseller_id'     =>  $oToken->getResellerId()->value(),
                        'p_country_id'      =>  $oToken->getCountryId()->value(),
                        'p_city_id'         =>  0,
                        'p_dns_type_id'     =>  Constants::DNS_TYPE_ID_FO_COUNTRY,
                        'p_server_type'     =>  Constants::SERVER_TYPE_WINDOWS,
                        'p_speedtest_method'=>  Constants::SPEEDTEST_METHOD_FO,
                        'p_protocol_nos'=>  $oToken->getAllProtocolsCommaSeperated(),
                        );

        $aResult = $this->_db->query(Constants::SP_GET_FAILOVER_SERVERS_BY_DNS_TYPE,$aInput);

        //Helper::dumpAndDie($aResult);
        return $aResult;

    }

    public function getFailoverByCityProtocol(DTToken $oToken)
    {
        $aResult            =  $this->db_getFailoverByCityProtocol($oToken);
        $aResellerFailover  = [];

        if(!empty($aResult))
        {
            foreach ($aResult as $aFailovers)
            {
                //seperating reseller specific failovers in an array
                if($aFailovers['reseller_id'] == $oToken->getResellerId()->value())
                {
                    $aResellerFailover[] = $aFailovers;
                }
            }
        }

        return((!empty($aResellerFailover)) ? $aResellerFailover : $aResult);

    }
    private function db_getFailoverByCityProtocol(DTToken $oToken)
    {
        $aInput = array(
            'p_reseller_id'     =>  $oToken->getResellerId()->value(),
            'p_country_id'      =>  $oToken->getCountryId()->value(),
            'p_city_id'         =>  $oToken->getCityId()->value(),
            'p_dns_type_id'     =>  Constants::DNS_TYPE_ID_FO_CITY,
            'p_server_type'     =>  Constants::SERVER_TYPE_WINDOWS,
            'p_speedtest_method'=>  Constants::SPEEDTEST_METHOD_FO,
            'p_protocol_nos'    =>  $oToken->getAllProtocolsCommaSeperated(),
        );

        $aResult = $this->_db->query(Constants::SP_GET_FAILOVER_SERVERS_BY_DNS_TYPE,$aInput);
        
        return $aResult;

    }

    public function getFailoverByPurposeProtocol($iPurposeId,$sProtocolNos)
    {
        return $this->db_getFailoverByPurposeProtocol($iPurposeId,$sProtocolNos);
    }
    private function db_getFailoverByPurposeProtocol($iPurposeId,$sProtocolNos)
    {

        $sProtocolNosString = "'". implode("','" ,explode(',',$sProtocolNos))."'";

        $aInput = array('p_purpose_id'  =>  $iPurposeId);

        $sQuery = "SELECT DISTINCT f.failover,p.protocol_number,'".Constants::SERVER_TYPE_WINDOWS."' as server_type,'".Constants::SPEEDTEST_METHOD_FO."' as speedtest_method  
                    FROM new_purposes_failovers f
                    INNER JOIN new_protocols p ON p.id = f.protocol_id
                    WHERE f.purpose_id = :p_purpose_id 
                    AND p.protocol_number IN ($sProtocolNos)
                    ORDER BY  FIELD(p.protocol_number,$sProtocolNosString)";;

        $aResult = $this->_db->query($sQuery, $aInput);

        return $aResult;

    }
    public function getAdvanceFeatureFailoverByCountryProtocol(DTToken $oToken)
    {
        $aResult            =  $this->db_getAdvanceFeatureFailoverByCountryProtocol($oToken);
        $aResellerFailover  = [];

        if(!empty($aResult))
        {
            foreach ($aResult as $aFailovers)
            {
                //seperating reseller specific failovers in an array
                if($aFailovers['reseller_id'] == $oToken->getResellerId()->value())
                {
                    $aResellerFailover[] = $aFailovers;
                }
            }
        }

        return((!empty($aResellerFailover)) ? $aResellerFailover : $aResult);
    }
    private function db_getAdvanceFeatureFailoverByCountryProtocol(DTToken $oToken)
    {

        $aInput = array(
            'p_reseller_id'     =>  $oToken->getResellerId()->value(),
            'p_country_id'      =>  $oToken->getCountryId()->value(),
            'p_city_id'         =>  0,
            'p_dns_type_id'     =>  Constants::DNS_TYPE_ID_AFO_COUNTRY,
            'p_server_type'     =>  Constants::SERVER_TYPE_LINUX,
            'p_speedtest_method'=>  Constants::SPEEDTEST_METHOD_AFO,
            'p_protocol_nos'    =>  $oToken->getAllProtocolsCommaSeperated(),
        );

        $aResult = $this->_db->query(Constants::SP_GET_FAILOVER_SERVERS_BY_DNS_TYPE,$aInput);


        //Helper::dumpAndDie($aResult);
        
        return $aResult;
    }

    private function db_insertLogData($sPsk)
    {

        $aResult = $this->getSpeedTestLogData($sPsk);

        if (!empty($aResult)) {

            $db = new DB('DB-ATOM-REPORTING');

                $aInput = array(
                    'username' => $aResult['username'],
                    'reseller_id' => $aResult['reseller_id'],
                    'country_id' => $aResult['country_id'],
                    'city_id' => $aResult['city_id'],
                    'purpose_id' => $aResult['purpose_id'],
                    'ip_address' => $aResult['ip_address'],
                    'is_free' => $aResult['is_free'],
                    'multiport' => $aResult['multiport'],
                    'device_type' => $aResult['device_type'],
                    'datacenters' => $aResult['datacenters'],
                    'protocol_no' => $aResult['protocol_no'],
                    'protocol_no_2' => $aResult['protocol_no_2'],
                    'protocol_no_3' => $aResult['protocol_no_3'],
                    'extras' => $aResult['extras'],
                    'token' => $aResult['token'],
                    'response' => $aResult['response'],
                    'created_on' => $aResult['created_on']
                );

                $result  =  $db->row(Constants::SP_INSERT_SPEED_TEST_LOG, $aInput);

            if (intval($result['affected_rows']) > 0) {
                return true;
            } else {
                return false;
            }
        } else {

            return false;
        }
    }

    private function getSpeedTestLogData($sPsk){

        $aInput  =  array(
            'sPsk'   => $sPsk
        );
        $result  =  $this->_db->row(Constants::SP_GET_SPEEDTEST_BY_PSK, $aInput);
        return   $result;
    }





}
