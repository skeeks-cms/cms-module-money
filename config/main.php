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
        ]
    ],

    'modules' =>
    [
        'money' => [
            'class'         => 'skeeks\modules\cms\money\Module',
        ]
    ]
];