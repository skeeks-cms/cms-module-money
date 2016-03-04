<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 15.06.2015
 */
return [
    'components' =>
    [
        'money' => [
            'class'         => 'skeeks\modules\cms\money\components\money\Money',
        ]
    ],

    'modules' =>
    [
        'money' => [
            'class'         => 'skeeks\modules\cms\money\ConsoleModule',
        ]
    ]
];