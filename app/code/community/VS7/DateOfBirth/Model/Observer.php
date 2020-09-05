<?php

class VS7_DateOfBirth_Model_Observer
{
    public function replaceTemplate($observer)
    {
        if ($observer->getBlock() instanceof Mage_Customer_Block_Widget_Dob) {
            $observer->getBlock()->setTemplate('vs7_dateofbirth/widget/dob.phtml');
        }
    }
}