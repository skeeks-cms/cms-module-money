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

use skeeks\cms\base\db\ActiveRecord;
use skeeks\cms\models\behaviors\HasDescriptionsBehavior;
use skeeks\cms\models\behaviors\HasStatus;

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
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            HasStatus::className() => HasStatus::className(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['code'], 'required'],
            [['code'], 'unique'],
            [['status', 'course', 'name', 'name_full'], 'safe'],
        ]);
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return  array_merge(parent::attributeLabels(), [
            'id'        => \Yii::t('app', 'ID'),
            'code'      => \Yii::t('app', 'Code'),
            'status'    => \Yii::t('app', 'Status'),
            'course'    => \Yii::t('app', 'Course'),
            'name'      => \Yii::t('app', 'Name'),
        ]);
    }

}