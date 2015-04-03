<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.04.2015
 */
namespace skeeks\modules\cms\money\components\money;
use skeeks\cms\helpers\UrlHelper;
use skeeks\modules\cms\money\Currency;
use skeeks\modules\cms\shop\components\Cart;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class Money
 * @package skeeks\modules\cms\money\components\money
 */
class Money extends \skeeks\cms\base\Component
{
    /**
     * @var string
     */
    public $defaultCurrency                     = 'RUB';

    /**
     * @var string текущая валюта
     */
    public $currency                            = null;

    /**
     *
     */
    public function init()
    {
        parent::init();

        if ($this->currency === null)
        {
            $this->currency = $this->defaultCurrency;
        }
    }
    /**
     * Можно задать название и описание компонента
     * @return array
     */
    static public function getDescriptorConfig()
    {
        return
        [
            'name'          => 'Валюты и деньги',
        ];
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['defaultCurrency'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'defaultCurrency'                => 'Валюта по умолчанию',
        ]);
    }

    /**
     * Поиск активных валют
     *
     * @return ActiveQuery
     */
    public function findActiveCurrency()
    {
        return \skeeks\modules\cms\money\models\Currency::find()->where(['status' => 1]);
    }

    /**
     * Поиск активных валют
     *
     * @return \skeeks\modules\cms\money\models\Currency[]
     */
    public function fetchActiveCurrency()
    {
        return $this->findActiveCurrency()->all();
    }

    /**
     * @var null \skeeks\modules\cms\money\models\Currency[]
     */
    protected $_activeCurrency = null;

    /**
     * TODO: добавить кэширование
     * Получить список активных валют, 1 раз за сценарий
     *
     * @return \skeeks\modules\cms\money\models\Currency[]
     */
    public function getActiveCurrency()
    {
        if ($this->_activeCurrency === null)
        {
            $this->_activeCurrency = (array) $this->fetchActiveCurrency();
        }

        return $this->_activeCurrency;
    }

    /**
     * Объект текущей валюты
     *
     * @return Currency
     */
    public function currency()
    {
        return Currency::getInstance(\Yii::$app->money->currency);
    }

    /**
     * Новый объект денег с текущей валютой
     *
     * @param string $ammount
     * @return \skeeks\modules\cms\money\Money
     */
    public function newMoney($ammount = '0')
    {
        return \skeeks\modules\cms\money\Money::fromString((string) $ammount, $this->currency);
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
}