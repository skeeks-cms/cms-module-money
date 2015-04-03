<?php
/**
 * Module
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 20.01.2015
 * @since 1.0.0
 */
namespace skeeks\modules\cms\money;

use skeeks\cms\base\Module as CmsModule;

/**
 * Class Module
 * @package skeeks\modules\cms\money
 */
class Module extends CmsModule
{
    public $controllerNamespace = 'skeeks\modules\cms\money\controllers';

    /**
     * @return array
     */
    protected function _descriptor()
    {
        return array_merge(parent::_descriptor(), [
            "version"           => "1.0.8",
            "name"              => "Модуль для работы с деньгами и валютой",
        ]);
    }

}