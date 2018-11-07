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


/**
 * Product description block
 *
 * @category   Codnitive
 * @package    Codnitive_SemanticStore
 * @module   Catalog
 */
class Codnitive_SemanticStore_Block_Catalog_Product_View_Description extends Mage_Catalog_Block_Product_View_Description
{
    
    protected $_config;
    
//    protected function _construct()
//    {
//        parent::_construct();
//        
//        $template = 'catalog/product/view/description.phtml';
//        $condition = $this->getConfig()->isActive() 
//                && $this->getConfig()->useForProduct() 
//                && $this->getConfig()->isProductPropActive('description');
//        if ($condition) {
//            $template = "codnitive/semanticstore/catalog/product/view/description/{$this->getConfig()->getMarkupFormat()}.phtml";
//        }
//        
//        $this->setTemplate($template);
//    }
    
    public function setConfig($model = 'semanticstore/config')
    {
        $this->_config = Mage::getModel($model);
    }
    
    public function getConfig()
    {
        if (is_null($this->_config)) {
            $this->setConfig();
        }
        return $this->_config;
    }
    
    public function addDescriptionProp()
    {
        $isSelected = $this->getConfig()->isProductPropActive('description');
        $section    = $this->getConfig()->getProductDescriptionPropSection();
        
        return $isSelected && ($section === 'full' || $section === 'both');
    }
    
}
