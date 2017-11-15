<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */
namespace skeeks\modules\cms\money\currency;
use skeeks\modules\cms\money\Currency;
use skeeks\modules\cms\money\Money;
/**
 * @package skeeks\modules\cms\money\currency
 */
class SVC extends Money
{
    public function __construct($amount)
    {
        parent::__construct($amount, new Currency('SVC'));
    }
}
