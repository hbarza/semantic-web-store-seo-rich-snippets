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
 * Currency model
 *
 * @category   Codnitive
 * @package    Codnitive_SemanticStore
 * @module     Directory
 */
class Codnitive_SemanticStore_Model_Directory_Currency extends Mage_Directory_Model_Currency
{
    
    protected $_config;
    
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
    
    public function formatPrecision($price, $precision, $options=array(), $includeContainer = true, $addBrackets = false)
    {
        $condition = !$this->getConfig()->isActive()
                || $this->getConfig()->getMarkupFormat() !== 'microdata'
                || $this->getConfig()->getMicrodataAddingMode() !== 'standard'
                || !$this->getConfig()->useForProduct()
                || !$this->getConfig()->isProductOffersActive();
        if ($condition) {
            return parent::formatPrecision($price, $precision, $options, $includeContainer, $addBrackets);
        }
        
        if (!isset($options['precision'])) {
            $options['precision'] = $precision;
        }
        $priceContainer = '<span ';
        if ($this->getConfig()->isProductOffersActive() && !$this->getConfig()->getCurrencyFactore()) {
            $priceContainer .= 'itemprop="price" ';
        }
        if ($includeContainer) {
            $priceContainer .= 'class="price"';
        }
        $priceContainer .= '>' . ($addBrackets ? '[' : '') . $this->formatTxt($price, $options) . ($addBrackets ? ']' : '') . '</span>';
        
        if ($factor = $this->getConfig()->getCurrencyFactore()) {
            $priceContainer .= '<meta itemprop="price" content="' . $price * $factor . '" />';
        }
        
        if ($this->getConfig()->addProductPriceCurrency()) {
            $currencyCode = $this->getConfig()->useStoreCurrency()
                    ? Mage::app()->getStore()->getCurrentCurrencyCode()
                    : Mage::app()->getBaseCurrencyCode();
            $priceContainer .= '<meta itemprop="priceCurrency" content="' . $currencyCode . '" />';
        }
        
        return $priceContainer;
    }
    
}
