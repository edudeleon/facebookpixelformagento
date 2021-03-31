<?php 
/**
 * @extension   Remmote_Facebookpixel
 * @author      Remmote
 * @copyright   2019 - Remmote.com
 * @descripion  Add to cart event tracking
 */
namespace Remmote\Facebookpixel\Controller\Trackevent;
 
use Magento\Framework\App\Action\Context;

class Addtocart extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Remmote\Facebookpixel\Helper\Data $helper, 
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {

        $this->_resultJsonFactory    = $resultJsonFactory;
        $this->_helper               = $helper;
        $this->_storeManager         = $storeManager;   
        $this->_checkoutSession      = $checkoutSession;
        $this->_productFactory       = $productFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result         = $this->_resultJsonFactory->create();
        $trackingData   = array('tracking_code' => '');

        //Check if event is enabled
        if ($this->_helper->addToCartEnabled($this->_helper->getWebsiteId())) {

            //Loading Product
            $productId  = $this->getRequest()->getParam('product_id');
            $product    = $this->_productFactory->create()->load($productId);
            if ($product) {
                
                $trackingData['tracking_code'] = "fbq('track', 'AddToCart');";
                
            }
        }

        return $result->setData($trackingData);
    }

}