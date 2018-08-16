<?php

namespace App\Models;


use App\Helper\Helper;
use Disrupt\Libraries\DAO\DB;


class Reseller
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


    public function validate($iResellerId)
    {
       return $this->db_validate($iResellerId);

    }


    private function db_validate($iResellerId)
    {
        $aInput   = array('p_reseller_id' => $iResellerId, 'p_status'=>1);


        $sQuery = "SELECT id FROM pf_reseller reseller WHERE id=:p_reseller_id AND status = :p_status;";

        return $this->_db->row($sQuery, $aInput);
    }
    

    public function validateCountry($iResellerId,$iCountryId)
    {
        return $this->db_validateCountry($iResellerId,$iCountryId);

    }


    private function db_validateCountry($iResellerId,$iCountryId)
    {
        $aInput   = array(
                            'p_reseller_id' => $iResellerId,
                            'p_country_id' => $iCountryId,
                            'p_service_id' => 8  //country
                        );


        $sQuery = "SELECT
                    reseller_country.country_id
                    
                    FROM   pf_reseller_inventory AS reseller_inventory
                    LEFT JOIN pf_reseller_inventory_country AS reseller_country ON  reseller_country.`reseller_inventory_id` = reseller_inventory.`id`
                    LEFT JOIN pf_service_type AS service_type ON reseller_inventory.`service_type_id` = service_type.`id`
                    LEFT JOIN pf_service AS service ON service.`id` = service_type.`service_id`
                    
                    WHERE  reseller_country.country_id    = :p_country_id
                    AND   `service`.`id`                  = :p_service_id
                    AND   reseller_inventory.reseller_id  = :p_reseller_id ;";
        

        return $this->_db->row($sQuery, $aInput);
    }

    public function validateCity($iResellerId,$iCityId)
    {
        return $this->db_validateCity($iResellerId,$iCityId);

    }


    private function db_validateCity($iResellerId,$iCityId)
    {
        $aInput   = array(
            'p_reseller_id' => $iResellerId,
            'p_city_id' => $iCityId,
            'p_service_id' => 9  //country
        );


        $sQuery = "SELECT
                    reseller_city.country_id
                    
                    FROM   pf_reseller_inventory AS reseller_inventory
                    LEFT JOIN pf_reseller_inventory_city AS reseller_city ON  reseller_city.`reseller_inventory_id` = reseller_inventory.`id`
                    LEFT JOIN pf_service_type AS service_type ON reseller_inventory.`service_type_id` = service_type.`id`
                    LEFT JOIN pf_service AS service ON service.`id` = service_type.`service_id`
                    
                    WHERE  reseller_city.city_id          = :p_city_id
                    AND   `service`.`id`                  = :p_service_id
                    AND   reseller_inventory.reseller_id  = :p_reseller_id ;";


        return $this->_db->row($sQuery, $aInput);
    }

    public function validateProtocol($iResellerId,&$iProtocolId,&$iProtocolNo2,&$iProtocolNo3,$iCountryId)
    {
        return $this->db_validateProtocol($iResellerId,$iProtocolId,$iProtocolNo2,$iProtocolNo3,$iCountryId);

    }


    private function db_validateProtocol($iResellerId,&$iProtocolNo,&$iProtocolNo2,&$iProtocolNo3, $iCountryId)
    {
        $sProtocols = Helper::commaSeperatedProtocols($iProtocolNo,$iProtocolNo2,$iProtocolNo3);

        $aInput   = array(
            'p_reseller_id' => $iResellerId,
            /*'p_protocols' => $sProtocols,*/
            'p_country_id' => $iCountryId,
            'p_service_id' => 8  //country
        );


        /*$sQuery = "SELECT
                   
                    DISTINCT(reseller_country_protocol.`protocol_id`)
                    
                    FROM   pf_reseller_inventory AS reseller_inventory
                    LEFT JOIN pf_reseller_inventory_country AS reseller_country ON  reseller_country.`reseller_inventory_id` = reseller_inventory.`id`
                    LEFT JOIN pf_reseller_inventory_country_protocol AS reseller_country_protocol ON reseller_country_protocol.`reseller_inventory_country_id` = reseller_country.`id`
                    LEFT JOIN new_protocols protocol ON protocol.id = reseller_country_protocol.protocol_id
                    LEFT JOIN pf_service_type AS service_type ON reseller_inventory.`service_type_id` = service_type.`id`
                    LEFT JOIN pf_service AS service ON service.`id` = service_type.`service_id`
                    
                    WHERE reseller_country.country_id           = :p_country_id
                    AND   service.id                            = :p_service_id
                    AND   reseller_inventory.reseller_id        = :p_reseller_id
                    AND   protocol.protocol_number		        = :p_protocol_no ;";*/

        /*$sQuery = "SELECT DISTINCT LENGTH('".$sProtocols."') - LENGTH(REPLACE('".$sProtocols."', ',', '')) + 1 AS no_of_protocols_requested, no_of_protocols_allowed
                    FROM (
                        SELECT
                   
                    COUNT(DISTINCT reseller_country_protocol.`protocol_id`) AS no_of_protocols_allowed
                    
                    FROM   pf_reseller_inventory AS reseller_inventory
                    LEFT JOIN pf_reseller_inventory_country AS reseller_country ON  reseller_country.`reseller_inventory_id` = reseller_inventory.`id`
                    LEFT JOIN pf_reseller_inventory_country_protocol AS reseller_country_protocol ON reseller_country_protocol.`reseller_inventory_country_id` = reseller_country.`id`
                    LEFT JOIN new_protocols protocol ON protocol.id = reseller_country_protocol.protocol_id
                    LEFT JOIN pf_service_type AS service_type ON reseller_inventory.`service_type_id` = service_type.`id`
                    LEFT JOIN pf_service AS service ON service.`id` = service_type.`service_id`
                    
                    WHERE reseller_country.country_id     = :p_country_id
                    AND   service.id                      = :p_service_id
                    AND   reseller_inventory.reseller_id  = :p_reseller_id
                    AND   protocol.protocol_number	IN (".$sProtocols.") ) AS tmp_servers
                    HAVING  ( no_of_protocols_requested =  no_of_protocols_allowed );";*/

        $sQuery = "SELECT GROUP_CONCAT( DISTINCT protocol.protocol_number) AS allowed_protocols
                    
                    FROM   pf_reseller_inventory AS reseller_inventory
                    LEFT JOIN pf_reseller_inventory_country AS reseller_country ON  reseller_country.`reseller_inventory_id` = reseller_inventory.`id`
                    LEFT JOIN pf_reseller_inventory_country_protocol AS reseller_country_protocol ON reseller_country_protocol.`reseller_inventory_country_id` = reseller_country.`id`
                    LEFT JOIN new_protocols protocol ON protocol.id = reseller_country_protocol.protocol_id
                    LEFT JOIN pf_service_type AS service_type ON reseller_inventory.`service_type_id` = service_type.`id`
                    LEFT JOIN pf_service AS service ON service.`id` = service_type.`service_id`
                    
                    WHERE reseller_country.country_id     = :p_country_id
                    AND   service.id                      = :p_service_id
                    AND   reseller_inventory.reseller_id  = :p_reseller_id
                    AND   protocol.protocol_number	IN (".$sProtocols.")";

        $aResults               = $this->_db->row($sQuery, $aInput);
        $aRequestedProtocols    = explode(',',$sProtocols);

        if(!empty($aResults))
        {
            $aAllowedProtocols = explode(',',$aResults['allowed_protocols']);

            $aProtocolsNotAllowed   =  array_diff($aRequestedProtocols,$aAllowedProtocols);

            /*check to make sure the protocols which are allowed are retuned
            earlier we use to return not servers in case a protocol not allowed was passed*/
            foreach ($aProtocolsNotAllowed as $iProtocol)
            {
                if($iProtocolNo==$iProtocol)
                {
                    $iProtocolNo = 0;
                }
                if($iProtocolNo2==$iProtocol)
                {
                    $iProtocolNo2 = 0;
                }
                if($iProtocolNo3==$iProtocol)
                {
                    $iProtocolNo3 = 0;
                }
                    
            }

        }
        //Helper::dump($aProtocolsNotAllowed);
        //Helper::dump($sProtocols);
        //Helper::dump($aResults['allowed_protocols']);
        //Helper::dumpAndDie([$iProtocolNo,$iProtocolNo2,$iProtocolNo3]);
        //dd($sQuery);
        return $aResults['allowed_protocols'];
    }

    public function validatePurpose($iCountryId,$iPurposeId)
    {
        return $this->db_validatePurpose($iCountryId,$iPurposeId);

    }


    private function db_validatePurpose($iCountryId,$iPurposeId)
    {
        $aInput   = array(
            'p_purpose_id' => $iPurposeId,
            'p_country_id' => $iCountryId,
        );


        $sQuery = "SELECT purposes.id AS purpose_id
                  FROM new_servers servers
                  LEFT JOIN new_servers_purposes ON new_servers_purposes.server_id = servers.id 
                  LEFT JOIN new_purposes purposes ON purposes.id = new_servers_purposes.purpose_id
                  
                 		
                  WHERE servers.`ip_location_countryid` = :p_country_id
                  AND   purposes.status                 = 1
                  AND   purposes.id                     = :p_purpose_id";


        return $this->_db->row($sQuery, $aInput);
    }

    public function validateAdvanceFeatures($iResellerId,$aJson){

        return $this->db_validateAdvanceFeatures($iResellerId,$aJson);
    }
    
    public function db_validateAdvanceFeatures($iResellerId,$aJson){


        foreach ($aJson->aAdvanceFeatures as $aAdvanceFeature)
        {
            $aAdvanceFeatures[] = $aAdvanceFeature->id;
        }

        $sAdvanceFeatures = implode(',',$aAdvanceFeatures);

        $aInput   = array(
            'p_reseller_id' => $iResellerId

        );


        $sQuery = "SELECT   LENGTH('".$sAdvanceFeatures."') - LENGTH(REPLACE('".$sAdvanceFeatures."', ',', '')) + 1 AS no_of_features_requested,no_of_features_allowed
                     FROM ( SELECT   COUNT( DISTINCT `service`.`id`) AS no_of_features_allowed    FROM   pf_reseller_inventory AS reseller_inventory
                    LEFT JOIN pf_reseller_inventory_country AS reseller_country ON  reseller_country.`reseller_inventory_id` = reseller_inventory.`id`
                    LEFT JOIN pf_service_type AS service_type ON reseller_inventory.`service_type_id` = service_type.`id`
                    LEFT JOIN pf_service AS service ON service.`id` = service_type.`service_id`
                    WHERE  
                    service.id IN (".$sAdvanceFeatures.")
                    AND   reseller_inventory.reseller_id  = :p_reseller_id ) AS tmp_data
                    HAVING (no_of_features_requested = no_of_features_allowed)";


        return $this->_db->row($sQuery, $aInput);
    }

    public function getCommaSeperateAdvanceFeatureSlugByIds($sAdvanceFeatureIds)
    {
        return $this->db_getCommaSeperateAdvanceFeatureSlugByIds($sAdvanceFeatureIds);

    }


    private function db_getCommaSeperateAdvanceFeatureSlugByIds($sAdvanceFeatureIds)
    {
        $sQuery = "SELECT  GROUP_CONCAT(s.`slug`) slugs  FROM `pf_service` s  WHERE s.id IN (".$sAdvanceFeatureIds.");";
        return $this->_db->row($sQuery);
    }
}
