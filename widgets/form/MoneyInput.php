<?php
/**
 * MoneyInput
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */
namespace skeeks\modules\cms\money\widgets\form;

use Yii;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;
use yii\widgets\MaskedInputAsset;

/**
 * Class MoneyInput
 * @package skeeks\modules\cms\money\widgets\form
 */
class MoneyInput extends InputWidget
{
    /**
     * @var array
     */
    public $clientOptions = [];

    public $fieldNameAmmount        = 'ammount';
    public $fieldNameCurrency       = 'currency';

    public $name                    = '';

    private function _initAndValidate()
    {
        if (!$this->hasModel())
        {
            throw new Exception("Этот файл рассчитан только для форм с моделью");
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        try
        {
            $this->_initAndValidate();
            $this->registerClientScript();

            $id         = "sx-id-" . Yii::$app->security->generateRandomString(6);

            $clientOptions = ArrayHelper::merge($this->clientOptions, [
                'fieldNameAmmount'      => $this->fieldNameAmmount,
                'fieldNameCurrency'     => $this->fieldNameCurrency,

                'backend'        => \skeeks\cms\helpers\UrlHelper::construct('money/ajax/data')->toString(),
            ]);

            return $this->render('money-input', [
                'widget'            => $this,
                'id'                => $id,
                'model'             => $this->model,
                'clientOptions'     => $clientOptions,

                'fieldNameAmmount'          => $this->fieldNameAmmount,
                'fieldNameCurrency'         => $this->fieldNameCurrency,
            ]);

        } catch (Exception $e)
        {
            echo $e->getMessage();
        }

    }

    /**
     * Registers Bootstrap File Input plugin
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        MaskedInputAsset::register($view);
    }
}
