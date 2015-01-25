<?php
/**
 * Formatter
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */
namespace skeeks\modules\cms\money\interfaces;
use skeeks\modules\cms\money\Money;

/**
 *
 * Interface for Money object formatters.
 *
 * Interface Formatter
 * @package skeeks\modules\cms\money\interfaces
 */
interface Formatter
{
    /**
     * Formats a Money object.
     *
     * @param  Money $money
     * @return string
     */
    public function format(Money $money);
}
