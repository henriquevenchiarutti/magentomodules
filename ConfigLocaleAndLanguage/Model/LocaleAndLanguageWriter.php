<?php

namespace Webjump\ConfigLocaleAndLanguage\Model;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class LocaleAndLanguageWriter
{
    public const CURRENCY_DEFAULT_PATH = "currency/options/default";
    public const CURRENCY_ALLOW_PATH = "currency/options/allow";
    public const CURRENCY_BASE_PATH = "currency/options/base";
    public const LOCALE_CODE_PATH = "general/locale/code";
    public const LOCALE_WEIGHT_PATH = "general/locale/weight_unit";
    public const LOCALE_TIMEZONE_PATH = "general/locale/timezone";
    public const COUNTRY_DEFAULT_PATH = "general/country/default";

    public const COUNTRY = "BR";
    public const CURRENCY = "BRL";
    public const LOCALE_CODE = "pt_BR";
    public const WEIGHT_UNIT = "kgs";
    public const TIMEZONE = "America/Sao_Paulo";

    public const COUNTRY_US = "US";
    public const CURRENCY_US = "USD";
    public const LOCALE_CODE_US = "en_US";
    public const WEIGHT_UNIT_US = "lbs";
    public const TIMEZONE_US = "America/Los_Angeles";

    public const SCOPE = "stores";

    private $moduleDataSetup;
    private $writer;

    public function __construct(
        WriterInterface $writer,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->writer = $writer;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function setLocaleAndLanguageBr(int $storeId)
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->writer->save(
            self::CURRENCY_ALLOW_PATH,
            self::CURRENCY,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::CURRENCY_DEFAULT_PATH,
            self::CURRENCY,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::CURRENCY_BASE_PATH,
            self::CURRENCY,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::LOCALE_CODE_PATH,
            self::LOCALE_CODE,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::LOCALE_WEIGHT_PATH,
            self::WEIGHT_UNIT,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::LOCALE_TIMEZONE_PATH,
            self::TIMEZONE,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::COUNTRY_DEFAULT_PATH,
            self::COUNTRY,
            self::SCOPE,
            $storeId
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function setLocaleAndLanguageUs(int $storeId)
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->writer->save(
            self::CURRENCY_ALLOW_PATH,
            self::CURRENCY_US,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::CURRENCY_DEFAULT_PATH,
            self::CURRENCY_US,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::CURRENCY_BASE_PATH,
            self::CURRENCY_US,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::LOCALE_CODE_PATH,
            self::LOCALE_CODE_US,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::LOCALE_WEIGHT_PATH,
            self::WEIGHT_UNIT_US,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::LOCALE_TIMEZONE_PATH,
            self::TIMEZONE_US,
            self::SCOPE,
            $storeId
        );

        $this->writer->save(
            self::COUNTRY_DEFAULT_PATH,
            self::COUNTRY_US,
            self::SCOPE,
            $storeId
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
