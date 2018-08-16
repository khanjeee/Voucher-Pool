<?php

namespace App\DataTypes;

use App\Helper\Helper;
use App\Models\SpeedTest;

class DTToken extends DTSpeedTest
{
   private $sDataCenterCommaSeperated = '';
   private $oModelSpeedTest;
    /**
     * Token constructor.
     */
    public function __construct()
    {
        $this->oModelSpeedTest = new SpeedTest();
    }

    public function validate($sToken)
    {
        $bResponse = false;
        
        if(!empty($sToken))
        {
            $aSpeedTest = $this->oModelSpeedTest->getByToken($sToken);

            if(!empty($aSpeedTest))
            {
                parent::setBasicInfo($aSpeedTest);
                $bResponse = true;
            }

           
        }
        
        return $bResponse;
        
    }
    
    public function getDataCentersCommaSeperated()
    {
        $sDataCenters = parent::getDataCenters()->value();
        
        if(!empty($sDataCenters))
        {
            $sDataCenters = (gettype($sDataCenters) == 'string') ? Helper::convertStringToArray($sDataCenters) : $sDataCenters ;
            
            $this->sDataCenterCommaSeperated = implode(",",json_decode($sDataCenters));
        }
        
        return $this->sDataCenterCommaSeperated ;
    }

    public function getDataCenterByIds()
    {
        $aDataCenters = [];
        $aDatacenterResult = $this->oModelSpeedTest->getDatacenters($this->sDataCenterCommaSeperated);
        if(!empty($aDatacenterResult))
        {
            foreach($aDatacenterResult as $iKey => $aDataCenter)
            {
                $aDataCenters[ $aDataCenter['id'] ] = $aDataCenter['dc_name'];
            }
        }
        
        return $aDataCenters;
    }
    
    public function getProtocolId()
    {
        if(!empty(parent::getProtocolNumber()->value()))
        {
            $oModelSpedTest = new SpeedTest();
            $aPurposeResult = $oModelSpedTest->getProtocolIdByNumber(parent::getProtocolNumber()->value());
            return $aPurposeResult['id'];
        }
        
        return 0;
    }
    
    public function getAllProtocolsCommaSeperated(){
    
        $aProtocols = [];
        if(!empty(parent::getProtocolNumber()->value())){
            
            $aProtocols[] = parent::getProtocolNumber()->value();
        }
        
        if(!empty(parent::getProtocolNumber2()->value())){

            $aProtocols[] = parent::getProtocolNumber2()->value();
        }
        if(!empty(parent::getProtocolNumber3()->value())){

            $aProtocols[] = parent::getProtocolNumber3()->value();    
        }
        
        return implode(',',$aProtocols);
    }

    public function getProtocolsCount(){

        $iCount = 0;
        if(!empty(parent::getProtocolNumber()->value())){

            $iCount++;
        }

        if(!empty(parent::getProtocolNumber2()->value())){

            $iCount++;
        }
        if(!empty(parent::getProtocolNumber3()->value())){

            $iCount++;
        }

        return $iCount;
        
    }
  
}
