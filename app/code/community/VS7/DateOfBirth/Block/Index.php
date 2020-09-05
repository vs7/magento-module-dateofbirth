<?php

class VS7_DateOfBirth_Block_Index extends Mage_Core_Block_Template
{
    private $_customer;
    private $_email;

    public function _construct()
    {
        $this->_customer = Mage::registry('vs7_dateofbirth_customer');
        $this->_email = Mage::registry('vs7_dateofbirth_email');
        return parent::_construct();
    }

    public function getFirstname()
    {
        if (empty($this->_customer)) return;
        return $this->_customer->getFirstname();
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function getDateOfBirth()
    {
        if (empty($this->_customer)) return;
        $dob = $this->_customer->getDob();
        if (empty($dob)) {
            return false;
        }
        return date('Y-m-d', strtotime($dob));
    }
}