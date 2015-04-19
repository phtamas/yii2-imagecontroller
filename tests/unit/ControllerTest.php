<?php
namespace phtamas\yii2\imagecontroller\tests\unit;

use phtamas\yii2\imagecontroller\Action;
use phtamas\yii2\imagecontroller\Controller;

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testActions()
    {
        $controller = new Controller('image', \Yii::$app);
        $controller->imageProcessor = 'imageProcessor';
        $controller->actions = [
            'action-id' => [
                'sourceDir' => '@tests/files/source',
                'destinationDir' => '@tests/files/destination',
                'save' => true,
            ],
        ];
        $actions = $controller->actions();

        $this->assertArrayHasKey('action-id', $actions);

        $this->assertInternalType('array', $actions['action-id']);
        $this->assertArrayHasKey('class', $actions['action-id']);
        $this->assertEquals(Action::className(), $actions['action-id']['class']);

        $this->assertArrayHasKey('sourceDir', $actions['action-id']);
        $this->assertEquals('@tests/files/source', $actions['action-id']['sourceDir']);

        $this->assertArrayHasKey('destinationDir', $actions['action-id']);
        $this->assertEquals('@tests/files/destination', $actions['action-id']['destinationDir']);

        $this->assertArrayHasKey('save', $actions['action-id']);
        $this->assertTrue($actions['action-id']['save']);

        $this->assertArrayHasKey('imageProcessor', $actions['action-id']);
        $this->assertSame(\Yii::$app->imageProcessor, $actions['action-id']['imageProcessor']);
    }

    public function testActionsWithDefaultSave()
    {
        $controller = new Controller('image', \Yii::$app);
        $controller->imageProcessor = 'imageProcessor';
        $controller->save = true;
        $controller->actions = [
            'action-id' => [],
        ];
        $actions = $controller->actions();

        $this->assertArrayHasKey('save', $actions['action-id']);
        $this->assertTrue($actions['action-id']['save']);
    }
}