<?php

namespace Internship\Module\Plugin;


class Repricing extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function beforeCollect(
        \Magento\SalesRule\Model\Quote\Discount $eventDiscount,
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $this->setNewPrices($quote);
    }

    public function setNewPrices(\Magento\Quote\Model\Quote $quote)
    {
        $wholesaleDiscount = 0;
        $items = $quote->getItems();
        foreach ($items as $item) {
            $product = $this->productRepository->get($item['sku']);
            $search = $product->getCustomAttribute('wholesale');
            if ($search) {
                $specPrice = $product->getCustomAttribute('wholesale_price')->getValue();
                $item->setCustomPrice($specPrice);
                $item->setOriginalCustomPrice($specPrice);
                $item->getProduct()->setIsSuperMode(true);
            }
        }
    }
}
