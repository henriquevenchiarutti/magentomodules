<?php

namespace Webjump\ConfigLocaleAndLanguage\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Webjump\ConfigLocaleAndLanguage\Model\LocaleAndLanguageWriter;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class LocaleAndLanguageWriterTest extends TestCase
{
    public function setUp(): void
    {
        $this->writerInterfaceMock = $this->createMock(WriterInterface::class);
        $this->moduleDataSetupMock = $this->createMock(ModuleDataSetupInterface::class);
        $this->adapterInterfaceMock = $this->createMock(AdapterInterface::class);

        $this->localeWriter = new LocaleAndLanguageWriter(
            $this->writerInterfaceMock,
            $this->moduleDataSetupMock
        );
    }

    public function testSetLocaleAndLanguageBr()
    {
        $storeId = 1;

        $this->moduleDataSetupMock
        ->expects($this->exactly(2))
        ->method("getConnection")
        ->willReturn($this->adapterInterfaceMock);

        $this->adapterInterfaceMock->expects($this->once())
        ->method("startSetup")
        ->willReturnSelf();

        $this->writerInterfaceMock
        ->expects($this->exactly(7))
        ->method("save")
        ->withConsecutive(
            [
            LocaleAndLanguageWriter::CURRENCY_ALLOW_PATH,
            LocaleAndLanguageWriter::CURRENCY,
            LocaleAndLanguageWriter::SCOPE,
            $storeId
            ],
            [
                LocaleAndLanguageWriter::CURRENCY_DEFAULT_PATH,
                LocaleAndLanguageWriter::CURRENCY,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
            [
                LocaleAndLanguageWriter::CURRENCY_BASE_PATH,
                LocaleAndLanguageWriter::CURRENCY,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
            [
                LocaleAndLanguageWriter::LOCALE_CODE_PATH,
                LocaleAndLanguageWriter::LOCALE_CODE,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
            [
                LocaleAndLanguageWriter::LOCALE_WEIGHT_PATH,
                LocaleAndLanguageWriter::WEIGHT_UNIT,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
            [
                LocaleAndLanguageWriter::LOCALE_TIMEZONE_PATH,
                LocaleAndLanguageWriter::TIMEZONE,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
            [
                LocaleAndLanguageWriter::COUNTRY_DEFAULT_PATH,
                LocaleAndLanguageWriter::COUNTRY,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
        );

        $this->adapterInterfaceMock->expects($this->once())
        ->method("endSetup")
        ->willReturnSelf();

        $this->localeWriter->SetLocaleAndLanguageBr($storeId);
    }

    public function testSetLocaleAndLanguageUs()
    {
        $storeId = 1;

        $this->moduleDataSetupMock
        ->expects($this->exactly(2))
        ->method("getConnection")
        ->willReturn($this->adapterInterfaceMock);

        $this->adapterInterfaceMock->expects($this->once())
        ->method("startSetup")
        ->willReturnSelf();

        $this->writerInterfaceMock
        ->expects($this->exactly(7))
        ->method("save")
        ->withConsecutive(
            [
            LocaleAndLanguageWriter::CURRENCY_ALLOW_PATH,
            LocaleAndLanguageWriter::CURRENCY_US,
            LocaleAndLanguageWriter::SCOPE,
            $storeId
            ],
            [
                LocaleAndLanguageWriter::CURRENCY_DEFAULT_PATH,
                LocaleAndLanguageWriter::CURRENCY_US,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
            [
                LocaleAndLanguageWriter::CURRENCY_BASE_PATH,
                LocaleAndLanguageWriter::CURRENCY_US,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
            [
                LocaleAndLanguageWriter::LOCALE_CODE_PATH,
                LocaleAndLanguageWriter::LOCALE_CODE_US,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
            [
                LocaleAndLanguageWriter::LOCALE_WEIGHT_PATH,
                LocaleAndLanguageWriter::WEIGHT_UNIT_US,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
            [
                LocaleAndLanguageWriter::LOCALE_TIMEZONE_PATH,
                LocaleAndLanguageWriter::TIMEZONE_US,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
            [
                LocaleAndLanguageWriter::COUNTRY_DEFAULT_PATH,
                LocaleAndLanguageWriter::COUNTRY_US,
                LocaleAndLanguageWriter::SCOPE,
                $storeId
            ],
        );

        $this->adapterInterfaceMock->expects($this->once())
        ->method("endSetup")
        ->willReturnSelf();

        $this->localeWriter->SetLocaleAndLanguageUs($storeId);
    }
}
