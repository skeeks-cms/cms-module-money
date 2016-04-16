<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 12.03.2015
 */
return
[
    'other' =>
    [
        'items' =>
        [
            [
                "label"     => \Yii::t('skeeks/money', 'Currency'),
                "img"       => ['\skeeks\modules\cms\money\assets\Asset', 'images/money_16_16.png'],

                'items' =>
                [
                    [
                        "label"     => \Yii::t('skeeks/money', 'Currency'),
                        "url"       => ["money/admin-currency"],
                        "img"       => ['\skeeks\modules\cms\money\assets\Asset', 'images/money_16_16.png']
                    ],

                    [
                        "label" => \Yii::t('app', 'Settings'),
                        "url"   => ["cms/admin-settings", "component" => 'skeeks\modules\cms\money\components\money\Money'],
                        "img"       => ['\skeeks\cms\modules\admin\assets\AdminAsset', 'images/icons/settings-big.png'],
                        "activeCallback"       => function(\skeeks\cms\modules\admin\helpers\AdminMenuItem $adminMenuItem)
                        {
                            return (bool) (\Yii::$app->request->getUrl() == $adminMenuItem->getUrl());
                        },
                    ],
                ]
            ],
        ]
    ]
];