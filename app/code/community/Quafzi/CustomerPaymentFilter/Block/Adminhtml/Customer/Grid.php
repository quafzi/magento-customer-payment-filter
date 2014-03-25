<?php
/**
 * Quafzi_CustomerPaymentFilter_Block_Adminhtml_Customer_Grid
 *
 * @category Customer
 * @package  Quafzi_CustomerPaymentFilter
 * @author   Thomas Birke <tbirke@netextreme.de>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Quafzi_CustomerPaymentFilter_Block_Adminhtml_Customer_Grid
    extends Mage_Adminhtml_Block_Customer_Grid
{
    /**
     * set collection
     *
     * @param Mage_Customer_Model_Resource_Customer_Collection $collection Collection
     * @return null
     */
    public function setCollection($collection)
    {
        $collection->addAttributeToSelect('allowed_payment_methods');
        return parent::setCollection($collection);
    }

    public function addColumn($name, $params)
    {
        if ($name == 'action')
        {
            $paymentMethods = Mage::helper('payment')->getPaymentMethodList(true);
            parent::addColumn('allowed_payment_methods',
                array(
                    'header'                    => Mage::helper('customerpaymentfilter') -> __('Allowed Payment Methods'),
                    'index'                     => 'allowed_payment_methods',
                    'width'                     => '150px',
                    'type'                      => 'options',
                    'renderer'                  => 'customerpaymentfilter/widget_grid_column_renderer_methods',
                    'options'                   => $paymentMethods,
                    'filter_condition_callback' => array($this, '_filterAllowedPaymentMethods'),
                )
            );
        }

        return parent::addColumn($name, $params);
    }

    protected function _filterAllowedPaymentMethods($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
     
        $this->getCollection()->addFieldToFilter('allowed_payment_methods', array('finset' => $value));
    }

    protected function _prepareMassaction()
    {
        parent::_prepareMassaction();

        $types = Mage::getModel('customerpaymentfilter/system_config_source_payment_methods')
            ->toOptionArray();
        unset($types['']);

        $this->getMassactionBlock()->addItem('change_allowed_payment_methods', array(
            'label'      => Mage::helper('customerpaymentfilter')->__('Change allowed payment methods'),
            'url'        => $this->getUrl('customerpaymentfilter/admin/massChange'),
            'additional' => array(
                'allowed_payment_methods' => array(
                    'name'   => 'allowed_payment_methods',
                    'type'   => 'multiselect',
                    'label'  => Mage::helper('customerpaymentfilter') -> __('Allowed Payment Methods'),
                    'values' => $types
                )
            )
        ));

        return $this;
    }
}
