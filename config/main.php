<?php
/**
 * main
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 25.01.2015
 * @since 1.0.0
 */
return [
    'components' =>
    [
        'adminMenu' =>
        [
            'groups' =>
            [
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
            ]
        ]
    ],

    'modules' =>
    [
        'money' => [
            'class'         => \skeeks\modules\cms\money\Module::className(),
        ]
    ]
];