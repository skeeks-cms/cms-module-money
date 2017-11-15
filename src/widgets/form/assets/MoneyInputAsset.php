<?php
/**
 * MoneyInputAsset
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */

namespace skeeks\modules\cms\money\widgets\form\assets;

use yii\web\AssetBundle;

/**
 * Class MoneyInputAsset
 * @package skeeks\modules\cms\money\widgets\form\assets
 */
class MoneyInputAsset extends AssetBundle
{
    public $sourcePath = '@skeeks/modules/cms/money/widgets/form/assets';

    public $css = [
        //'money-input.css',
    ];
    public $js =
        [
            //'money-input.js',
        ];
    public $depends = [
        '\skeeks\sx\assets\Core',
    ];
}
