<?php

declare(strict_types=1);

namespace larikmc\ad\helpers;

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

class ViewHelper
{
    /**
     * Standard ActionColumn compatible with admin-ui-kit and fallback environments
     *
     * @param array $config
     * @return array
     */
    public static function actionColumn(array $config = []): array
    {
        if (class_exists('\\backend\\helpers\\ModelViewHelper') && method_exists('\\backend\\helpers\\ModelViewHelper', 'actionColumn')) {
            return \backend\helpers\ModelViewHelper::actionColumn($config);
        }

        $template = $config['template'] ?? '<div class="action-column">{update} {delete}</div>';
        $options = $config['options'] ?? ['style' => 'width:90px; text-align:center; white-space:nowrap;'];
        $urlCreator = $config['urlCreator'] ?? null;

        return [
            'class' => ActionColumn::class,
            'template' => $template,
            'options' => $options,
            'buttons' => [
                'update' => static function ($url, $model, $key) use ($urlCreator) {
                    $targetUrl = is_callable($urlCreator) ? $urlCreator('update', $model, $key) : ['update', 'id' => $model->id];
                    return Html::a(
                        '<span class="material-symbols-rounded" style="font-size:18px;vertical-align:middle;">edit</span>',
                        $targetUrl,
                        [
                            'class' => 'sz-row-action',
                            'title' => 'Редактировать',
                            'aria-label' => 'Редактировать',
                            'data-pjax' => '0',
                        ]
                    );
                },
                'delete' => static function ($url, $model, $key) use ($urlCreator) {
                    $targetUrl = is_callable($urlCreator) ? $urlCreator('delete', $model, $key) : ['delete', 'id' => $model->id];
                    return Html::a(
                        '<span class="material-symbols-rounded" style="font-size:18px;vertical-align:middle;">delete</span>',
                        $targetUrl,
                        [
                            'class' => 'sz-row-action sz-row-action--danger',
                            'title' => 'Удалить',
                            'aria-label' => 'Удалить',
                            'data-confirm' => 'Вы уверены, что хотите удалить эту запись?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]
                    );
                },
            ],
        ];
    }
}
