<?php
/**
 * @extension   Remmote_Facebookpixel
 * @author      Remmote
 * @copyright   2017 - Remmote.com
 * @descripion  Helper
 */
namespace Remmote\Facebookpixel\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    // General Configuration
    const MODULE_ENABLED         = 'remmote_facebookpixel/general/enabled';
    const PIXEL_ID               = 'remmote_facebookpixel/general/pixel_id';
    const USE_PRODUCT_ID         = 'remmote_facebookpixel/general/use_product_id';
    const COOKIES_DISABLE_PIXEL  = 'remmote_facebookpixel/general/disable_pixel_if_no_cookies';
    const COOKIE_NAME            = 'remmote_facebookpixel/general/cookie_name';
    
    // Facebook Pixel Events
    const VIEW_CONTENT           = 'remmote_facebookpixel/events/view_content';
    const SEARCH                 = 'remmote_facebookpixel/events/search';
    const ADD_TO_CART            = 'remmote_facebookpixel/events/add_to_cart';
    const ADD_TO_WISHLIST        = 'remmote_facebookpixel/events/add_to_wishlist';
    const INITIATE_CHECKOUT      = 'remmote_facebookpixel/events/initiate_checkout';
    const ADD_PAYMENT_INFO       = 'remmote_facebookpixel/events/add_payment_info';
    const PURCHASE               = 'remmote_facebookpixel/events/purchase';
    const LEAD                   = 'remmote_facebookpixel/events/lead';
    const COMPLETE_REGISTRATION  = 'remmote_facebookpixel/events/complete_registration';


    public function __construct
    (
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;   
        parent::__construct($context);
    }

    /**
     * Get config value from database by store
     * @param  [type] $field
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function getConfigValue($field, $websiteId = null)
    {
        if ($websiteId) {
            return $this->scopeConfig->getValue(
                $field,
                \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITES,
                $websiteId
            );
        }
        return $this->scopeConfig->getValue($field);
    }

    /**
     * Check if module is enabled and Pixel ID is set
     * @param  [type] $websiteId
     * @return boolean
     * @author Remmote
     * @date   2017-07-18
     */
    public function isEnabled($websiteId = null)
    {
        return $this->getPixelId($websiteId) &&
               $this->getConfigValue(self::MODULE_ENABLED, $websiteId);
    }

    /**
     * Get Pixel ID
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function getPixelId($websiteId = null)
    {
        return $this->getConfigValue(self::PIXEL_ID, $websiteId);
    }

    /**
     * Use Product ID instead Product SKU
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function getUseProductId($websiteId = null)
    {
        return $this->getConfigValue(self::USE_PRODUCT_ID, $websiteId);
    }

    /**
     * Check if viewContent event is enabled
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function viewContentEnabled($websiteId = null)
    {
        return $this->getConfigValue(self::VIEW_CONTENT, $websiteId);
    }

    /**
     * Check if Search event is enabled
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function searchEnabled($websiteId = null)
    {
        return $this->getConfigValue(self::SEARCH, $websiteId);
    }

    /**
     * Check if AddToCart event is enabled
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function addToCartEnabled($websiteId = null)
    {
        return $this->getConfigValue(self::ADD_TO_CART, $websiteId);
    }

    /**
     * Check if AddToWhislist event is enabled
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function addToWishlistEnabled($websiteId = null)
    {
        return $this->getConfigValue(self::ADD_TO_WISHLIST, $websiteId);
    }

    /**
     * Check if InitiateCheckout event is enabled
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function initiateCheckoutEnabled($websiteId = null)
    {
        return $this->getConfigValue(self::INITIATE_CHECKOUT, $websiteId);
    }

    /**
     * Check if AddPaymentInfo event is enabled
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function addPaymentInfoEnabled($websiteId = null)
    {
        return $this->getConfigValue(self::PURCHASE, $websiteId);
    }

    /**
     * Check if Purchase event is enabled
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function purchaseEnabled($websiteId = null)
    {
        return $this->getConfigValue(self::PURCHASE, $websiteId);
    }

    /**
     * Check if Lead event is enabled
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function leadEnabled($websiteId = null)
    {
        return $this->getConfigValue(self::LEAD, $websiteId);
    }

    /**
     * Check if CompleteRegistration event is enabled
     * @param  [type] $websiteId
     * @return [type]
     * @author Remmote
     * @date   2017-07-18
     */
    public function completeRegistrationEnabled($websiteId = null)
    {
        return $this->getConfigValue(self::COMPLETE_REGISTRATION, $websiteId);
    }

    /**
     * Get Website Id
     * @return [type]
     * @author edudeleon
     * @date   2019-03-03
     */
    public function getWebsiteId()
    {
        return $this->_storeManager->getStore()->getWebsiteId();
    }

    /**
     * Check if option to check cookies is set, if so, check if cookie is present in user's browser
     * @param  [type]     $websiteId
     * @return [type]
     * @author edudeleon
     * @date   2019-07-02
     */
    public function renderScriptOnCookieCheck($websiteId = null)
    {
        $checkCookieOptionEnabled   = $this->getConfigValue(self::COOKIES_DISABLE_PIXEL, $websiteId);
        $cookieName                 = $this->getConfigValue(self::COOKIE_NAME, $websiteId);

        if($checkCookieOptionEnabled){
            if($cookieName){
                if(!empty($_COOKIE[$cookieName])){
                    return true;
                } else {
                    return false;
                }
            }
        } 

        return true;
    } 


}