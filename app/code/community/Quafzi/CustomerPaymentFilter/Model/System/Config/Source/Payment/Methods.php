<?php
/**
 * Quafzi_CustomerPaymentFilter_Model_System_Config_Source_Payment_Methods
 *
 * @category    Payment
 * @package     Quafzi_CustomerPaymentFilter
 * @author      Thomas Birke <tbirke@netextreme.de>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Quafzi_CustomerPaymentFilter_Model_System_Config_Source_Payment_Methods
    extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Get payment methods
     *
     * @return array Methods
     */
    public function toOptionArray()
    {
        return Mage::helper('payment')
            ->getPaymentMethodList(true, true, true);
    }

    public function getAllOptions()
    {
        return $this->toOptionArray();
    }
}

