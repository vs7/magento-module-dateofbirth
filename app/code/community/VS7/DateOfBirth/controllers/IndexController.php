<?php

class VS7_DateOfBirth_IndexController extends Mage_Core_Controller_Front_Action
{
    private $_email;
    private $_customer;

    private function _registerVars()
    {
        $this->_email = Mage::app()->getRequest()->getParam('email');
        if (empty($this->_email)) {
            $this->_email = Mage::app()->getRequest()->getParam('vs7_dateofbirth-email');
        }
        preg_match('/(^[^\?]+)\??/', $this->_email, $matches);
        $this->_email = $matches[1];
        if (Zend_Validate::is($this->_email, 'EmailAddress')) {
            Mage::register('vs7_dateofbirth_email', $this->_email);
            $this->_customer = Mage::getModel('customer/customer');
            $this->_customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
            $this->_customer->loadByEmail($this->_email);
            if ($this->_customer->getId() == null) {
                $this->_redirect('customer/account/create');
                return $this;
            }
            Mage::register('vs7_dateofbirth_customer', $this->_customer);
            return $this;
        }
        $this->_redirect('customer/account/create');
        return $this;
    }

    public function indexAction()
    {
        $this->_registerVars();
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {
        $this->_registerVars();
        $day = Mage::app()->getRequest()->getParam('day');
        $month = Mage::app()->getRequest()->getParam('month');
        $year = Mage::app()->getRequest()->getParam('year');
        $date = strtotime($year . '-' . $month . '-' . $day);
        if (!empty($this->_customer)) {
            $firstname = Mage::app()->getRequest()->getParam('vs7_dateofbirth-firstname');
            if (!empty($firstname)) {
                $this->_customer->setFirstname($firstname);
            }
            $this->_customer->setDob(date('Y-m-d', $date));
            $this->_customer->save();
        }
        $this->loadLayout();
        $this->renderLayout();
    }
}