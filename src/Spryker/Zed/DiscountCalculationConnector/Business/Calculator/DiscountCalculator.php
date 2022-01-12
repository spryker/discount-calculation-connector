<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\DiscountCalculationConnector\Business\Calculator;

use ArrayObject;
use Generated\Shared\Transfer\CalculableObjectTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\DiscountCalculationConnector\Dependency\Facade\DiscountCalculationToDiscountInterface;

class DiscountCalculator implements DiscountCalculatorInterface
{
    /**
     * @var \Spryker\Zed\DiscountCalculationConnector\Dependency\Facade\DiscountCalculationToDiscountInterface
     */
    protected $discountFacade;

    /**
     * @param \Spryker\Zed\DiscountCalculationConnector\Dependency\Facade\DiscountCalculationToDiscountInterface $discountFacade
     */
    public function __construct(DiscountCalculationToDiscountInterface $discountFacade)
    {
        $this->discountFacade = $discountFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CalculableObjectTransfer $calculableObjectTransfer
     *
     * @return \Generated\Shared\Transfer\CalculableObjectTransfer
     */
    public function recalculate(CalculableObjectTransfer $calculableObjectTransfer): CalculableObjectTransfer
    {
        $calculableObjectTransfer->requireStore();

        $this->removeCalculatedDiscountsForItems($calculableObjectTransfer);

        $quoteTransfer = (new QuoteTransfer())
            ->fromArray($calculableObjectTransfer->toArray(), true);

        if ($calculableObjectTransfer->getOriginalOrder()) {
            $quoteTransfer->setOrderReference($calculableObjectTransfer->getOriginalOrderOrFail()->getOrderReference());
        }
        $quoteTransfer = $this->discountFacade->calculateDiscounts($quoteTransfer);

        return $calculableObjectTransfer->fromArray($quoteTransfer->toArray(), true);
    }

    /**
     * @param \Generated\Shared\Transfer\CalculableObjectTransfer $calculableObjectTransfer
     *
     * @return \Generated\Shared\Transfer\CalculableObjectTransfer
     */
    protected function removeCalculatedDiscountsForItems(CalculableObjectTransfer $calculableObjectTransfer): CalculableObjectTransfer
    {
        foreach ($calculableObjectTransfer->getItems() as $itemTransfer) {
            $itemTransfer->setCalculatedDiscounts(new ArrayObject());
        }

        return $calculableObjectTransfer;
    }
}
