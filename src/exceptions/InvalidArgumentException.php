<?php
/**
 * InvalidArgumentException
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
 * Exception that is raised when invalid (scalar) arguments
 * are passed to a method.
 *
 * Class InvalidArgumentException
 * @package skeeks\modules\cms\money\exceptions
 */
class InvalidArgumentException extends \InvalidArgumentException implements Exception
{}
