<?php

namespace App\DataTypes;

use Disrupt\Common\DataTypes\DTInteger;
use Disrupt\Common\DataTypes\DTString;
use Disrupt\Common\Helper as DisruptHelper;

class DTReseller
{
     
    const COL_ID       = 'id';
    const COL_NAME     = 'name';
    const COL_DESC       = 'description';
    const COL_FISRT_NAME = 'first_name';
    const COL_LAST_NAME  = 'last_name';
    const COL_EMAIL      = 'email';
    const COL_PHONE      = 'phone';

    const TBL_NAME = 'reseller_';
    const NAME = 'reseller';

    protected $_oId;
    protected $_oName;
    protected $_oDescription;
    protected $_oFirstName;
    protected $_oLastName;
    protected $_oEmail;
    protected $_oPhone;
    
  


    /**
     * DTReseller constructor.
     * @param $_oId
     */
    public function __construct($aData)
    {
        $this->setBasicInfo($aData);
    }

    protected function setBasicInfo($aData)
    {
        $this->setResellerId(DisruptHelper::getKey($aData,self::COL_ID,self::TBL_NAME));
        $this->setName(DisruptHelper::getKey($aData,self::COL_NAME,self::TBL_NAME));
        $this->setDescription(DisruptHelper::getKey($aData,self::COL_DESC,self::TBL_NAME) );
        $this->setFirstName(DisruptHelper::getKey($aData,self::COL_FISRT_NAME,self::TBL_NAME) );
        $this->setLastName(DisruptHelper::getKey($aData,self::COL_LAST_NAME,self::TBL_NAME) );
        $this->setEmail(DisruptHelper::getKey($aData,self::COL_EMAIL,self::TBL_NAME) );
        $this->setPhone(DisruptHelper::getKey($aData,self::COL_PHONE,self::TBL_NAME) );
    }


    public function getResellerId()
    {
        return $this->_oId;
    }

  
    public function getName()
    {
        return $this->_oName;
    }

    public function getDescription()
    {
        return $this->_oDescription;
    }

    public function getFirstName()
    {
        return $this->_oFirstName;
    }

    public function getLastName()
    {
        return $this->_oLastName;
    }

    public function getEmail()
    {
        return $this->_oEmail;
    }

    public function getPhone()
    {
        return $this->_oPhone;
    }
  
    public function setResellerId($iId)
    {
        $this->_oId = new DTInteger($iId);
    }
    
    public function setName($sName)
    {
        $this->_oName = new DTString($sName);
    }

    public function setDescription($sName)
    {
        $this->_oDescription = new DTString($sName);
    }

    public function setFirstName($sName)
    {
        $this->_oFirstName = new DTString($sName);
    }

    public function setLastName($sName)
    {
        $this->_oLastName = new DTString($sName);
    }

    public function setEmail($sName)
    {
        $this->_oEmail = new DTString($sName);
    }
    
    public function setPhone($sName)
    {
        $this->_oPhone = new DTString($sName);
    }
   


}
