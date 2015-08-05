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
        $sourceDir = \Yii::getAlias($this->sourceDir);
        $destinationDir = \Yii::getAlias($this->destinationDir);
        $sourcePath = $sourceDir . '/' . $filename;
        if (!is_file($sourcePath)) {
            throw new NotFoundHttpException();
        }
        if ($this->save) {
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0777, true);
            }
            $this->imageProcessor->saveAndSend(
                $sourcePath,
                $destinationDir . '/' . $filename,
                pathinfo($filename, PATHINFO_EXTENSION),
                $this->id
            );
        } else {
            $this->imageProcessor->send(
                $sourcePath,
                pathinfo($filename, PATHINFO_EXTENSION),
                $this->id
            );
        }
    }
}