<?php

namespace Internship\Module\Controller;

class Router implements \Magento\Framework\App\RouterInterface
{

    protected $actionFactory;
    protected $_response;
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->_scopeConfig = $scopeConfig;
    }

    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $customerFrontendUrl = $this->_scopeConfig->getValue('customUrl/general/enter_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $identifier = trim($request->getPathInfo(), '/');

        if(strpos($identifier, $customerFrontendUrl) !== false) {
            $request->setModuleName('customrouter')-> //module name
            setControllerName('front')-> //controller name
            setActionName('index');
        } else {
            return false;
        }
        return $this->actionFactory->create(
            'Magento\Framework\App\Action\Forward',
            ['request' => $request]
        );
    }
}
