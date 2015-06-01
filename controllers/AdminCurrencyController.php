<?php
/**
 * AdminCurrencyController
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */
namespace skeeks\modules\cms\money\controllers;
use skeeks\cms\components\Cms;
use skeeks\cms\models\behaviors\HasStatus;
use skeeks\cms\modules\admin\actions\AdminAction;
use skeeks\cms\modules\admin\controllers\AdminModelEditorController;
use skeeks\cms\modules\admin\controllers\AdminModelEditorSmartController;
use skeeks\cms\modules\admin\controllers\helpers\rules\NoModel;
use skeeks\modules\cms\money\ExchangeRatesCBRF;
use skeeks\modules\cms\money\models\Currency;
use yii\helpers\ArrayHelper;

/**
 * Class AdminCurrencyController
 * @package skeeks\modules\cms\money\controllers
 */
class AdminCurrencyController extends AdminModelEditorController
{
    public function init()
    {
        $this->name                   = "Управление валютами";

        $this->modelShowAttribute      = "code";
        $this->modelClassName          = Currency::className();

        parent::init();
    }

    public function actions()
    {
        $actions = ArrayHelper::merge(parent::actions(),
        [
            'update-all' =>
            [
                "class"         => AdminAction::className(),
                "name"          => "Обновить все валюты",
                "icon"          => "glyphicon glyphicon-paperclip",
                "callback"      => [$this, 'actionUpdateAll'],
            ],

            'update-course' =>
            [
                "class"         => AdminAction::className(),
                "name"          => "Обновить курс",
                "icon"          => "glyphicon glyphicon-paperclip",
                "callback"      => [$this, 'actionUpdateCourse'],
            ],
        ]);

        return $actions;
    }


    public function actionUpdateAll()
    {
        if (\Yii::$app->request->isPost)
        {
            foreach (\skeeks\modules\cms\money\Currency::$currencies as $code => $data)
            {
                $currency = new \skeeks\modules\cms\money\Currency($code);

                if (!$currencyModel = Currency::find()->where(['code' => $code])->one())
                {
                    $currencyModel = new Currency([
                        'code' => $code,
                        'active' => Cms::BOOL_N,
                        'name_full' => $currency->getDisplayName(),
                        'name' => $currency->getDisplayName(),
                    ]);

                    $currencyModel->save(false);
                } else
                {
                    if (!$currencyModel->name)
                    {
                        $currencyModel->name        = $currency->getDisplayName();
                    }

                    if (!$currencyModel->name_full)
                    {
                        $currencyModel->name_full        = $currency->getDisplayName();
                    }
                    $currencyModel->save(false);
                }
            }

        }

        return $this->render('update-all');
    }

    public function actionUpdateCourse()
    {
        if (\Yii::$app->request->isPost)
        {
            $cbrf = new ExchangeRatesCBRF();
            $data = $cbrf->GetRates();

            if ($data['byChCode'])
            {
                foreach ($data['byChCode'] as $code => $value)
                {
                    if ($currency = Currency::find()->where(['code' => $code])->one())
                    {
                        $currency->course = $value;
                        $currency->save(false);
                    }
                }
            }

        }

        return $this->render('update-course');
    }
}
