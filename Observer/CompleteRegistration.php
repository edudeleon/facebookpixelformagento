<?php
namespace Remmote\Facebookpixel\Observer;
/**
 * @extension   Remmote_Facebookpixel
 * @author      Remmote
 * @copyright   2017 - Remmote.com
 */
class CompleteRegistration implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    public $customerSession;
        
    public function __construct(
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->customerSession = $customerSession;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        //Logging event
        $this->customerSession->setPixelCompleteRegistration(true);
    }
}
