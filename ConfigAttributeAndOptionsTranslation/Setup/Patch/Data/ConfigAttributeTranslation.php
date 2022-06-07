<?php

namespace Webjump\ConfigAttributeAndOptionsTranslation\Setup\Patch\Data;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Eav\Api\Data\AttributeFrontendLabelInterfaceFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class ConfigAttributeTranslation implements DataPatchInterface
{
    private $storeManager;
    private $eavSetupFactory;
    private $productAttributeRepository;
    private $attributeFrontendLabel;
    private $moduleDataSetup;

    public function __construct(
        StoreManagerInterface $storeManager,
        EavSetupFactory $eavSetupFactory,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        AttributeFrontendLabelInterfaceFactory $attributeFrontendLabel,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->storeManager = $storeManager;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->attributeFrontendLabel = $attributeFrontendLabel;
    }

    public function getAliases()
    {
        return [
        ];
    }

    public static function getDependencies()
    {
        return [
            \Webjump\CreateAttributeSets\Setup\Patch\Data\CreateTopspeedCustomAttribute::class,
            \Webjump\CreateAttributeSets\Setup\Patch\Data\CreateAccelerationCustomAttribute::class,
            \Webjump\CreateAttributeSets\Setup\Patch\Data\CreateSizeCustomAttribute::class,
            \Webjump\CreateAttributeSets\Setup\Patch\Data\CreatePartythemeCustomAttribute::class,
            \Webjump\CreateAttributeSets\Setup\Patch\Data\AddColorAttributeToSets::class
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

        $colorAttributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'color'
        );

        $sizeAttributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'size'
        );

        $partythemeAttributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'party_theme'
        );

        $topspeedAttributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'top_speed'
        );

        $accelerationAttributeId = $eavSetup->getAttributeId(
            $entityTypeId,
            'acceleration'
        );

        $festasStoreId = $this->storeManager
        ->getStore("festas_store_view_pt")
        ->getId();

        $automotivoStoreId = $this->storeManager
        ->getStore("automotivo_store_view_pt")
        ->getId();

        $this->translateAttribute("Cor", $festasStoreId, $automotivoStoreId, $colorAttributeId);
        $this->translateAttribute("Tamanho", $festasStoreId, $automotivoStoreId, $sizeAttributeId);
        $this->translateAttribute("Tema da Festa", $festasStoreId, $automotivoStoreId, $partythemeAttributeId);
        $this->translateAttribute("Velocidade Máxima", $festasStoreId, $automotivoStoreId, $topspeedAttributeId);
        $this->translateAttribute("Aceleração", $festasStoreId, $automotivoStoreId, $accelerationAttributeId);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function translateAttribute(
        $newName,
        $festasStoreId,
        $automotivoStoreId,
        $attributeId
    ) {
        $attribute = $this->productAttributeRepository->get($attributeId);

        $frontendLabels = [
            $this->attributeFrontendLabel->create()
                ->setStoreId($festasStoreId)
                ->setLabel($newName),
            $this->attributeFrontendLabel->create()
                ->setStoreId($automotivoStoreId)
                ->setLabel($newName),
        ];

        $attribute->setFrontendLabels($frontendLabels);

        $this->productAttributeRepository->save($attribute);
    }
}
