<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\DiscountCalculationConnector\Business;

use Generated\Shared\Transfer\CalculableObjectTransfer;

/**
 * @method \Spryker\Zed\DiscountCalculationConnector\Business\DiscountCalculationConnectorBusinessFactory getFactory()
 */
interface DiscountCalculationConnectorFacadeInterface
{
    /**
     * Specification:
     * - Finds all discounts with voucher within the provided Store.
     * - Finds all discounts matching decision rules.
     * - Collects discountable items for each discount type.
     * - Applies discount to exclusive if exists.
     * - Distributes discount amount throw all discountable items.
     * - Adds discount totals to quote calculatable object properties.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CalculableObjectTransfer $calculableObjectTransfer
     *
     * @return \Generated\Shared\Transfer\CalculableObjectTransfer
     */
    public function recalculateDiscounts(CalculableObjectTransfer $calculableObjectTransfer): CalculableObjectTransfer;
}
