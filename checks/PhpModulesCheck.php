<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 26.04.2015
 */
namespace skeeks\modules\cms\money\checks;
use skeeks\cms\base\CheckComponent;

/**
 * Class PhpModulesCheck
 * @package skeeks\cms\components
 */
class PhpModulesCheck extends \skeeks\cms\checks\PhpModulesCheck
{
    public function run()
    {
        $arMods = [
			'soap'                  => \Yii::t('skeeks/money','Functions')." soap, php-mod-soap",
			'intl'                  => \Yii::t('skeeks/money','Functions')." intl, php-mod-intl",
			'simplexml'             => \Yii::t('skeeks/money','Functions')." simplexml, php-mod-simplexml",
		];

        $strError = '';
		foreach($arMods as $func => $desc)
		{
			if (!extension_loaded("soap"))
            {
                $this->addError($desc);
            } else
            {
                $this->addSuccess($desc);
            }
		}
    }
}
