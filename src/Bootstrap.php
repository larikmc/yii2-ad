<?php

namespace larikmc\ad;

use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $app->controllerMap['migrate']['migrationNamespaces'][] = 'larikmc\ad\migrations';
        }
    }
}
