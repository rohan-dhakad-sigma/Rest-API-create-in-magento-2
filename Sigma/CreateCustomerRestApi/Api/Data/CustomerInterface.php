<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sigma\CreateCustomerRestApi\Api\Data;

use \Magento\Framework\Api\CustomAttributesDataInterface;

interface CustomerInterface extends CustomAttributesDataInterface
{
    const ID = 'id';
    const CONFIRMATION = 'confirmation';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const CREATED_IN = 'created_in';
    const DOB = 'dob';
    const EMAIL = 'email';
    const FIRSTNAME = 'firstname';
    const GENDER = 'gender';
    const GROUP_ID = 'group_id';
    const LASTNAME = 'lastname';
    const MIDDLENAME = 'middlename';
    const PREFIX = 'prefix';
    const STORE_ID = 'store_id';
    const SUFFIX = 'suffix';
    const TAXVAT = 'taxvat';
    const WEBSITE_ID = 'website_id';
    const DEFAULT_BILLING = 'default_billing';
    const DEFAULT_SHIPPING = 'default_shipping';
    const KEY_ADDRESSES = 'addresses';
    const DISABLE_AUTO_GROUP_CHANGE = 'disable_auto_group_change';
    const CUSTOMERNUMBER = 'customer_number';


    /**
     * @return string
     */
    public function getCustomerNumber();

    /**
     * @param string $customernumber
     * @return $this
     */
    public function setCustomerNumber($customernumber);
}
