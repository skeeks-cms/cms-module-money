<?php
/**
 * Currency
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */
namespace skeeks\modules\cms\money\models;

use skeeks\cms\query\CmsActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Currency
 * @package skeeks\modules\cms\money\models
 */
class Currency extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%money_currency}}';
    }

    /**
     * @return CmsActiveQuery
     */
    public static function find()
    {
        return new CmsActiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), []);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['code'], 'required'],
            [['code'], 'unique'],
            [['code'], 'validateCode'],
            [['priority'], 'integer'],
            [['active'], 'string'],
            [['course'], 'number'],
            [['name', 'name_full'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return  array_merge(parent::attributeLabels(), [
            'id'            => \Yii::t('skeeks/money', 'ID'),
            'code'          => \Yii::t('skeeks/money', "Currency"),
            'active'        => \Yii::t('skeeks/money', 'Active'),
            'course'        => \Yii::t('skeeks/money', "Rate"),
            'name'          => \Yii::t('skeeks/money', "Name"),
            'name_full'     => \Yii::t('skeeks/money', "Full name"),
            'priority'      => \Yii::t('skeeks/money', 'Priority'),
        ]);
    }


    public function validateCode($attribute)
    {
        if(!preg_match('/^[A-Z]{3}$/', $this->$attribute))
        {
            $this->addError($attribute, \Yii::t('skeeks/money','Use only uppercase letters. Example RUB (3 characters)'));
        }
    }

}