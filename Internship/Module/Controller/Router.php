<?php

namespace Internship\Module\Controller;

class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    private $actionFactory;

    /**
     * @var \Magento\Framework\App\ResponseInterface
     */
    private $_response;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $_scopeConfig;

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool|\Magento\Framework\App\ActionInterface
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $customFrontendUrl = $this->
                            _scopeConfig->
                            getValue(
                                'customUrl/general/enter_url',
                                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                            );

        $identifier = trim($request->getPathInfo(), '/');

        if(strcmp($identifier, $customFrontendUrl) == 0) {
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
