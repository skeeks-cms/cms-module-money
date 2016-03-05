<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.03.2015
 */
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\WidgetConfig */
?>


<?= $form->fieldSet(\Yii::t('app', 'Main')); ?>

    <?= $form->fieldSelect($model, 'currencyCode', \yii\helpers\ArrayHelper::map(
        \skeeks\modules\cms\money\models\Currency::find()->active()->all(),
        'code',
        function($model)
        {
            return "{$model->name} [{$model->code}]";
        }
    )); ?>

    <?
        echo $form->field($model, 'markupOnUpdate');
    ?>
<?= $form->fieldSetEnd(); ?>



