<?php

namespace Internship\Module\Plugin;

use Magento\Checkout\Controller\Cart\Add;

class AddToCart
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

    public function beforeExecute(\Magento\Checkout\Controller\Cart\Add $catcher)
    {
        $params = $catcher->getRequest()->getParams();
        $product = $this->productRepository->get($params['sku']);
        $catcher->getRequest()->setParams([
            'product' => $product->getId(),
            'qty' => $params['quantity'],
        ]);
    }
}
