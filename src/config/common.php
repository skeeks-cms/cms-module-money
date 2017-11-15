<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 15.06.2015
 */
return [
    'components' => [
        'cmsAgent' => [
            'commands' => [
                'money/agents/update-courses' => [
                    'class' => \skeeks\cms\agent\CmsAgent::class,
                    'name' => ['skeeks/money', 'Updating currency rate'],
                    'interval' => 3600 * 12,
                ],
            ]
        ],
    ],
];