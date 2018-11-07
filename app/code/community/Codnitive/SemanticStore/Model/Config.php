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

class Codnitive_SemanticStore_Model_Config
{
    
    const PATH_NAMESPACE      = 'codnitivesemantic';
    const EXTENSION_NAMESPACE = 'semanticstore';
    const PRODUCT_NAMESPACE   = 'semanticproduct';
    
    const EXTENSION_NAME    = 'Semantic Store';
    const EXTENSION_VERSION = '1.0.00';
    const EXTENSION_EDITION = 'Basic';

    public static function getNamespace()
    {
        return self::PATH_NAMESPACE . '/' . self::EXTENSION_NAMESPACE . '/';
    }

    public static function getProductNamespace()
    {
        return self::PATH_NAMESPACE . '/' . self::PRODUCT_NAMESPACE . '/';
    }
    
    public function getExtensionName()
    {
        return self::EXTENSION_NAME;
    }
    
    public function getExtensionVersion()
    {
        return self::EXTENSION_VERSION;
    }
    
    public function getExtensionEdition()
    {
        return self::EXTENSION_EDITION;
    }

    public function isActive()
    {
        return Mage::getStoreConfigFlag(self::getNamespace() . 'active');
    }
    
    public function getMarkupFormat()
    {
        return Mage::getStoreConfig(self::getNamespace() . 'markup_format');
    }
    
    public function getMicrodataAddingMode()
    {
        return Mage::getStoreConfig(self::getNamespace() . 'microdata_adding_mode');
    }
    
/* Semantic Products section ================================================ */
    public function useForProduct()
    {
        if (!$this->isActive()) {
            return false;
        }
        return Mage::getStoreConfigFlag(self::getProductNamespace() . 'active');
    }

    public function getProductActiveProperties($array = true)
    {
        $properties = Mage::getStoreConfig(self::getProductNamespace() . 'default_properties');
        return $array ? explode(',', $properties) : $properties;
    }
    
    public function isProductPropActive($prop)
    {
        return in_array($prop, $this->getProductActiveProperties());
    }
    
    public function getProductDescriptionPropSection()
    {
        return Mage::getStoreConfig(self::getProductNamespace() . 'description');
    }
    
    public function getProductIdAttributeCode()
    {
        return Mage::getStoreConfig(self::getProductNamespace() . 'productid_attribute');
    }
    
    public function getProductIdAttributeCodeAddLabel()
    {
        return Mage::getStoreConfigFlag(self::getProductNamespace() . 'productid_attribute_add_label');
    }
    
    public function getProductWeightUnitCode()
    {
        return Mage::getStoreConfig(self::getProductNamespace() . 'product_weight_unitcode');
    }
    
/* Prices and Offers  ====================== */
    public function isProductOffersActive()
    {
        if (!$this->useForProduct()) {
            return false;
        }
        return Mage::getStoreConfigFlag(self::getProductNamespace() . 'offers_active');
    }
    
    public function addProductAvailibility()
    {
        return Mage::getStoreConfigFlag(self::getProductNamespace() . 'add_availibility');
    }
    
    public function addProductPriceCurrency()
    {
        return Mage::getStoreConfigFlag(self::getProductNamespace() . 'add_price_currency');
    }
    
    public function getCurrencyFactore()
    {
        if (!$this->isProductOffersActive()) {
            return false;
        }
        
        $factor = Mage::getStoreConfig(self::getProductNamespace() . 'currency_factor');
        if (!$factor || empty($factor)) {
            return false;
        }
        
        return floatval($factor);
    }
    
    public function useStoreCurrency()
    {
        return Mage::getStoreConfigFlag(self::getProductNamespace() . 'use_store_currency');
    }
    
/* Product Aggregate Rating ================= */
    public function isProductRatingActive()
    {
        if (!$this->useForProduct()) {
            return false;
        }
        return Mage::getStoreConfigFlag(self::getProductNamespace() . 'rating_active');
    }
    
    public function addProductRatingCount()
    {
        return Mage::getStoreConfigFlag(self::getProductNamespace() . 'add_rating_count');
    }
    
    public function addProductItemReviewed()
    {
        return Mage::getStoreConfigFlag(self::getProductNamespace() . 'add_item_reviewed');
    }
    
}
