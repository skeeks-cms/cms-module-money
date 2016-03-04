<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 07.03.2015
 */
namespace skeeks\modules\cms\money\console\controllers;
use skeeks\cms\base\console\Controller;
/**
 * Class AgentsController
 * @package skeeks\modules\cms\money\console\controllers
 */
class AgentsController extends Controller
{
    /**
     * Обновление курсов валют
     */
    public function actionUpdateCourses()
    {
        \Yii::$app->money->processUpdateCourses();
        \Yii::info("Удалено логов: " . $deleted);
    }
}