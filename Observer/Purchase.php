<?php
namespace Remmote\Facebookpixel\Observer;
/**
 * @extension   Remmote_Facebookpixel
 * @author      Remmote
 * @copyright   2017 - Remmote.com
 */
class Purchase implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    public $checkoutSession;
        
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        //Logging event
        $this->checkoutSession->setPixelPurchase(true);
    }
}