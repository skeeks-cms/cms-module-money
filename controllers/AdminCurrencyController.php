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
use skeeks\cms\models\behaviors\HasStatus;
use skeeks\cms\modules\admin\controllers\AdminModelEditorSmartController;
use skeeks\cms\modules\admin\controllers\helpers\rules\NoModel;
use skeeks\modules\cms\money\ExchangeRatesCBRF;
use skeeks\modules\cms\money\models\Currency;
use yii\helpers\ArrayHelper;

/**
 * Class AdminCurrencyController
 * @package skeeks\modules\cms\money\controllers
 */
class AdminCurrencyController extends AdminModelEditorSmartController
{
    public function init()
    {
        $this->_label                   = "Управление валютами";

        $this->_modelShowAttribute      = "code";
        $this->_modelClassName          = Currency::className();

        parent::init();


    }


    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

            self::BEHAVIOR_ACTION_MANAGER =>
                [
                    "actions" =>
                        [
                            'update-all' =>
                            [
                                "label" => "Обновить все валюты",
                                "icon" => "glyphicon glyphicon-paperclip",
                                "rules" =>
                                    [
                                        [
                                            "class" => NoModel::className(),
                                        ]
                                    ]
                            ],

                            'update-course' =>
                            [
                                "label" => "Обновить курс",
                                "icon" => "glyphicon glyphicon-paperclip",
                                "rules" =>
                                    [
                                        [
                                            "class" => NoModel::className(),
                                        ]
                                    ]
                            ],
                        ]
                ]
        ]);
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
                        'status' => HasStatus::STATUS_INACTIVE,
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
