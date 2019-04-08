<?php

namespace Internship\Module\Plugin;

use Magento\Checkout\Controller\Cart\Add;
use Magento\Framework\Exception\NoSuchEntityException;

class AddToCart
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
    }

    public function beforeExecute(\Magento\Checkout\Controller\Cart\Add $catcher)
    {
        try {
            $params = $catcher->getRequest()->getParams();
            $product = $this->productRepository->get($params['sku']);
            $catcher->getRequest()->setParams([
                'product' => $product->getId(),
                'qty' => $params['quantity'],
            ]);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

    }
}
