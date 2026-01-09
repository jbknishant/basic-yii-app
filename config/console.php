<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/modules/user/mail',
            'useFileTransport' => false,

            // local test configuration
            // 'transport' => [
            //     'dsn' => 'smtp://user:pass@smtp.example.com:465',
            // ],
            // live test configuration
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'live.smtp.mailtrap.io',
                'username' => 'api',
                'password' => 'e965516a326d746c0d820ed1b22026d5',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => yii\log\FileTarget::class,
                    'categories' => ['user-cron-success'],
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/user-cron-success.log',
                ],
                [
                    'class' => yii\log\FileTarget::class,
                    'categories' => ['user-cron-failed', 'user-cron-error'],
                    'levels' => ['error'],
                    'logFile' => '@runtime/logs/user-cron-failed.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
    // configuration adjustments for 'dev' environment
    // requires version `2.1.21` of yii2-debug module
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
