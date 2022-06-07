<?php

namespace Webjump\CreateAttributeSets\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddColorAttributeToSets implements DataPatchInterface
{
    private $moduleDataSetup;
    private $eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public static function getDependencies()
    {
        return [
            \Webjump\CreateAttributeSets\Setup\Patch\Data\CreateAutomotiveAttributeSet::class,
            \Webjump\CreateAttributeSets\Setup\Patch\Data\CreatePartyAttributeSet::class
        ];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(
            ['setup' => $this->moduleDataSetup]
        );

        $entityTypeId = $eavSetup->getEntityTypeId(
            \Magento\Catalog\Model\Product::ENTITY
        );

        $autoAttributeSetId = $eavSetup->getAttributeSet(
            $entityTypeId,
            'Automotive_Attribute_Set',
            'attribute_set_id'
        );

        $partyAttributeSetId = $eavSetup->getAttributeSet(
            $entityTypeId,
            'Party_Attribute_Set',
            'attribute_set_id'
        );

        $attributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'color'
        );

        $options = [
            'attribute_id' => $attributeId,
            'values' => [
                'White',
                'Black',
                'Red',
                'Blue',
                'Yellow',
                'Green',
                'Orange',
                'Pink'
                ]
        ];

        $eavSetup->addAttributeOption($options);

        $eavSetup->addAttributeToSet(
            $entityTypeId,
            $autoAttributeSetId,
            'General',
            $attributeId,
            null
        );

        $eavSetup->addAttributeToSet(
            $entityTypeId,
            $partyAttributeSetId,
            'General',
            $attributeId,
            null
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [
        ];
    }
}
