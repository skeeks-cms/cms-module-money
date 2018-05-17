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
 * @deprecated
 */
class Money extends \skeeks\cms\money\MoneyComponent
{
    /**
     * @deprecated
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getActiveCurrencies()
    {
        return \skeeks\modules\cms\money\models\Currency::find()->active()->all();
    }

    /**
     * @deprecated
     *
     * Объект текущей валюты
     *
     * @return Currency
     */
    public function getCurrencyObject()
    {
        return Currency::getInstance(\Yii::$app->money->currencyCode);
    }

    /**
     * @deprecated
     *
     * Новый объект денег с текущей валютой
     *
     * @param string $ammount
     * @return \skeeks\modules\cms\money\Money
     */
    public function newMoney($ammount = '0', $currency = null)
    {
        if ($currency === null) {
            $currency = $this->currencyCode;
        }
        return \skeeks\modules\cms\money\Money::fromString((string)$ammount, $currency);
    }

    static public $lanquages = [];

    /**
     * @deprecated
     *
     * Объект IntlFormatter 1 раз за сценарий
     *
     * @param null $language
     * @return \skeeks\modules\cms\money\IntlFormatter
     */
    public function intlFormatter($language = null)
    {
        if ($language === null) {
            $language = \Yii::$app->language;
        }

        if (isset(self::$lanquages[$language])) {
            return self::$lanquages[$language];
        }

        $formatter = new \skeeks\modules\cms\money\IntlFormatter($language);

        self::$lanquages[$language] = $formatter;
        return $formatter;
    }


    /**
     * @deprecated
     *
     * Сконвертировать и отформатировать для текущих настроек
     *
     * @param \skeeks\cms\money\Money $money
     * @param null $language
     * @param null $currency
     * @return string
     */
    public function convertAndFormat($money, $language = null, $currency = null)
    {
        if (!$currency) {
            $currency = $this->currencyCode;
        }

        $convertedMoney = $money->convertToCurrency($currency);

        return $this->intlFormatter($language)->format($convertedMoney);
    }

    /**
     * @deprecated
     *
     * @return $this
     */
    public function processUpdateCourses()
    {
        $cbrf = new ExchangeRatesCBRF();
        $data = $cbrf->GetRates();

        if ($data['byChCode']) {
            foreach ($data['byChCode'] as $code => $value) {
                if ($currency = \skeeks\modules\cms\money\models\Currency::find()->where(['code' => $code])->one()) {
                    //TODO: хардкод (
                    if ($currency->code != "RUB") {
                        $currency->course = $value + ($value * $this->markupOnUpdate / 100); //+наценка
                    } else {
                        $currency->course = $value; //+наценка
                    }

                    $currency->save(false);
                }
            }
        }

        return $this;
    }
}