<?php
namespace phtamas\yii2\imagecontroller\tests\unit;

use PHPUnit_Framework_TestCase;
use phtamas\yii2\imagecontroller\Action;
use phtamas\yii2\imagecontroller\tests\doubles\ControllerDummy;
use phtamas\yii2\imagecontroller\tests\doubles\ImageProcessorSpy;

class ActionTest extends PHPUnit_Framework_TestCase
{

    public function testNonexistentSourceImage()
    {
        $action = new Action('action-id', new ControllerDummy());
        $action->sourceDir = '@tests/files/source';
        $this->setExpectedException('yii\web\NotFoundHttpException');
        $action->run('non-existent-image.jpg');
    }

    public function testNoSave()
    {
        $imageProcessorSpy = new ImageProcessorSpy();
        $action = new Action('action-id', new ControllerDummy());
        $action->sourceDir = '@tests/files/source';
        $action->imageProcessor = $imageProcessorSpy;
        $action->run('test.jpg');
        $this->assertEquals(
            [
                'methodName' => 'send',
                'arguments' => [
                    \Yii::getAlias('@tests/files/source') . '/test.jpg',
                    'jpg',
                    'action-id',
                ]
            ],
            $imageProcessorSpy->testSpyGetMethodCallAtPosition(1)
        );
    }

    public function testSave()
    {
        $imageProcessorSpy = new ImageProcessorSpy();
        $action = new Action('action-id', new ControllerDummy());
        $action->sourceDir = '@tests/files/source';
        $action->destinationDir = '@tests/files/destination';
        $action->save = true;
        $action->imageProcessor = $imageProcessorSpy;
        $action->run('test.jpg');
        $this->assertEquals(
            [
                'methodName' => 'saveAndSend',
                'arguments' => [
                    \Yii::getAlias('@tests/files/source') . '/test.jpg',
                    \Yii::getAlias('@tests/files/destination') . '/test.jpg',
                    'jpg',
                    'action-id',
                ]
            ],
            $imageProcessorSpy->testSpyGetMethodCallAtPosition(1)
        );
    }

    public function testWithMaliciousFilename()
    {
        $imageProcessorSpy = new ImageProcessorSpy();
        $action = new Action('action-id', new ControllerDummy());
        $action->sourceDir = '@tests/files/source';
        $action->imageProcessor = $imageProcessorSpy;
        $action->run('../test.jpg');
        $this->assertEquals(
            [
                'methodName' => 'send',
                'arguments' => [
                    \Yii::getAlias('@tests/files/source') . '/test.jpg',
                    'jpg',
                    'action-id',
                ]
            ],
            $imageProcessorSpy->testSpyGetMethodCallAtPosition(1)
        );
    }

    protected function setUp()
    {
        parent::setUp();
        foreach (glob(\Yii::getAlias('@tests/files/destination') . '/*.jpg') as $filename){
            unlink($filename);
        }
    }
}