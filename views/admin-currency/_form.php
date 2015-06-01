<?php

use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\ActiveForm;
use skeeks\cms\models\Tree;

/* @var $this yii\web\View */
/* @var $model Tree */

?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'code')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'course')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'name_full')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'priority')->textInput(['maxlength' => 11]) ?>
<?= $form->fieldRadioListBoolean($model, 'active'); ?>

<?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>