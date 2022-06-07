<?php

namespace Webjump\ConfigLocaleAndLanguage\Test\Unit\Setup\Patch\Data;

use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Webjump\ConfigLocaleAndLanguage\Setup\Patch\Data\InstallUSD;

use function PHPUnit\Framework\assertEquals;

class InstallUSDTest extends TestCase
{
    public function setUp(): void
    {
        $this->writerInterfaceMock = $this->createMock(WriterInterface::class);
        $this->moduleDataSetupMock = $this->createMock(ModuleDataSetupInterface::class);
        $this->adapterInterfaceMock = $this->createMock(AdapterInterface::class);

        $this->installUSD = new InstallUSD(
            $this->moduleDataSetupMock,
            $this->writerInterfaceMock
        );
    }

    public function testApply()
    {
        $this->moduleDataSetupMock
        ->expects($this->exactly(2))
        ->method("getConnection")
        ->willReturn($this->adapterInterfaceMock);

        $this->adapterInterfaceMock
        ->expects($this->once())
        ->method("startSetup")
        ->willReturnSelf();

        $this->writerInterfaceMock
        ->expects($this->once())
        ->method("save")
        ->with(
            InstallUSD::CURRENCY_INSTALLED_PATH,
            InstallUSD::BRLUSD
        );

        $this->adapterInterfaceMock
        ->expects($this->once())
        ->method("endSetup")
        ->willReturnSelf();

        $this->installUSD->apply();
    }

    public function testGetDependencies()
    {
        $array = [];
        $returned = $this->installUSD->getDependencies();

        assertEquals($array, $returned);
    }

    public function testGetAliases()
    {
        $array = [];
        $returned = $this->installUSD->getAliases();

        assertEquals($array, $returned);
    }
}
