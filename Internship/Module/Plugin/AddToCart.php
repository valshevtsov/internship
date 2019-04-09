<?php

namespace Internship\Module\Plugin;


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

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
        $this->scopeConfig = $scopeConfig;
    }

    public function beforeExecute(\Magento\Checkout\Controller\Cart\Add $catcher)
    {
        if ($catcher->getRequest()->getParam('myController')) {
            try {
                $params = $catcher->getRequest()->getParams();
                $product = $this->productRepository->get($params['sku']);
                $catcher->getRequest()->setParams([
                    'product' => $product->getId(),
                    'qty' => $params['quantity'],
                ]);
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
            }
        }

    }
}
