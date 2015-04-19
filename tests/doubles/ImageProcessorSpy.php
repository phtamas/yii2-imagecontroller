<?php
namespace phtamas\yii2\imagecontroller\tests\doubles;

use phtamas\yii2\imageprocessor\Component;

class ImageProcessorSpy extends Component
{
    use TestSpyTrait;

    public function send($source, $type, $as = null)
    {
        $this->testSpyRecordMethodCall();
    }

    public function saveAndSend($source, $path, $type = null, $as = null)
    {
        $this->testSpyRecordMethodCall();
    }

}