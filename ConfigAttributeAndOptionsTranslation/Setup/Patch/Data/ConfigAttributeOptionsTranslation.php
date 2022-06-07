<?php

declare(strict_types=1);

namespace Webjump\ConfigAttributeAndOptionsTranslation\Setup\Patch\Data;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Api\Data\AttributeOptionInterfaceFactory;
use Magento\Eav\Api\Data\AttributeOptionLabelInterfaceFactory;
use Magento\Eav\Api\Data\AttributeOptionLabelInterface;
use Magento\Catalog\Api\ProductAttributeOptionManagementInterface;

class ConfigAttributeOptionsTranslation implements DataPatchInterface
{
    private $storeManager;
    private $moduleDataSetup;
    private $attributeOptionInterfaceFactory;
    private $attributeOptionLabelInterfaceFactory;
    private $attributeOptionManagement;

    public function __construct(
        StoreManagerInterface $storeManager,
        ModuleDataSetupInterface $moduleDataSetup,
        AttributeOptionInterfaceFactory $attributeOptionInterfaceFactory,
        AttributeOptionLabelInterfaceFactory $attributeOptionLabelInterfaceFactory,
        ProductAttributeOptionManagementInterface $attributeOptionManagement
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->storeManager = $storeManager;
        $this->attributeOptionInterfaceFactory = $attributeOptionInterfaceFactory;
        $this->attributeOptionLabelInterfaceFactory = $attributeOptionLabelInterfaceFactory;
        $this->attributeOptionManagement = $attributeOptionManagement;
    }

    public function getAliases()
    {
        return [
        ];
    }

    public static function getDependencies()
    {
        return [
        ];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $festasPtStoreId = $this->storeManager
        ->getStore("festas_store_view_pt")
        ->getId();

        $automotivoPtStoreId = $this->storeManager
        ->getStore("automotivo_store_view_pt")
        ->getId();

        $options = $this->attributeOptionManagement->getItems("color");

        foreach ($options as $option) {
            if ($option->getValue()) {
                $this->attributeOptionManagement->delete('color', $option->getValue());
            }
        }

        foreach ($this->getData() as $labelUs => $labelPt) {
            $automotivoLabel = $this->createAttributeOptionLabel($labelPt, (int)$automotivoPtStoreId);
            $festasLabel = $this->createAttributeOptionLabel($labelPt, (int)$festasPtStoreId);

            $option = $this->attributeOptionInterfaceFactory->create();
            $option
                ->setLabel($labelUs)
                ->setStoreLabels([$automotivoLabel,$festasLabel]);

            $this->attributeOptionManagement->add(
                'color',
                $option
            );
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    private function getData(): array
    {
        return [
            "White" => "Branco",
            "Black" => "Preto",
            "Red" => "Vermelho",
            "Blue" => "Azul",
            "Yellow" => "Amarelo",
            "Green" => "Verde",
            "Orange" => "Laranja",
            "Pink" => "Rosa"
        ];
    }

    private function createAttributeOptionLabel(string $labelPt, int $storeId)
    {
        /** @var AttributeOptionLabelInterface $attributeOptionLabel */
        $attributeOptionLabel = $this->attributeOptionLabelInterfaceFactory->create();

        $attributeOptionLabel
            ->setLabel($labelPt)
            ->setStoreId($storeId);

        return $attributeOptionLabel;
    }
}
