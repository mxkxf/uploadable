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
   * Create some dummy $uploadables.
   */
  private function setUploadables()
  {
    $this->model->setUploadables(['input_1', 'input_2']);
  }

  /**
   * Test that an exception is thrown for a Model which uses 
   * the trait but doesn't have an $uploadables property.
   */
  public function testThrowExceptionForEmptyOrNoUploadables()
  {
    $this->setExpectedException('MikeFrancis\Uploadable\NoUploadablesException');
    $this->model->performUploads();
  }

  /**
   * Test that a model's $uploadable array can only be 
   * a non-empty array.
   */
  public function testCheckUploadbalesCanOnlyBeNonEmptyArray() {
    $this->setUploadables();
    $uploadables = $this->model->getUploadables();
    $this->assertTrue(is_array($uploadables));
    $this->assertTrue(count($uploadables) > 0);
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
   * Create uploadables placeholder.
   * 
   * @var array
   */
  protected $uploadables;

}