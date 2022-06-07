<?php

namespace Webjump\ConfigLocaleAndLanguage\Setup\Patch\Data;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InstallUSD implements DataPatchInterface
{
    public const CURRENCY_INSTALLED_PATH = "system/currency/installed";

    public const BRLUSD = "BRL,USD";

    private $moduleDataSetup;
    private $writer;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        WriterInterface $writer
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->writer = $writer;
    }

    public static function getDependencies()
    {
        return [
        ];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->writer->save(
            self::CURRENCY_INSTALLED_PATH,
            self::BRLUSD
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [
        ];
    }
}
