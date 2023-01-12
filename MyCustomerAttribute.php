<?php

namespace Sigma\CustomerAccountNumber\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Customer\Model\GroupFactory;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class DeptorAccount implements DataPatchInterface
{
    /**
     * EAVSetup.
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var GroupFactory
     */
    private $groupFactory;

    /**
     * @var CollectionFactory
     */
    private $groupCollectionFactory;

    /**
     * DeptorAccount constructor.
     *
     * @param EavSetupFactory $eavSetupFactory
     * @param GroupFactory $groupFactory
     * @param CollectionFactory $groupCollectionFactory
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        GroupFactory $groupFactory,
        CollectionFactory $groupCollectionFactory,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->groupFactory = $groupFactory;
        $this->groupCollectionFactory = $groupCollectionFactory;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Apply
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['Setup' => $this->moduleDataSetup]);
        $this->createAccountAttributes($this->moduleDataSetup);
    }

    /**
     * CreateAccountAttribute
     *
     * @param Setup $setup
     */
    public function createAccountAttributes($setup)
    {
        $attributes = [];
        $attributes["deptor_account_number"] = "Deptor Account Number";
        foreach ($attributes as $attributeCode => $attributeLabel) {
            $this->createAttribute($attributeCode, $attributeLabel, $setup);
        }
    }

    /**
     * Createattribute
     *
     * @param Attributecode $attributeCode
     * @param AttributeLabel $attributeLabel
     * @param Setup $setup
     */
    public function createAttribute($attributeCode, $attributeLabel, $setup)
    {
        try {
            $customerSetup = $this->customerSetupFactory->create(['Setup' => $setup]);
            $customerSetup->removeAttribute(Customer::ENTITY, "deptor_account_number");
            $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
            $attributeSetId = $customerEntity->getDefaultAttributeSetId();
            $attributeSet = $this->attributeSetFactory->create();
            $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

            $customerSetup->addAttribute(Customer::ENTITY, $attributeCode, [
                'type' => 'text',
                'label' => 'Account Number',
                'input' => 'text',
                'required' => true,
                'visible' => true,
                'user_defined' => true,
                'unique' => true,
                'sort_order' => 990,
                'position' => 990,
                'system' => 0,
                'frontend_class' => 'validate-greater-than-zero',
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => true,
                'is_html_allowed_on_front' => false,
                'visible_on_front' => true
            ]);

            $attribute = $customerSetup->getEavConfig()
                ->getAttribute(Customer::ENTITY, $attributeCode)
                ->addData([
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer', 'customer_account_create', 'customer_account_edit']
                ]);
            $attribute->save();
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}
