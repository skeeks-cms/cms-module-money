<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 12.03.2015
 */
return
[
    'finance' =>
    [
        'label' => \Yii::t('skeeks/money', 'Finance'),
        "img"       => ['skeeks\modules\cms\money\assets\Asset', 'icons/money-bag.png'],
        'priority'  => 300,

        'items' =>
        [
            [
                "label"     => \Yii::t('skeeks/money/meny', 'Currency'),
                "img"       => ['\skeeks\modules\cms\money\assets\Asset', 'images/money_16_16.png'],
                'priority'  => 600,

                'items' =>
                [
                    [
                        "label"     => \Yii::t('skeeks/money/meny', 'Currency'),
                        "url"       => ["money/admin-currency"],
                        "img"       => ['\skeeks\modules\cms\money\assets\Asset', 'images/money_16_16.png']
                    ],

                    [
                        "label" => \Yii::t('skeeks/money', 'Settings'),
                        "url"   => ["cms/admin-settings", "component" => 'skeeks\modules\cms\money\components\money\Money'],
                        "img"       => ['\skeeks\cms\modules\admin\assets\AdminAsset', 'images/icons/settings-big.png'],
                        "activeCallback"       => function($adminMenuItem)
                        {
                            return (bool) (\Yii::$app->request->getUrl() == $adminMenuItem->getUrl());
                        },
                    ],
                ]
            ],
        ]
    ]
];