<?php
/**
 * money-input
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */

/**
 * @var \skeeks\modules\cms\money\widgets\form\MoneyInput $widget
 * @var \skeeks\cms\base\db\ActiveRecord $model
 * @var $this yii\web\View
 */

$clientOptionsJson = \yii\helpers\Json::encode($clientOptions);


?>
<div id="<?= $id; ?>" class="sx-widget-form-elements-money">
    <div class="row">
        <div class="col-lg-3">
            <?= \yii\helpers\Html::activeTextInput($model, $widget->fieldNameAmmount, ['class' => 'form-control']); ?>
        </div>

        <div class="col-lg-1">
            <? echo \skeeks\widget\chosen\Chosen::widget([
                    'model'     => $model,
                    'attribute' => $widget->fieldNameCurrency,
                    'items'     => \yii\helpers\ArrayHelper::map(
                        \skeeks\modules\cms\money\models\Currency::find()->where(['status' => \skeeks\cms\models\behaviors\HasStatus::STATUS_ACTIVE])->all(),
                        'code', 'code'
                    )
                ]);
            ?>
        </div>
    </div>
</div>

<?= $this->registerJs(<<<JS
    (function(sx, $, _)
    {
        sx.createNamespace('classes.widgets', sx);

        sx.classes.widgets.MoneyInput = sx.classes.Widget.extend({

            _init: function()
            {},

            _onDomReady: function()
            {
            },
            _onWindowReady: function()
            {}
        });

        new sx.classes.widgets.MoneyInput('#{$id}', {$clientOptionsJson});
    })(sx, sx.$, sx._);
JS
)?>