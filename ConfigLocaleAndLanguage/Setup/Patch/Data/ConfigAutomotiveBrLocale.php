<?php

namespace Webjump\ConfigLocaleAndLanguage\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\StoreManagerInterface;
use Webjump\ConfigLocaleAndLanguage\Model\LocaleAndLanguageWriter;

class ConfigAutomotiveBrLocale implements DataPatchInterface
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
            ->getStore("automotivo_store_view_pt")
            ->getId();

        $this->localeWriter->setLocaleAndLanguageBr($storeId);
    }

    public function getAliases()
    {
        return [
        ];
    }
}
