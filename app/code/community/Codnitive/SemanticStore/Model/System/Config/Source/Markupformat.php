<?php
/**
 * CODNITIVE
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE_EULA.html.
 * It is also available through the world-wide-web at this URL:
 * http://www.codnitive.com/en/terms-of-service-softwares/
 * http://www.codnitive.com/fa/terms-of-service-softwares/
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade to newer
 * versions in the future.
 *
 * @category   Codnitive
 * @package    Codnitive_SemanticStore
 * @author     Hassan Barza <support@codnitive.com>
 * @copyright  Copyright (c) 2012 CODNITIVE Co. (http://www.codnitive.com)
 * @license    http://www.codnitive.com/en/terms-of-service-softwares/ End User License Agreement (EULA 1.0)
 */

class Codnitive_SemanticStore_Model_System_Config_Source_Markupformat extends Mage_Core_Model_Config_Data
{

    protected $_options = array(
        'microdata'    => 'Microdata',
        'microformats' => 'Microformats',
        'rdfa'         => 'RDFa'
    );

    public function toOptionArray()
    {
        $options = array();
        foreach ($this->_options as $key => $val) {
            $options[] = array(
                'value' => $key,
                'label' => Mage::helper('semanticstore')->__($val)
            );
        }
        return $options;
    }

}
