<?php

use \Mockery;
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

  /**
   * Test that a model's $uploadable array can only be
   * a non-empty array.
   */
  public function testCheckUploadbalesCanOnlyBeNonEmptyArray() {
    $uploadables = $this->model->getUploadables();
    $this->assertTrue(is_array($uploadables));
    $this->assertTrue(count($uploadables));
  }

}

/**
 * Model stub for tests.
 */
class UploadableModelStub {

  /**
   * Use the uploadable trait.
   */
  use UploadableTrait;

  /**
   * Assign some dummy fields.
   * 
   * @var array
   */
  protected $uploadables = ['input_1','input_2'];

}