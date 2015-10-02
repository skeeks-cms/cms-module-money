<?php
/**
 * IntlFormatter
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */
namespace skeeks\modules\cms\money;

use NumberFormatter;
use skeeks\modules\cms\money\interfaces\Formatter;
use skeeks\modules\cms\money\Money;

/**
 * Formatter implementation that uses PHP's built-in NumberFormatter.
 *
 * @package    Money
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  2012-2014 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.github.com/sebastianbergmann/money
 */
class IntlFormatter implements Formatter
{
    /**
     * @var NumberFormatter
     */
    private $numberFormatter;

    /**
     * @param string $locale
     */
    public function __construct($locale)
    {
        $this->numberFormatter = new NumberFormatter(
            $locale,
            NumberFormatter::CURRENCY
        );
    }

    /**
     * Formats a Money object using PHP's built-in NumberFormatter.
     *
     * @param  Money $money
     * @return string
     */
    public function format(Money $money = null)
    {
        if (!$money)
        {
            return null;
        } else
        {
            return $this->numberFormatter->formatCurrency(
                $money->getAmount() / $money->getCurrency()->getSubUnit(),
                $money->getCurrency()->getCurrencyCode()
            );
        }

    }
}
