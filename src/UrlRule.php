<?php
namespace phtamas\yii2\imagecontroller;

use yii\web\CompositeUrlRule;

class UrlRule extends CompositeUrlRule
{
    /**
     * @var string
     */
    public $controllerId;

    public $prefix;

    protected function createRules()
    {
        $rules = [];
        $controller = \Yii::$app->createController($this->controllerId)[0];
        /* @var $controller Controller */
        foreach ($controller->actions as $id => $action) {
            $rules[$this->prefix . '/' . $id . '/<filename>'] = [$this->controllerId . '/' . $id];
        }
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request)
    {
        if (strpos($request->pathInfo . '/', $this->prefix . '/') === 0) {
            return parent::parseRequest($manager, $request);
        } else {
            return false;
        }
    }

    public function createUrl($manager, $route, $params)
    {
        if (strpos($route, $this->controllerId . '/') === 0) {
            return parent::createUrl($manager, $route, $params);
        } else {
            return false;
        }
    }
}