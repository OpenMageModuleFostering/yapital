<?php

class Codex_Yapital_Model_Datatype_ISOLanguage extends Varien_Object
{

    protected $_defaultLanguage = 'en_GB';

    protected function _construct()
    {
        parent::_construct();

        $this->setData(
            array(
                'de_DE' => 'de',
                'en_GB' => 'en',
                'en_US' => 'en',
            )
        );
    }

    public function getYapitalLanguage()
    {
        $language = $this->getData($this->getStoreLanguage());
        if (!$language)
        {
            $language = $this->getDefault();
        }

        return $language;
    }

    public function getStoreLanguage()
    {
        return Mage::app()->getLocale()->getLocaleCode();
    }

    public function getDefault()
    {
        return $this->getData($this->_defaultLanguage);
    }
} 
