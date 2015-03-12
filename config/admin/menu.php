<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 12.03.2015
 */
return [
    'money' =>
    [
        'label'     => 'Валюты и деньги',
        'priority'  => 0,

        'items' =>
        [
            [
                "label"     => "Список валют",
                "url"       => ["money/admin-currency"],
                "img"       => [\skeeks\modules\cms\money\assets\Asset::className(), 'images/money_16_16.png']
            ],
        ]
    ]
];