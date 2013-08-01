<?php
/**
 * Quafzi_CustomerPaymentFilter_Model_Observer
 *
 * @category    Payment
 * @package     Quafzi_CustomerPaymentFilter
 * @author      Thomas Birke <tbirke@netextreme.de>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Quafzi_CustomerPaymentFilter_Model_Observer
{
    public function paymentMethodIsAllowed($observer)
    {
        $checkResult = $observer->getEvent()->getResult();
        $method      = $observer->getEvent()->getMethodInstance();
        $quote       = $observer->getEvent()->getQuote();

        if ($checkResult->isAvailable
            && $quote->getCustomer()
            && $quote->getCustomer()->getId() // customer exists
        ) {
            $deniedMethods = array_filter(explode(
                ',',
                $quote->getCustomer()->getDeniedPaymentMethods()
            ));
            if (in_array($method->getCode(), $deniedMethods))
            {
                $checkResult->isAvailable = false;
            }
        }
    }
}
