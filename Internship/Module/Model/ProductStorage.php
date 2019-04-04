<?php

namespace Internship\Module\Model;

use Magento\Catalog\Model\Product\Type;

class ProductStorage extends \Magento\Framework\Model\AbstractModel
{
    private $collectionFactory;

    /**
     * @var \Magento\CatalogInventory\Helper\Stock
     */
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
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @param string $request
     * @return array
     */
    public function findBySku(string $request)
    {
        $productCollection = $this->collectionFactory->create();

        $productCollection
                        ->addAttributeToSelect(['sku', 'name', 'qty', 'type_id'])
                        ->addFieldToFilter('sku', ['like' => '%' . $request . '%'])
                        ->addFieldToFilter('type_id', ['eq' => Type::TYPE_SIMPLE])
                        ->setCurPage(1)
                        ->setPageSize(12);

        $this->stockHelper->addInStockFilterToCollection($productCollection);

        $productCollection->load();

        $response = [];

        foreach($productCollection as $product) {
            $response[$product->getSKU()] = $product->getName();
        }

        return $response;
    }
}