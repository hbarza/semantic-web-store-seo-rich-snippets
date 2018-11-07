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

class Codnitive_SemanticStore_Model_System_Config_Backend_Cert extends Mage_Core_Model_Config_Data
{
    
    protected function _beforeSave()
    {
        $value = $this->getValue();
        $fieldConf = $this->getFieldConfig();
        
        if ($value) {
            try {
                $nameSpace = Codnitive_SemanticStore_Model_Config::getNamespace();

                $sernum = Mage::getStoreConfig($nameSpace . 'sernum');
                $regcod = Mage::getStoreConfig($nameSpace . 'regcod');
                $ownnam = Mage::getStoreConfig($nameSpace . 'ownnam');
                $ownmai = Mage::getStoreConfig($nameSpace . 'ownmai');

                $condition = empty($sernum) || !$sernum || empty($regcod) || !$regcod
                    || empty($ownnam) || !$ownnam || empty($ownmai) || !$ownmai;

                if ($condition) {
                    $err = Mage::helper('semanticstore')->__('%s extension not registered.', 
                            Mage::helper('semanticstore')->__(Codnitive_SemanticStore_Model_Config::EXTENSION_NAME));
                    Mage::throwException($err);
                }
                
                Mage::getConfig()->saveConfig($nameSpace.'frtrn', 0)->reinit();
                Mage::app()->reinitStores();
                $crypt = Varien_Crypt::factory()->init('3ee2a23ba72ce85081fae961d2e51b1b');
                $inf = array(
                    'sn' => base64_encode($crypt->encrypt(Mage::helper('core')->decrypt((string)$sernum))),
                    'rc' => base64_encode($crypt->encrypt(Mage::helper('core')->decrypt((string)$regcod))),
                    'on' => base64_encode($crypt->encrypt((string)$ownnam)),
                    'om' => base64_encode($crypt->encrypt((string)$ownmai)),
                    'bu' => base64_encode($crypt->encrypt((string)Mage::getStoreConfig('web/unsecure/base_url'))),
                    'en' => base64_encode($crypt->encrypt((string)Codnitive_SemanticStore_Model_Config::EXTENSION_NAME)),
                    'ev' => base64_encode($crypt->encrypt((string)Codnitive_SemanticStore_Model_Config::EXTENSION_VERSION)),
                    'es' => base64_encode($crypt->encrypt((string)$value)),
                );

                try {
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, Mage::helper('semanticstore')->getConUrl());
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $inf);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $data = curl_exec($ch);
                    curl_close($ch);
                }
                catch (Exception $e) {
                    $data = false;
                }

                if (false == $data) {
                    $err = Mage::helper('semanticstore')->__('%s save error. Please try again later.', 
                            Mage::helper('semanticstore')->__(Codnitive_SemanticStore_Model_Config::EXTENSION_NAME));
                    Mage::throwException($err);
                }
                if ('1' !== $data) {
                    $err = Mage::helper('semanticstore')->__($fieldConf->label)
                        . Mage::helper('semanticstore')->__(' or registration information for')
                        . Mage::helper('semanticstore')->__(' %s', Mage::helper('semanticstore')->__(Codnitive_SemanticStore_Model_Config::EXTENSION_NAME))
                        . Mage::helper('semanticstore')->__(' is not valid. Please check them or %s', Mage::helper('semanticstore')->__('contact us.'));
                    Mage::throwException($err);
                }
            }
            catch (Exception $e) {
                Mage::throwException($e->getMessage());
                return $this;
            }
        }

        return $this;
    }
}
