<?php

namespace app\modules\user;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\user\controllers';

    public function init()
    {
        parent::init();

        // This is required to make console commands work
        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\user\commands';
        }
    }
}