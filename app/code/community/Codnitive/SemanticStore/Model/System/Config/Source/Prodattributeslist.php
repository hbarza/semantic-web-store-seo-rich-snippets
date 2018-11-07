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

class Codnitive_SemanticStore_Model_System_Config_Source_Prodattributeslist extends Mage_Core_Model_Config_Data
{

    protected $_invalidTypes = array(
        'gallery', 'media_image', 
        'multiselect',
    );
    
    protected $_validAttrsInNullType = array(
        'links_title', 'samples_title', 'shipment_type'
    );
    
    protected $_invalidAttrsCodes = array(
        'category_ids'
    );

    public function toOptionArray()
    {
        $entityTypeId = Mage::getModel('eav/entity')
                ->setType('catalog_product')
                ->getTypeId();
        
        $attributes = Mage::getModel('eav/entity_attribute')
                ->getCollection()
                ->setEntityTypeFilter($entityTypeId)
                ->load();
        
        $attrs = array('please_select' => '-- Please Select --');
        
        foreach ($attributes  as $attribute) {
            $attrCode      = $attribute->getAttributeCode();
            $frontendInput = $attribute->getFrontendInput();
            
            $condition1 = in_array($frontendInput, $this->_invalidTypes)
                    || (is_null($frontendInput)
                    && !in_array($attrCode, $this->_validAttrsInNullType));
            
            $condition2 = preg_match('/_text_base$/', $attrCode) 
                    || in_array($attrCode, $this->_invalidAttrsCodes);
            
            if ($condition1 || $condition2) {
                continue;
            }
            
            $attrName = $attribute->getFrontendLabel();
            $label    = empty($attrName) ? $attrCode : $attrName;
            
            $attrs[$attribute->getAttributeId()] = array(
                'value' => $attrCode,
                'label' => Mage::helper('semanticstore')->__($label)
            );
        }
        
        return $attrs;
    }

}
