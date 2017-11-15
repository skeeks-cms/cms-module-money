<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.04.2015
 */
namespace skeeks\modules\cms\money\components\money;
use skeeks\cms\components\Cms;
use skeeks\cms\helpers\UrlHelper;
use skeeks\cms\models\CmsAgent;
use skeeks\modules\cms\money\Currency;
use skeeks\modules\cms\money\ExchangeRatesCBRF;
use skeeks\modules\cms\shop\components\Cart;
use yii\base\Event;
use yii\console\Application;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class Money
 * @package skeeks\modules\cms\money\components\money
 */
class Money extends \skeeks\cms\base\Component
{
    /**
     * @var string текущая валюта
     */
    public $currencyCode                         = 'RUB';

    /**
     * @var float Наценка в момент обновления
     */
    public $markupOnUpdate                       = 0;


    /**
     * Можно задать название и описание компонента
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name'          => \Yii::t('skeeks/money','Currency and Money'),
        ]);
    }


    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['currencyCode'], 'string'],
            [['markupOnUpdate'], 'number'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'currencyCode'                => \Yii::t('skeeks/money','Default currency'),
            'markupOnUpdate'              => \Yii::t('skeeks/money','Mark-up at the time of update'),
        ]);
    }
    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'markupOnUpdate'              => \Yii::t('skeeks/money','In the process of updating the data currency, this mark-up will be added to price, specify a percentage').' (%)',
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo \Yii::$app->view->renderFile(__DIR__ . '/_form.php', [
            'form'  => $form,
            'model' => $this
        ], $this);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getActiveCurrencies()
    {
        return \skeeks\modules\cms\money\models\Currency::find()->active()->all();
    }

    /**
     * Объект текущей валюты
     *
     * @return Currency
     */
    public function getCurrencyObject()
    {
        return Currency::getInstance(\Yii::$app->money->currencyCode);
    }

    /**
     * Новый объект денег с текущей валютой
     *
     * @param string $ammount
     * @return \skeeks\modules\cms\money\Money
     */
    public function newMoney($ammount = '0', $currency = null)
    {
        if ($currency === null)
        {
            $currency = $this->currencyCode;
        }
        return \skeeks\modules\cms\money\Money::fromString((string) $ammount, $currency);
    }

    static public $lanquages = [];

    /**
     * Объект IntlFormatter 1 раз за сценарий
     *
     * @param null $language
     * @return \skeeks\modules\cms\money\IntlFormatter
     */
    public function intlFormatter($language = null)
    {
        if ($language === null)
        {
            $language = \Yii::$app->language;
        }

        if (isset(self::$lanquages[$language]))
        {
            return self::$lanquages[$language];
        }

        $formatter = new \skeeks\modules\cms\money\IntlFormatter($language);

        self::$lanquages[$language] = $formatter;
        return $formatter;
    }


    /**
     * Сконвертировать и отформатировать для текущих настроек
     *
     * @param \skeeks\modules\cms\money\Money $money
     * @param null $language
     * @param null $currency
     * @return string
     */
    public function convertAndFormat(\skeeks\modules\cms\money\Money $money, $language = null, $currency = null)
    {
        if (!$currency)
        {
            $currency = $this->currencyCode;
        }

        $convertedMoney = $money->convertToCurrency($currency);

        return $this->intlFormatter($language)->format($convertedMoney);
    }

    /**
     * @return $this
     */
    public function processUpdateCourses()
    {
        $cbrf = new ExchangeRatesCBRF();
        $data = $cbrf->GetRates();

        if ($data['byChCode'])
        {
            foreach ($data['byChCode'] as $code => $value)
            {
                if ($currency = \skeeks\modules\cms\money\models\Currency::find()->where(['code' => $code])->one())
                {
                    //TODO: хардкод (
                    if ($currency->code != "RUB")
                    {
                        $currency->course = $value + ($value * $this->markupOnUpdate/100); //+наценка
                    } else
                    {
                        $currency->course = $value; //+наценка
                    }

                    $currency->save(false);
                }
            }
        }

        return $this;
    }
}