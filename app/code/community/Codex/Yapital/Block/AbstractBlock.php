<?php

/**
 * Class Codex_Yapital_Block_AbstractBlock.
 *
 * @category   Yapital
 * @package    Codex_Yapital_Block
 */
abstract class Codex_Yapital_Block_AbstractBlock extends Mage_Core_Block_Template
{

    /**
     * @return Codex_Yapital_Model_Config
     */
    function _getConfig()
    {
        return $config = Mage::getSingleton('yapital/config');
    }
}
