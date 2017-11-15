<?php
/**
 * Money
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */
namespace skeeks\modules\cms\money;
use skeeks\modules\cms\money\exceptions\CurrencyMismatchException;
use skeeks\modules\cms\money\exceptions\InvalidArgumentException;
use skeeks\modules\cms\money\exceptions\OverflowException;

/**
 * Value Object that represents a monetary value
 * (using a currency's smallest unit).
 *
 * @package    Money
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  2012-2014 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.github.com/sebastianbergmann/money
 * @see        http://martinfowler.com/bliki/ValueObject.html
 * @see        http://martinfowler.com/eaaCatalog/money.html
 */
class Money implements \JsonSerializable
{
    /**
     * @var float
     */
    private $amount;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * @var integer[]
     */
    private static $roundingModes = array(
        PHP_ROUND_HALF_UP,
        PHP_ROUND_HALF_DOWN,
        PHP_ROUND_HALF_EVEN,
        PHP_ROUND_HALF_ODD
    );

    /**
     * @param  integer|float                                  $amount
     * @param  Currency|string $currency
     * @throws InvalidArgumentException
     */
    public function __construct($amount, $currency)
    {
        if (is_int($amount))
        {
            $amount = (float) $amount;
        }

        if (!is_float($amount))
        {
            throw new InvalidArgumentException('$amount must be an integer or float');
        }

        $this->amount   = $amount;
        $this->currency = Currency::getInstance($currency);
    }

    /**
     * Creates a Money object from a string such as "12.34"
     *
     * This method is designed to take into account the errors that can arise
     * from manipulating floating point numbers.
     *
     * If the number of decimals in the string is higher than the currency's
     * number of fractional digits then the value will be rounded to the
     * currency's number of fractional digits.
     *
     * @param  string                                   $value
     * @param  Currency|string $currency
     * @return Money
     * @throws InvalidArgumentException
     */
    public static function fromString($value, $currency)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('$value must be a string');
        }

        $currency = Currency::getInstance($currency);

        return new static(
            //intval(
            floatval(
                round(
                    $currency->getSubUnit() *
                    round(
                        $value,
                        $currency->getDefaultFractionDigits(),
                        PHP_ROUND_HALF_UP
                    ),
                    0,
                    PHP_ROUND_HALF_UP
                )
            ),
            $currency
        );
    }


    /**
     * @return float
     */
    public function getValue()
    {
        return $this->getAmount() / $this->getCurrency()->getSubUnit();
    }

    /**
     * Returns the monetary value represented by this object.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * @link   http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize()
    {
        return [
            'amount'   => $this->amount,
            'currency' => $this->currency->getCurrencyCode()
        ];
    }

    /**
     * Returns the currency of the monetary value represented by this
     * object.
     *
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Returns a new Money object that represents the monetary value
     * of the sum of this Money object and another.
     *
     * @param  Money $other
     * @return Money
     * @throws CurrencyMismatchException
     * @throws OverflowException
     */
    public function add(Money $other)
    {
        $other = $other->convertToCurrency($this->currency);
        $this->assertSameCurrency($this, $other);

        $value = $this->amount + $other->getAmount();

        $this->assertIsFloat($value);

        return $this->newMoney($value);
    }

    /**
     * Returns a new Money object that represents the monetary value
     * of the difference of this Money object and another.
     *
     * @param  Money $other
     * @return Money
     * @throws CurrencyMismatchException
     * @throws OverflowException
     */
    public function subtract(Money $other)
    {
        $other = $other->convertToCurrency($this->currency);
        $this->assertSameCurrency($this, $other);

        $value = $this->amount - $other->getAmount();

        $this->assertIsFloat($value);

        return $this->newMoney($value);
    }

    /**
     * Returns a new Money object that represents the negated monetary value
     * of this Money object.
     *
     * @return Money
     */
    public function negate()
    {
        return $this->newMoney(-1 * $this->amount);
    }

    /**
     * Returns a new Money object that represents the monetary value
     * of this Money object multiplied by a given factor.
     *
     * @param  float   $factor
     * @param  integer $roundingMode
     * @return Money
     * @throws InvalidArgumentException
     */
    public function multiply($factor, $roundingMode = PHP_ROUND_HALF_UP)
    {
        if (!in_array($roundingMode, self::$roundingModes)) {
            throw new InvalidArgumentException(
                '$roundingMode '.\Yii::t('skeeks/money','must be a valid rounding mode').' (PHP_ROUND_*)'
            );
        }

        return $this->newMoney(
            $this->castToFloat(
                round($factor * $this->amount, 0, $roundingMode)
            )
        );
    }

    /**
     * Allocate the monetary value represented by this Money object
     * among N targets.
     *
     * @param  integer|float $n
     * @return Money[]
     * @throws InvalidArgumentException
     */
    public function allocateToTargets($n)
    {
        if (is_int($n))
        {
            $n = (float) $n;
        }

        if (!is_float($n)) {
            throw new InvalidArgumentException('$n '.\Yii::t('skeeks/money','must be an integer'));
        }

        $low       = $this->newMoney(floatval($this->amount / $n));
        $high      = $this->newMoney($low->getAmount() + 1);
        $remainder = $this->amount % $n;
        $result    = array();

        for ($i = 0; $i < $remainder; $i++) {
            $result[] = $high;
        }

        for ($i = $remainder; $i < $n; $i++) {
            $result[] = $low;
        }

        return $result;
    }

    /**
     * Allocate the monetary value represented by this Money object
     * using a list of ratios.
     *
     * @param  array $ratios
     * @return Money[]
     */
    public function allocateByRatios(array $ratios)
    {
        /** @var Money[] $result */
        $result    = array();
        $total     = array_sum($ratios);
        $remainder = $this->amount;

        for ($i = 0; $i < count($ratios); $i++) {
            $amount     = $this->castToFloat($this->amount * $ratios[$i] / $total);
            $result[]   = $this->newMoney($amount);
            $remainder -= $amount;
        }

        for ($i = 0; $i < $remainder; $i++) {
            $result[$i] = $this->newMoney($result[$i]->getAmount() + 1);
        }

        return $result;
    }

    /**
     * Extracts a percentage of the monetary value represented by this Money
     * object and returns an array of two Money objects:
     * $original = $result['subtotal'] + $result['percentage'];
     *
     * Please note that this extracts the percentage out of a monetary value
     * where the percentage is already included. If you want to get the
     * percentage of the monetary value you should use multiplication
     * (multiply(0.21), for instance, to calculate 21% of a monetary value
     * represented by a Money object) instead.
     *
     * @param  float $percentage
     * @return Money[]
     * @see    https://github.com/sebastianbergmann/money/issues/27
     */
    public function extractPercentage($percentage)
    {
        $percentage = $this->newMoney(
            floatval($this->amount / (100 + $percentage) * $percentage)
        );

        return array(
            'percentage' => $percentage,
            'subtotal'   => $this->subtract($percentage)
        );
    }

    /**
     * Compares this Money object to another.
     *
     * Returns an integer less than, equal to, or greater than zero
     * if the value of this Money object is considered to be respectively
     * less than, equal to, or greater than the other Money object.
     *
     * @param  Money $other
     * @return integer -1|0|1
     * @throws CurrencyMismatchException
     */
    public function compareTo(Money $other)
    {
        $other = $other->convertToCurrency($this->currency);
        $this->assertSameCurrency($this, $other);

        if ($this->amount == $other->getAmount()) {
            return 0;
        }

        return $this->amount < $other->getAmount() ? -1 : 1;
    }

    /**
     * Returns TRUE if this Money object equals to another.
     *
     * @param  Money $other
     * @return boolean
     * @throws CurrencyMismatchException
     */
    public function equals(Money $other)
    {
        return $this->compareTo($other) == 0;
    }

    /**
     * Returns TRUE if the monetary value represented by this Money object
     * is greater than that of another, FALSE otherwise.
     *
     * @param  Money $other
     * @return boolean
     * @throws CurrencyMismatchException
     */
    public function greaterThan(Money $other)
    {
        return $this->compareTo($other) == 1;
    }

    /**
     * Returns TRUE if the monetary value represented by this Money object
     * is greater than or equal that of another, FALSE otherwise.
     *
     * @param  Money $other
     * @return boolean
     * @throws CurrencyMismatchException
     */
    public function greaterThanOrEqual(Money $other)
    {
        return $this->greaterThan($other) || $this->equals($other);
    }

    /**
     * Returns TRUE if the monetary value represented by this Money object
     * is smaller than that of another, FALSE otherwise.
     *
     * @param  Money $other
     * @return boolean
     * @throws CurrencyMismatchException
     */
    public function lessThan(Money $other)
    {
        return $this->compareTo($other) == -1;
    }

    /**
     * Returns TRUE if the monetary value represented by this Money object
     * is smaller than or equal that of another, FALSE otherwise.
     *
     * @param  Money $other
     * @return boolean
     * @throws CurrencyMismatchException
     */
    public function lessThanOrEqual(Money $other)
    {
        return $this->lessThan($other) || $this->equals($other);
    }

    /**
     * @param  Money $a
     * @param  Money $b
     * @throws CurrencyMismatchException
     */
    private function assertSameCurrency(Money $a, Money $b)
    {
        if ($a->getCurrency() != $b->getCurrency()) {
            throw new CurrencyMismatchException;
        }
    }

    /**
     * Raises an exception if the amount is not an integer
     *
     * @param  number $amount
     * @return number
     * @throws OverflowException
     */
    private function assertIsFloat($amount)
    {
        if (!is_float($amount)) {
            throw new OverflowException;
        }
    }// @codeCoverageIgnore

    /**
     * Raises an exception if the amount is outside of the integer bounds
     *
     * @param  number $amount
     * @return number
     * @throws OverflowException
     */
    private function assertInsideIntegerBounds($amount)
    {
        if (abs($amount) > PHP_INT_MAX) {
            throw new OverflowException;
        }
    }// @codeCoverageIgnore

    /**
     * Cast an amount to an integer but ensure that the operation won't hide overflow
     *
     * @param number $amount
     * @return float
     * @throws OverflowException
     */
    private function castToFloat($amount)
    {
        $this->assertInsideIntegerBounds($amount);

        return floatval($amount);
        //return intval($amount);
    }

    /**
     * @param  integer|float $amount
     * @return Money
     */
    private function newMoney($amount)
    {
        return new static($amount, $this->currency);
    }

    /**
     * @param $currencyTo
     * @return Money
     */
    public function convertToCurrency($currencyTo)
    {
        $currencyTo = Currency::getInstance($currencyTo);

        if ($crossCourse = $this->getCurrency()->getCrossCourse($currencyTo))
        {
            $newMoney = $this->multiply($crossCourse);
            return new static($newMoney->getAmount(), $currencyTo);
        } else
        {
            throw new InvalidArgumentException(\Yii::t('skeeks/money','Unable to get the cross rate for the currency'). ' ' . $currencyTo->getCurrencyCode());
        }
    }
}
