<?php 
/**
 * @extension   Remmote_Facebookpixel
 * @author      Remmote
 * @copyright   2019 - Remmote.com
 * @descripion  Tracks Lead event
 */
namespace Remmote\Facebookpixel\Controller\Trackevent;
 
use Magento\Framework\App\Action\Context;

class Lead extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Remmote\Facebookpixel\Helper\Data $helper
    ) {

        $this->_resultJsonFactory   = $resultJsonFactory;
        $this->_helper              = $helper;
        parent::__construct($context);
    }

    public function execute()
    {
        $result         = $this->_resultJsonFactory->create();
        $trackingData   = array('tracking_code' => '');

        //Check if subscription is enabled
        if ($this->_helper->leadEnabled($this->_helper->getWebsiteId())) {
            $trackingData['tracking_code'] = "fbq('track', 'Lead');";
        }

        return $result->setData($trackingData);
    }    
}