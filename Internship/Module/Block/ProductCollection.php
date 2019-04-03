<?php

namespace Internship\Module\Block;

class ProductCollection extends \Magento\Framework\View\Element\Template
{
    protected $_productCollectionFactory;
    protected $_productVisibility;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $productVisibility,
        array $data = []
    )
    {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_productVisibility = $productVisibility;
        parent::__construct($context, $data);
    }

    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();

       // $collection->addFieldToFilter('sku', ['like' => '%-MB%']);
        $collection->addAttributeToSelect('sku');
        $collection->setPageSize(10); // fetching only 10 products
        return $collection;
    }
}
