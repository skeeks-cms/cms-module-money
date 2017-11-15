<?php
/**
 * OverflowException
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */

namespace skeeks\modules\cms\money\exceptions;

use skeeks\modules\cms\money\interfaces\Exception;

/**
 *
 * Exception that is throw when when an amount overflows valid integers
 *
 * Class OverflowException
 * @package skeeks\modules\cms\money\exceptions
 */
class OverflowException extends \OverflowException implements Exception
{
}
