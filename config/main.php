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
        'money' => [
            'class'         => 'skeeks\modules\cms\money\components\money\Money',
        ],

        'i18n' => [
            'translations' =>
            [
                'skeeks/money' => [
                    'class'             => 'yii\i18n\PhpMessageSource',
                    'basePath'          => '@skeeks/modules/cms/money/messages',
                    'fileMap' => [
                        'skeeks/money' => 'main.php',
                    ],
                ]
            ]
        ],
    ],

    'modules' =>
    [
        'money' => [
            'class'         => 'skeeks\modules\cms\money\Module',
        ]
    ]
];