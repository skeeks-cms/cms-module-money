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
                    'label'     => 'Валюты/деньги',
                    'priority'  => 0,

                    'items' =>
                    [
                        [
                            "label" => "Валюта",
                            "url"   => ["money/admin-currency"]
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