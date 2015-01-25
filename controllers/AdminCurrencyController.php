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
use skeeks\cms\modules\admin\controllers\AdminModelEditorSmartController;
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
                            /*'parse' =>
                                [
                                    "label" => "Обновить города и регионы",
                                    "icon" => "glyphicon glyphicon-paperclip",
                                    "rules" =>
                                        [
                                            [
                                                "class" => NoModel::className(),
                                            ]
                                        ]
                                ],*/
                        ]
                ]
        ]);
    }

    public function actionParse()
    {
        if (\Yii::$app->request->isPost)
        {
            if ($id = \Yii::$app->request->post('kladr_country_id'))
            {
                Updater::cityUpdate($id);
            } else
            {
                Updater::cityUpdate();
            }
        }

        return $this->render('parse');
    }
}
