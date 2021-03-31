<?php
/**
 * @extension   Remmote_Facebookpixel
 * @author      Remmote
 * @copyright   2017 - Remmote.com
 * @descripion  Code block
 */
namespace Remmote\Facebookpixel\Block;

class Code extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Remmote\Facebookpixel\Helper\Data
     */
    public $helper;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    public $request;

    /**
     * @var \Magento\Framework\Registry
     */
    public $registry;

    /**
     * @var \Magento\Catalog\Model\Session
     */
    public $catalogSession;

    /**
     * @var \Magento\Customer\Model\Session
     */
    public $customerSession;

    /**
     * @var \Magento\Newsletter\Model\Session
     */
    public $newsletterSession;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    public $checkoutSession;

    /**
     * @var \Magento\Sales\Model\Order
     */
    public $orderModel;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    public $productFactory;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    public $categoryFactory;

    public function __construct(
        \Magento\Catalog\Model\Session $catalogSession,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Newsletter\Model\Session $newsletterSession,
        \Magento\Framework\View\Element\Template\Context $context,
        \Remmote\Facebookpixel\Helper\Data $helper,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Model\Order $orderModel,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array $data = []
    ) {
        $this->catalogSession = $catalogSession;
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
        $this->newsletterSession = $newsletterSession;
        $this->helper = $helper;
        $this->request = $request;
        $this->registry = $registry;
        $this->orderModel = $orderModel;
        $this->productFactory = $productFactory;
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context, $data);
    }

    /**
     * Render script block
     *
     * @return string
     */
    protected function _toHtml()
    {
        // Check if pixel is enabled
        if (!$this->helper->isEnabled($this->_getWebsiteId())) {
            return '';
        }

        // Check if user allows cookies in case this option is enabled in the extension settings
        if (!$this->helper->renderScriptOnCookieCheck($this->_getWebsiteId())) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * Get store current section
     * @return [type]
     * @author Remmote.com
     * @date   2017-07-27
     */
    private function _getSection()
    {
        return $this->request->getFullActionName();
    }

    /**
     * Get current store currency
     * @return [type]
     * @author Remmote.com
     * @date   2017-07-27
     */
    private function _getStoreCurrency()
    {
        return $this->_storeManager->getStore()->getCurrentCurrency()->getCode();
    }

    /**
     * Get website id
     * @return [type]
     * @author Remmote.com
     * @date   2017-07-27
     */
    private function _getWebsiteId()
    {
        return $this->_storeManager->getStore()->getWebsiteId();
    }

    /**
     * Replace special chars
     * @param  [type] $string
     * @return [type]
     * @author Remmote.com
     * @date   2017-07-27
     */
    private function _replaceSpecialChars($string)
    {
        return str_replace("'", "\'", $string);
    }

    /**
     * Return Facebook Pixel Id
     * @return [type]
     * @author Remmote.com
     * @date   2017-07-27
     */
    public function getPixelId()
    {
        return $this->helper->getPixelId($this->_getWebsiteId());
    }

    /**
     * Return View Content event track
     * @return [type]
     * @author Remmote.com
     * @date   2017-07-27
     */
    public function getViewContentEvent()
    {
        $pageSection = $this->_getSection();

        //Check if event is enabled
        if ($this->helper->viewContentEnabled($this->_getWebsiteId()) && $pageSection == 'catalog_product_view') {
            $product = $this->registry->registry('current_product');
            if (!empty($product)) {
               return "fbq('track', 'ViewContent');";
            }
        }
    }

    /**
     * Return Search event track
     * @return [type]
     * @author Remmote.com
     * @date   2017-07-27
     */
    public function getSearchEvent()
    {
        $pageSection = $this->_getSection();

        //Check if event is enabled
        if ($this->helper->searchEnabled($this->_getWebsiteId()) &&
            ($pageSection == 'catalogsearch_result_index' || $pageSection == 'catalogsearch_advanced_result')) {
                return "fbq('track', 'Search');";
        }
    }

    /**
     * Return AddToWishlist event track
     * @return [type]
     * @author Remmote.com
     * @date   2017-07-27
     */
    public function getAddToWishlistEvent()
    {
        //Check if event is enabled
        if ($this->helper->addToWishlistEnabled($this->_getWebsiteId())) {

            $pixelEvent = $this->catalogSession->getPixelAddToWishlist();
            $productId  = $this->catalogSession->getPixelAddToWishlistProductId();

            if ($pixelEvent && $productId) {
                //Unset event
                $this->catalogSession->unsPixelAddToWishlist();
                $this->catalogSession->unsPixelAddToWishlistProductId();

                return "fbq('track', 'AddToWishlist');";   
            }
        }
    }

    /**
     * Return InitiateCheckout event track
     * @return [type]
     * @author Remmote.com
     * @date   2017-07-27
     */
    public function getInitiateCheckoutEvent()
    {
        $pageSection = $this->_getSection();

        //Check if event is enabled
        if ($this->helper->initiateCheckoutEnabled($this->_getWebsiteId()) &&
            ($pageSection == 'checkout_index_index' || $pageSection == 'checkout_onepage_index' ||
            $pageSection == 'onestepcheckout_index_index' || $pageSection == 'opc_index_index')) {

            return "fbq('track', 'InitiateCheckout');";

        }
    }

    /**
     * Return Purchase event track
     * @return [type]
     * @author Remmote.com
     * @date   2017-07-27
     */
    public function getPurchaseEvent()
    {
        //Check if event is enabled
        if ($this->helper->purchaseEnabled($this->_getWebsiteId()) && $this->checkoutSession->getPixelPurchase()) {

            $pageSection = $this->_getSection();

            //Unset event
            $this->checkoutSession->unsPixelPurchase();

            $orderId         = $this->checkoutSession->getLastRealOrderId();
            $order           = $this->orderModel->loadByIncrementId($orderId);
            $orderGrandTotal = number_format($order->getGrandTotal(), 2, '.', '');

            return "fbq('track', 'Purchase', {
                value: '". $orderGrandTotal ."',
                currency: '". $this->_getStoreCurrency() ."'
            });";
        }
    }

    /**
     * Return CompleteRegistration event track
     * @return [type]
     * @author Remmote.com
     * @date   2017-07-27
     */
    public function getCompleteRegistrationEvent()
    {
        //Check if event is enabled
        if ($this->helper->completeRegistrationEnabled($this->_getWebsiteId())
            && $this->customerSession->getPixelCompleteRegistration()) {
            //Unset event
            $this->customerSession->unsPixelCompleteRegistration();
            return "fbq('track', 'CompleteRegistration');";
        }
    }

}