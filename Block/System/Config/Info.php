<?php
/**
 * @extension   Remmote_Facebookpixel
 * @author      Remmote
 * @copyright   2017 - Remmote.com
 * @descripion  Header extension info block
 */
namespace Remmote\Facebookpixel\Block\System\Config;

class Info extends \Magento\Config\Block\System\Config\Form\Fieldset
{
    /**
     * Override render function
     * @param AbstractElement $element
     * @return string
     * @author Remmote
     * @date   2017-07-18
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return
        '<fieldset style="border: 1px solid #ccc;">'.
            '<table>'.
                '<tr>'.
                    '<td style="padding:0;">'.
                        '<h2 style="margin-bottom: 1em;">Hey '.$this->_authSession->getUser()->getFirstname().
                            ', thanks for using our extension!</h2>'.
                        '<p style="margin: 0;">For additional information about the configuration of our extensions and general troubleshooting, you can refer to our user manuals in the following link <a href="https://www.remmote.com/user-manuals/" target="_blank">Remmote extensions - User Manuals</a>. For additional questions, write us at <a href="mailto:info@remmote.com">info@remmote.com</a>. We will reply as soon as possible.
                        </p>'.
                    '</td>'.
                '</tr>'.
            '</table>'.
        '</fieldset>';
    }

}
