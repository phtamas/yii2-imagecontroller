<?php
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/vendor/yiisoft/yii2/Yii.php';
Yii::setAlias('@tests', __DIR__);
new yii\web\Application([
    'id' => '',
    'basePath' => '',

    'components' => [

        'imageProcessor' => [
            'class' => 'phtamas\yii2\imageprocessor\Component',
        ],
    ],
]);

