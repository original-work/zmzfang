<?php
$config = [
    // 'defaultRoute' => 'Login',

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'utXibJrENeZ-tMG3Cq41n_oLR9D39j4l',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs'=>array('127.0.0.1','::1','139.196.105.189'), 
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs'=>array('127.0.0.1','::1','139.196.105.189'),
    ];
}

return $config;
