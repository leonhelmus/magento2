<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\SalesRule\Model\Rule\Action\Discount;

use InvalidArgumentException;
use Magento\Framework\ObjectManagerInterface;
use Magento\SalesRule\Model\Rule;

class CalculatorFactory
{
    /**
     * Object manager
     *
     * @var ObjectManagerInterface
     */
    private $_objectManager;

    /**
     * @var array
     */
    protected $classByType = [
        Rule::TO_PERCENT_ACTION =>
            ToPercent::class,
        Rule::BY_PERCENT_ACTION =>
            ByPercent::class,
        Rule::TO_FIXED_ACTION => ToFixed::class,
        Rule::BY_FIXED_ACTION => ByFixed::class,
        Rule::CART_FIXED_ACTION =>
            CartFixed::class,
        Rule::BUY_X_GET_Y_ACTION =>
            BuyXGetY::class,
    ];

    /**
     * @param ObjectManagerInterface $objectManager
     * @param array $discountRules
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        array $discountRules = []
    ) {
        $this->classByType = array_merge($this->classByType, $discountRules);
        $this->_objectManager = $objectManager;
    }

    /**
     * @param string $type
     * @return DiscountInterface
     * @throws InvalidArgumentException
     */
    public function create($type)
    {
        if (!isset($this->classByType[$type])) {
            throw new InvalidArgumentException($type . ' is unknown type');
        }

        return $this->_objectManager->create($this->classByType[$type]);
    }
}
