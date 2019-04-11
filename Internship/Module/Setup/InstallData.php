<?php

namespace Internship\Module\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'wholesale',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Wholesale',
                'input' => 'boolean',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'required' => true,
                'user_defined' => false,
                'default' => 'No',
                'searchable' => true,
                'filterable' => true,
                'comparable' => false,
                'visible_on_front' => true,
                'filterable_in_search' => true,
                'used_for_sort_by' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'used_for_promo_rules' => true,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'apply_to' => 'simple',
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'wholesale_price',
            [
                'type' => 'text',
                'backend' => '',
                'frontend' => '',
                'label' => 'Wholesale Price',
                'input' => 'price',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'filterable_in_search' => false,
                'used_in_product_listing' => true,
                'unique' => false,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'apply_to' => 'simple',
            ]
        );
    }

//    /**
//     * function for deleting custom attributes (wholesale and wholesale_price)
//     * @param ModuleDataSetupInterface $setup
//     * @param ModuleContextInterface $context
//     */
//    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
//    {
//        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
//
//        $eavSetup->removeAttribute(
//            \Magento\Catalog\Model\Product::ENTITY,
//            'wholesale');
//
//        $eavSetup->removeAttribute(
//            \Magento\Catalog\Model\Product::ENTITY,
//            'wholesale_price');
//    }
}
