<?php
/**
 * index
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 30.10.2014
 * @since 1.0.0
 */
use skeeks\cms\modules\admin\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\Game */
/* @var $dataProvider yii\data\ActiveDataProvider */

$dataProvider->sort->defaultOrder = [
    'status' => SORT_ASC
];

?>

<?= GridView::widget([
    'dataProvider'  => $dataProvider,
    'filterModel'   => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'class'         => \skeeks\cms\modules\admin\grid\ActionColumn::className(),
            'controller'    => $controller
        ],

        ///['class' => \skeeks\cms\grid\ImageColumn::className()],

        'code',
        'course',
        'name',
        'name_full',
        ['class' => \skeeks\cms\grid\StatusColumn::className()],

        //['class' => \skeeks\cms\grid\UpdatedAtColumn::className()],

       // ['class' => \skeeks\cms\grid\UpdatedByColumn::className()],
    ],
]); ?>
