<?php
namespace phtamas\yii2\imagecontroller;

use yii\base\Action as BaseAction;
use yii\web\NotFoundHttpException;

class Action extends BaseAction
{
    /**
     * @var \phtamas\yii2\imageprocessor\Component
     */
    public $imageProcessor;

    /**
     * @var string
     */
    public $sourceDir;

    /**
     * @var bool
     */
    public $save = false;

    /**
     * @var null|string
     */
    public $destinationDir;

    public function run($filename)
    {
        $filename = basename($filename);
        $sourcePath = \Yii::getAlias($this->sourceDir) . '/' . $filename;
        if (!is_file($sourcePath)) {
            throw new NotFoundHttpException();
        }
        if ($this->save) {
            $this->imageProcessor->saveAndSend(
                \Yii::getAlias($this->sourceDir) . '/' . $filename,
                \Yii::getAlias($this->destinationDir) . '/' . $filename,
                pathinfo($filename, PATHINFO_EXTENSION),
                $this->id
            );
        } else {
            $this->imageProcessor->send(
                \Yii::getAlias($this->sourceDir) . '/' . $filename,
                pathinfo($filename, PATHINFO_EXTENSION),
                $this->id
            );
        }
    }
}