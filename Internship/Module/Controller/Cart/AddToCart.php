<?php

namespace Internship\Module\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Setup\Exception;

class AddToCart extends Action
{

    /**
     * @var Magento\Checkout\Model\Cart
     */
    private $cart;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->cart = $cart;
        $this->productRepository = $productRepository;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $sku = $this->getRequest()->getParam('sku');
        $quantity = $this->getRequest()->getParam('quantity');

        if (!($sku && $quantity)) {
            $this->messageManager->addErrorMessage( __('Enter all values'));
            return $this->_redirect($this->_redirect->getRefererUrl());
        }

        try {
            $product = $this->productRepository->get($sku);
            $params = array(
                'product' => $product->getId(),
                'qty' => $quantity
            );
            $this->cart->addProduct($product, $params);
            $this->cart->save();
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addExceptionMessage($exception, __('No such product in database'));
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage($exception, __('Oops, something happened'));
        }
        return $this->_redirect($this->_redirect->getRefererUrl());
    }

}
