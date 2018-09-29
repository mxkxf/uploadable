<?php

namespace MikeFrancis\Uploadable\Tests;

use MikeFrancis\Uploadable\Uploadable;
use PHPUnit\Framework\TestCase;

class UploadableTest extends TestCase
{
    public function testFoo()
    {
        $model = new class() {
            use Uploadable;


        };

        $model->performUploads();
    }
}
