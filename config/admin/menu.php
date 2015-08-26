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
                "label"     => "Валюты",
                "img"       => ['\skeeks\modules\cms\money\assets\Asset', 'images/money_16_16.png'],

                'items' =>
                [
                    [
                        "label"     => "Валюты",
                        "url"       => ["money/admin-currency"],
                        "img"       => ['\skeeks\modules\cms\money\assets\Asset', 'images/money_16_16.png']
                    ],

                    [
                        "label" => "Настройки",
                        "url"   => ["cms/admin-settings", "component" => 'skeeks\modules\cms\money\components\money\Money'],
                        "img"       => ['\skeeks\cms\modules\admin\assets\AdminAsset', 'images/icons/settings.png'],
                    ],
                ]
            ],
        ]
    ]
];