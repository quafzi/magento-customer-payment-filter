<?php
$installer = $this;
$installer->startSetup();
 
$setup = Mage::getModel('customer/entity_setup', 'core_setup');
 
$setup->addAttribute('customer', 'denied_payment_methods', array(
    'type'             => 'text',
    'input'            => 'multiselect',
    'label'            => 'Denied payment methods',
    'global'           => 1,
    'visible'          => 1,
    'required'         => 0,
    'user_defined'     => 0,
    'default'          => '',
    'visible_on_front' => 0,
    'source'           => 'customerpaymentfilter/system_config_source_payment_methods',
));

Mage::getSingleton('eav/config')
    ->getAttribute('customer', 'denied_payment_methods')
    ->setData('used_in_forms', array('adminhtml_customer'))
    ->save();
 
$installer->endSetup();
