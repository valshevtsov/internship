<?php

namespace Internship\Module\Plugin;


class CountWithDiscount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * Discount calculation object
     *
     * @var \Magento\SalesRule\Model\Validator
     */
    private $calculator;

    /**
     * Core event manager proxy
     *
     * @var \Magento\Framework\Event\ManagerInterface
     */
    private $eventManager = null;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\SalesRule\Model\Validator $validator,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->eventManager = $eventManager;
        $this->storeManager = $storeManager;
        $this->calculator = $validator;
        $this->priceCurrency = $priceCurrency;
        $this->scopeConfig = $scopeConfig;

    }

    public function afterCollect(
        \Magento\SalesRule\Model\Quote\Discount $eventDiscount,
        \Magento\SalesRule\Model\Quote\Discount $eventResult,
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $store = $this->storeManager->getStore($quote->getStoreId());

        $address = $shippingAssignment->getShipping()->getAddress();

        $items = $shippingAssignment->getItems();
        if (!count($items)) {
            return $eventDiscount;
        }

        $this->calculator->init($store->getWebsiteId(), $quote->getCustomerGroupId(), $quote->getCouponCode());
        $this->calculator->initTotals($items, $address);

        $this->calculator->prepareDescription($address);

        $saleDiscount = $this->getDiscountByTotalOrder($quote);
        $others = $total->getDiscountAmount();
        $sum = $saleDiscount + $others;

        $total->setDiscountDescription('Discount based on total order amount');
        $total->setDiscountAmount($sum);
        $total->addTotalAmount('salesDiscount', $saleDiscount);

        return $eventResult;
    }

    public function getDiscountByTotalOrder(\Magento\Quote\Model\Quote $quote)
    {
        $baseSubtotal = $quote->getBaseSubtotal();

        $serializedFrontendModelDiscounts = $this
            ->scopeConfig
            ->getValue(
                'discountArray/general/discount',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );

        if ($serializedFrontendModelDiscounts == null)
            return 0;

        $discounts = json_decode($serializedFrontendModelDiscounts);

        foreach ($discounts as $element) {
            $tempArray[$element->total_discount] = $element->total_amount;
        }

        arsort($tempArray);

        foreach ($tempArray as $disc=>$amount) {
            if ($baseSubtotal >= $amount) {
                return -($baseSubtotal*$disc/100);
            }
        }
    }
}
