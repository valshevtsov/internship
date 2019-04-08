<?php

namespace Internship\Module\Model\Frontend\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;


class DiscountQuantity extends AbstractFieldArray
{
    protected function _prepareToRender()
    {
        $this->addColumn('total_amount', ['label' => __('Total Order Amount in $')]);
        $this->addColumn('total_discount', ['label' => __('Total Discount in %')]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('New custom discount based on order amount');
    }
}
