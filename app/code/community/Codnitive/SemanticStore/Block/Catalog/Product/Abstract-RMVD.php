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
 * Catalog Product Abstract Block
 *
 * @category   Codnitive
 * @package    Codnitive_SemanticStore
 * @module     Catalog
 */
class Codnitive_SemanticStore_Block_Catalog_Product_Abstract extends Mage_Catalog_Block_Product_Abstract
{
    
    protected $_config;
    
    protected function _construct()
    {
        parent::_construct();
        var_dump('here');
        exit;
        if ($this->getConfig()->isActive() && $this->getConfig()->isProductOffersActive()) {
            $this->_priceBlockDefaultTemplate = 'codnitive/semanticstore/catalog/product/price/microdata.phtml';
        }
    }
    
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
    
}
