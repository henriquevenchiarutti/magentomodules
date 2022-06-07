<?php

namespace Webjump\ConfigLocaleAndLanguage\Test\Unit\Setup\Patch\Data;

use Magento\Store\Api\Data\StoreInterface;
use PHPUnit\Framework\TestCase;
use Webjump\ConfigLocaleAndLanguage\Model\LocaleAndLanguageWriter;
use Magento\Store\Model\StoreManagerInterface;
use Webjump\ConfigLocaleAndLanguage\Setup\Patch\Data\ConfigPartyUsLocale;

use function PHPUnit\Framework\assertEquals;

class ConfigPartyUsLocaleTest extends TestCase
{
    public function setUp(): void
    {
        $this->storeInterfaceMock = $this->createMock(StoreInterface::class);

        $this->localeWriterMock = $this->createMock(LocaleAndLanguageWriter::class);
        $this->storeManagerInterfaceMock = $this->createMock(StoreManagerInterface::class);

        $this->configPartyUsLocale = new ConfigPartyUsLocale(
            $this->storeManagerInterfaceMock,
            $this->localeWriterMock
        );
    }

    public function testApply()
    {
        $storeId = 1;

        $this->storeManagerInterfaceMock
        ->expects($this->once())
        ->method("getStore")
        ->with("party_store_view_us")
        ->willReturn($this->storeInterfaceMock);

        $this->storeInterfaceMock
        ->expects($this->once())
        ->method("getId")
        ->willReturn($storeId);

        $this->localeWriterMock->expects($this->once())
        ->method("setLocaleAndLanguageUs")
        ->with($storeId);

        $this->configPartyUsLocale->apply();
    }

    public function testGetDependencies()
    {
        $array = [];
        $returned = $this->configPartyUsLocale->getDependencies();

        assertEquals($array, $returned);
    }

    public function testGetAliases()
    {
        $array = [];
        $returned = $this->configPartyUsLocale->getAliases();

        assertEquals($array, $returned);
    }
}
