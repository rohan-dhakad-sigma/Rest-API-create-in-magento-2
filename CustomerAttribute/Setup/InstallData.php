<?php

namespace Sigma\CustomerAttribute\Setup;

use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;

class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     *
     * @param EavSetupFactory $eavSetupFactory
     * @param Config $eavConfig
     */
    public function __construct
    (
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'customer_number',
            [
                'type' => 'string',
                'label' => 'Customer_Number',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'position' => 999,
                'system' => 0,
            ]);

        $sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'customer_number');

        // more used_in_forms ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address']
        $sampleAttribute->setData(
            'used_in_forms',
            ['adminhtml_customer', 'checkout_register', 'customer_account_create', 'customer_account_edit', 'customer_address_edit', 'customer_register_address',
                'adminhtml_checkout', 'adminhtml_customer_address']

        );
        $sampleAttribute->save();
    }
}
