<?php

namespace Internship\Module\Controller\Search;

class Autocomplete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var Internship\Module\Model\ProductStorage
     */
    private $productModel;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Internship\Module\Model\ProductStorage $productModel

    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productModel = $productModel;
        return parent::__construct($context);
    }

    public function execute()
    {
        $summary = $this->resultJsonFactory->create();
        $summary->setData($this->productModel->findBySku($this->getRequest()->getParam('sku')));

        return $summary;
    }
}
