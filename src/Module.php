<?php

declare(strict_types=1);

namespace larikmc\ad;

use Yii;
use yii\base\Module as BaseModule;
use yii\filters\AccessControl;

/**
 * Advertising banners and positions management module for Yii2.
 *
 * @author LarikMC <https://64web.ru>
 * @license MIT
 */
class Module extends BaseModule
{
    public const VERSION = '1.1.0';

    /**
     * @var string Controller namespace for this module.
     */
    public $controllerNamespace = 'larikmc\ad\controllers';

    /**
     * @var string Default route.
     */
    public $defaultRoute = 'ad/index';

    /**
     * @var array Allowed roles for AccessControl.
     * Set to empty array [] to bypass module-level AccessControl if handled globally.
     */
    public array $accessRoles = ['admin', 'adminPanel'];

    /**
     * @var string|null Optional RBAC permission name (e.g. 'manageAds').
     */
    public ?string $accessPermission = null;

    /**
     * @var int Cache duration in seconds for ad queries.
     */
    public int $cacheDuration = 3600;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        if (!empty($this->accessRoles) || $this->accessPermission !== null) {
            $rule = ['allow' => true];

            if ($this->accessPermission !== null) {
                $rule['permissions'] = [$this->accessPermission];
            } elseif (!empty($this->accessRoles)) {
                $rule['roles'] = $this->accessRoles;
            }

            $behaviors['access'] = [
                'class' => AccessControl::class,
                'rules' => [$rule],
            ];
        }

        return $behaviors;
    }
}
