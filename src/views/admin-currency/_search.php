<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 09.08.2016
 */

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\Game */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<?
$query = $dataProvider->query;

$filter = new \yii\base\DynamicModel([
    'id',
]);
$filter->addRule('id', 'integer');

$filter->load(\Yii::$app->request->get());

if ($filter->id) {
    $query->andWhere(['id' => $filter->id]);
}

?>

<? $form = \skeeks\cms\modules\admin\widgets\filters\AdminFiltersForm::begin([
    'action' => '/' . \Yii::$app->request->pathInfo,
]); ?>

<?= $form->field($filter, 'id')->label('ID')->setVisible(); ?>

<? $form::end(); ?>
