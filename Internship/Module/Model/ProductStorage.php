<?php

class ProductStorage extends \Magento\Framework\Model\AbstractModel
{
    private $collectionFactory;
    private $stockHelper;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\CatalogInventory\Helper\Stock $stockHelper,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->stockHelper = $stockHelper;
        $this->collectionFactory = $this->collectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function findbySku(string $query)
    {
        $productCollection = $this->collectionFactory
    }
}