<?php

namespace Training\Warranty\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Training\Warranty\Attribute\Backend\Warranty as Backend;
use Training\Warranty\Attribute\Frontend\Warranty as Frontend;
use Training\Warranty\Attribute\Source\Warranty as Source;

class AddWarrantyAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * AddWarrantyAttribute constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Run code inside patch
     * If code fails, patch must be reverted, in case when we are speaking about schema - than under revert
     * means run PatchInterface::revert()
     *
     * If we speak about data, under revert means: $transaction->rollback()
     *
     * @return $this
     */
    public function apply()
    {
        /** @var $eavSetup EavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(Product::ENTITY, 'warranty', [
            'type' => 'varchar',
            'group' => 'Gear',
            'label' => 'Warranty',
            'input' => 'text',
            'source' => Source::class,
            'frontend' => Frontend::class,
            'backend' => Backend::class,
            'required' => false,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'is_used_in_grid' => false,
            'visible' => true,
            'is_html_allowed_on_front' => true,
            'visible_on_front' => true
        ]);

        return $this;
    }
}