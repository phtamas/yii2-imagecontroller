<?php
namespace phtamas\yii2\imagecontroller;

use yii\web\Controller as ControllerBase;

class Controller extends ControllerBase
{
    /** @var array  */
    public $actions = [];

    /** @var  string */
    public $imageProcessor;

    /** @var bool  */
    public $save = false;

    public function actions()
    {
        $imageProcessor = \Yii::$app->get('imageProcessor');
        $actions = [];
        foreach ($this->actions as $id => $actionConfiguration) {
            $action = [
                'class' => Action::className(),
                'imageProcessor' => $imageProcessor,
            ];
            if (isset($actionConfiguration['sourceDir'])) {
                $action['sourceDir'] = $actionConfiguration['sourceDir'];
            }
            if (isset($actionConfiguration['destinationDir'])) {
                $action['destinationDir'] = $actionConfiguration['destinationDir'];
            }
            if (isset($actionConfiguration['save'])) {
                $action['save'] = $actionConfiguration['save'];
            } else {
                $action['save'] = $this->save;
            }
            $actions[$id] = $action;
        }
        return $actions;
    }
}