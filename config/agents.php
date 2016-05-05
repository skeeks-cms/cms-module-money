<?php
return [
    'money/agents/update-courses' =>
    [
        'description'       => \Yii::t('skeeks/money','Updating currency rate'),
        'agent_interval'    => 3600*12, //раз в 12 часов
        'next_exec_at'      => \Yii::$app->formatter->asTimestamp(time()) + 3600*12,
        'is_period'         => "N"
    ]
];