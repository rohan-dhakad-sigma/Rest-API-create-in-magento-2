<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sigma\CreateCustomerRestApi\Api\Data;

/**
 * Customer entity interface for API handling.
 *
 * @api
 * @since 100.0.2
 */
interface CustomInterface extends \Magento\Customer\Api\Data\CustomerInterface
{
    /**#@+
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
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
