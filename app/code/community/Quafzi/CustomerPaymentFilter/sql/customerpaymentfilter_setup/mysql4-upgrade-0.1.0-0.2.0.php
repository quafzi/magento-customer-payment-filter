<?php
$installer = $this;
$installer->startSetup();

$setup = Mage::getModel('customer/entity_setup', 'core_setup');
$activeMethods = Mage::helper('payment')->getStoreMethods();
$activeMethodCodes = array();
foreach ($activeMethods as $method) {
    if ($method->isAvailable()) {
        $activeMethodCodes[] = $method->getCode();
    }
}

$setup->addAttribute('customer', 'allowed_payment_methods', array(
    'type'             => 'text',
    'input'            => 'multiselect',
    'label'            => 'Allowed payment methods',
    'global'           => 1,
    'visible'          => 1,
    'required'         => 0,
    'user_defined'     => 0,
    'default'          => '',
    'visible_on_front' => 0,
    'source'           => 'customerpaymentfilter/system_config_source_payment_methods',
));

Mage::getSingleton('eav/config')
    ->getAttribute('customer', 'allowed_payment_methods')
    ->setData('used_in_forms', array('adminhtml_customer'))
    ->save();

$customers = Mage::getModel('customer/customer')
    ->getCollection()
    ->addAttributeToFilter('denied_payment_methods', array('neq' => null));
foreach ($customers as $customer) {
    $denied  = explode(',', $customer->getDeniedPaymentMethods());
    $allowed = array_diff($activeMethodCodes, $denied);
    Mage::log($customer->getId() . ': ' . $customer->getDeniedPaymentMethods() . ' > ' . $allowed);
    $customer->setAllowedPaymentMethods(implode(',', $allowed))->save();
}

$setup->removeAttribute('customer', 'denied_payment_methods');

$installer->endSetup();
