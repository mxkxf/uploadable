<?php

use \Mockery;
// use \Illuminate\Database\Eloquent\Model;
use MikeFrancis\Uploadable\UploadableTrait;

class UploadableTraitTest extends PHPUnit_Framework_TestCase {

  /**
   * Prepare tests.
   */
  public function setUp() {
    $this->model = Mockery::mock('UploadableModelStub');
    $this->model->makePartial();
  }

  /**
   * Clean up tests.
   */
  public function tearDown() {
    Mockery::close();
  }

  public function test_it_checks_uploadables_can_only_be_an_array() {
    $uploadables = $this->model->getUploadables();
    $this->assertTrue(is_array($uploadables));
  }

}

class UploadableModelStub {

  use UploadableTrait;

  protected $uploadables = ['input_1','input_2'];

}