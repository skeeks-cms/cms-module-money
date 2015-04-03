<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.04.2015
 */
namespace skeeks\modules\cms\money\components\money;
use skeeks\cms\helpers\UrlHelper;
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
    public $defaultCurrency                  = 'RUB';

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
     * @return ActiveQuery
     */
    public function findActiveCurrency()
    {
        return \skeeks\modules\cms\money\models\Currency::find()->where(['status' => 1]);
    }

    /**
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

}