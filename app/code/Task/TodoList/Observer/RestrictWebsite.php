<?php
/**
 * @package   Task\TodoList
 * @author    Anton Dudenkoff <anton@dudenkoff.com>
 * @copyright 2020 Anton Dudenkoff
 */
namespace Task\TodoList\Observer;

use Magento\Customer\Model\Context;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\Response\Http;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\UrlFactory;

/**
 * Class RestrictWebsite
 */
class RestrictWebsite implements ObserverInterface
{
    /**
     * @var Http
     */
    protected $response;

    /**
     * @var UrlFactory
     */
    protected $urlFactory;

    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $context;

    /**
     * @var ActionFlag
     */
    protected $actionFlag;

    /**
     * @param ManagerInterface $eventManager
     * @param Http $response
     * @param UrlFactory $urlFactory
     * @param \Magento\Framework\App\Http\Context $context
     * @param ActionFlag $actionFlag
     */
    public function __construct(
        ManagerInterface $eventManager,
        Http $response,
        UrlFactory $urlFactory,
        \Magento\Framework\App\Http\Context $context,
        ActionFlag $actionFlag
    ) {
        $this->response = $response;
        $this->urlFactory = $urlFactory;
        $this->context = $context;
        $this->actionFlag = $actionFlag;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $allowedRoutes = [
            'customer_account_login',
            'customer_account_loginpost',
            'customer_account_create',
            'customer_account_createpost',
            'customer_account_logoutsuccess',
            'customer_account_confirm',
            'customer_account_confirmation',
            'customer_account_forgotpassword',
            'customer_account_forgotpasswordpost',
            'customer_account_createpassword',
            'customer_account_resetpasswordpost',
            'customer_section_load'
        ];

        $request = $observer->getEvent()->getRequest();
        $isCustomerLoggedIn = $this->context->getValue(Context::CONTEXT_AUTH);
        $actionFullName = strtolower($request->getFullActionName());

        if (!$isCustomerLoggedIn && !in_array($actionFullName, $allowedRoutes)) {
            $this->response->setRedirect($this->urlFactory->create()->getUrl('customer/account/login'));
        } elseif ($isCustomerLoggedIn && $actionFullName == 'customer_account_index') {
            $this->response->setRedirect($this->urlFactory->create()->getUrl('todo'));
        }
    }
}
