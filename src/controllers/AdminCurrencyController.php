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
use skeeks\cms\modules\admin\actions\modelEditor\AdminMultiModelEditAction;
use skeeks\cms\modules\admin\controllers\AdminModelEditorController;
use skeeks\cms\modules\admin\controllers\AdminModelEditorSmartController;
use skeeks\cms\modules\admin\controllers\helpers\rules\NoModel;
use skeeks\cms\modules\admin\traits\AdminModelEditorStandartControllerTrait;
use skeeks\modules\cms\money\ExchangeRatesCBRF;
use skeeks\modules\cms\money\models\Currency;
use yii\helpers\ArrayHelper;

/**
 * Class AdminCurrencyController
 * @package skeeks\modules\cms\money\controllers
 */
class AdminCurrencyController extends AdminModelEditorController
{
    use AdminModelEditorStandartControllerTrait;

    public function init()
    {
        $this->name                   = \Yii::t('skeeks/money',"Currency management");

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
                "name"          => \Yii::t('skeeks/money',"Update all currencies"),
                "icon"          => "glyphicon glyphicon-paperclip",
                "callback"      => [$this, 'actionUpdateAll'],
            ],

            'update-course' =>
            [
                "class"         => AdminAction::className(),
                "name"          => \Yii::t('skeeks/money',"Refresh rate"),
                "icon"          => "glyphicon glyphicon-paperclip",
                "callback"      => [$this, 'actionUpdateCourse'],
            ],


            "activate-multi" =>
            [
                'class' => AdminMultiModelEditAction::className(),
                "name" => \Yii::t('skeeks/money',"Activate"),
                //"icon"              => "glyphicon glyphicon-trash",
                "eachCallback" => [$this, 'eachMultiActivate'],
            ],

            "inActivate-multi" =>
            [
                'class' => AdminMultiModelEditAction::className(),
                "name" => \Yii::t('skeeks/money',"Deactivate"),
                //"icon"              => "glyphicon glyphicon-trash",
                "eachCallback" => [$this, 'eachMultiInActivate'],
            ]
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
            \Yii::$app->money->processUpdateCourses();
            \Yii::$app->session->setFlash('success', \Yii::t('skeeks/money','Data successfully updated'));

        }

        return $this->render('update-course');
    }
}
