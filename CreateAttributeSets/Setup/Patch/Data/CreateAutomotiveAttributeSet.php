<?php

namespace Webjump\CreateAttributeSets\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class CreateAutomotiveAttributeSet implements DataPatchInterface
{
    private $moduleDataSetup;
    private $attributeSetFactory;
    private $categorySetupFactory;
    private $attributeSet;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        AttributeSetFactory $attributeSetFactory,
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    public static function getDependencies()
    {
        return [
        ];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $categorySetup = $this->categorySetupFactory->create(
            ['setup' => $this->moduleDataSetup]
        );

        $attributeSet = $this->attributeSetFactory->create();

        $entityTypeId = $categorySetup->getEntityTypeId(
            \Magento\Catalog\Model\Product::ENTITY
        );

        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);

        $data = [
        'attribute_set_name' => 'Automotive_Attribute_Set',
        'entity_type_id' => $entityTypeId,
        'sort_order' => 50,
        ];

        $attributeSet->setData($data);

        $attributeSet->validate();

        $attributeSet->save();

        $attributeSet->initFromSkeleton($attributeSetId);

        $attributeSet->save();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [
        ];
    }
}
