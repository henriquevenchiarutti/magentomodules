<?php

namespace Webjump\ConfigLocaleAndLanguage\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManagerInterface;
use Webjump\ConfigLocaleAndLanguage\Model\LocaleAndLanguageWriter;

class ConfigPartyUsLocale implements DataPatchInterface
{
    private $localeWriter;
    private $storeManager;

    public function __construct(
        StoreManagerInterface $storeManager,
        LocaleAndLanguageWriter $localeWriter
    ) {
        $this->storeManager = $storeManager;
        $this->localeWriter = $localeWriter;
    }

    public static function getDependencies()
    {
        return [
        ];
    }

    public function apply()
    {
        $storeId = $this->storeManager
            ->getStore("party_store_view_us")
            ->getId();

        $this->localeWriter->setLocaleAndLanguageUs($storeId);
    }

    public function getAliases()
    {
        return [
        ];
    }
}
