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
 * @package skeeks\modules\cms\kladr
 */
class Module extends CmsModule
{
    public $controllerNamespace = 'skeeks\modules\cms\kladr\controllers';

    /**
     * @return array
     */
    protected function _descriptor()
    {
        return array_merge(parent::_descriptor(), [
            "name"          => "Модуль для работы с деньгами и валютой",
            "description"   => "Модуль для работы с деньгами и валютой",
        ]);
    }

}