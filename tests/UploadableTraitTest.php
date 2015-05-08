<?php

use \Mockery;
use MikeFrancis\Uploadable\UploadableTrait;

class UploadableTraitTest extends PHPUnit_Framework_TestCase {

  /**
   * Prepare tests.
   */
  public function setUp() {
    $this->model = Mockery::mock('UploadableModelStub');
  }

  /**
   * Clean up tests.
   */
  public function tearDown() {
    Mockery::close();
  }

  public function testItDoesSomething() {
    
  }

}

class UploadableModelStub {

  use UploadableTrait;

  protected $uploadable = ['input_1','input_2'];

}