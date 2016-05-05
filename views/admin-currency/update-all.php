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
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\Game */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<? \skeeks\cms\modules\admin\widgets\ActiveForm::begin([
    'method' => 'post'
]); ?>
<p><?=\Yii::t('skeeks/money','Filling database in all possible currencies');?></p>
<button class="btn-primary"><?=\Yii::t('skeeks/money','Get data');?></button>
<? \skeeks\cms\modules\admin\widgets\ActiveForm::end(); ?>